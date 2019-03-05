<?php

namespace App\Command;

use App\Service\MogNet\Messages\Author;
use App\Service\MogNet\Messages\Embed;
use App\Service\MogNet\Messages\Field;
use App\Service\MogNet\Messages\Image;
use App\Service\MogNet\Messages\Text;
use App\Service\MogNet\MogNet;
use App\Service\MogNet\MogRest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MogCommand extends Command
{
    /** @var MogRest */
    private $mog;

    public function __construct(MogRest $mog)
    {
        parent::__construct();

        $this->mog = $mog;
    }

    protected function configure()
    {
        $this->setName('MogCommand');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = new Embed(
            'Alert: [name of alert]',
            '#6eff5b',
            'The alert for: [id] [name] has been triggered',
            [
                new Field('Condition', 'MinItemUnitPrice < 1000'),
                new Field('Result', '800'),
            ],
            'mogboard.com',
            new Image('https://xivapi.com/i2/ls2/23791.png'),
            null,
            'https://beta.mogboard.com',
            new Author('MOGBOARD ALERT', 'https://beta.mogboard.com/favicon.png')
        );

        // $message = new Text('hello world!');

        $this->mog->dm('42667995159330816', $message);
    }
}
