<?php

namespace App\Command;

use App\Service\MogNet\Messages\Embed;
use App\Service\MogNet\MogRest;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommitChangesCommand extends Command
{
    /** @var MogRest */
    private $mogRest;

    public function __construct(MogRest $mogRest, $name = null)
    {
        $this->mogRest = $mogRest;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('ListCommitChangesCommand')
            ->setDescription('Post code changes to discord');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // grab xivapi version
        $xivapiRemote = json_decode(file_get_contents('http://xivapi.com/version'));
        $xivapiLocal = json_decode(file_get_contents(__DIR__.'/ListCommitChangesCommand.txt'));

        // if remote and local are same, do nothing
        if ($xivapiRemote->hash == $xivapiLocal->hash) {
            return;
        }

        // connect to BitBucket
        $oAuthParams = [
            'oauth_consumer_key'    => getenv('BB_OAUTH_CONSUMER_KEY'),
            'oauth_consumer_secret' => getenv('BB_OAUTH_CONSUMER_SECRET')
        ];

        $commits = new \Bitbucket\API\Repositories\Commits();
        $commits->getClient()->addListener(
            new \Bitbucket\API\Http\Listener\OAuthListener($oAuthParams)
        );

        $commits = $commits->all('dalamud', 'xivapi');
        $commits = json_decode($commits->getContent())->values;

        $list = [];
        foreach ($commits as $commit) {
            $message = trim($commit->summary->raw);

            $list[] = "- {$message}\n";

            // break if we're up to date on our local hash, end
            if ($commit->hash == $xivapiLocal->hash) {
                break;
            }
        }

        $date = (new Carbon($commits[0]->date))->fromNow();
        $embed = new Embed(
            "Code Changes:  {$xivapiLocal->version} → {$xivapiRemote->version}    ({$date})",
            '9c5bf7',
            implode($list)
        );

        // post to #git-alerts channel
        $this->mogRest->message("474519301865340938", $embed);

        // save
        file_put_contents(__DIR__.'/ListCommitChangesCommand.txt', json_encode($xivapiRemote, JSON_PRETTY_PRINT));
    }
}
