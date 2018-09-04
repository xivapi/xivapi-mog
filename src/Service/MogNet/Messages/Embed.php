<?php

namespace App\Service\MogNet\Messages;

use CharlotteDunois\Yasmin\Models\MessageEmbed;

/**
 * A rich embed message
 */
class Embed
{
    public $title;
    public $color;
    public $description;
    public $fields;
    public $thumbnail;
    public $image;
    public $url;
    public $author;
    // if set to true, it will be sent as a DM instead
    public $isPrivate = false;

    public function __construct(
        $title = null,
        $hexColour = null,
        $description = null,
        $fields = null,
        $thumbnail = null,
        $image = null,
        $url = null,
        $author = null,
        $isPrivate = false
    ) {
        $this->title = $title;
        $this->color = $hexColour;
        $this->description = $description;
        $this->fields = $fields;
        $this->thumbnail = $thumbnail;
        $this->image = $image;
        $this->url = $url;
        $this->author = $author;
        $this->isPrivate = $isPrivate;
    }

    /**
     * todo - add footer support
     * todo - add image support
     * todo - add thumbnail support
     * todo - add video support
     * todo - add provider support
     * todo - add author support
     */
    public function getRestEmbed(): array
    {
        $embed = [
            'type'          => 'rich',
            'title'         => $this->title,
            'description'   => $this->description,
            'url'           => $this->url,
            'color'         => hexdec($this->color),
        ];

        if ($this->fields) {
            $embed['fields'] = [];

            // loop through fields
            foreach ($this->fields as $i => $value) {
                $name = "Data #". ($i+1);
                $embed['fields'][] = [
                    'name'  => $name,
                    'value' => $value,
                    'inline' => true,
                ];
            }
        }

        return $embed;
    }

    /**
     * todo - write CLI embed handler
     */
    public function getCliEmbed(): MessageEmbed
    {
        $embed = new MessageEmbed();
        $embed
            ->setTitle($this->title)
            ->setColor(hexdec($this->color))
            ->setDescription($this->description);

        if ($this->url) {
            $embed->setURL($this->url);
        }

        if ($this->thumbnail) {
            $embed->setThumbnail($this->thumbnail);
        }

        if ($this->image) {
            $embed->setImage($this->image);
        }

        if ($this->author) {
            $embed->setAuthor($this->author);
        }

        if ($this->fields) {
            // loop through fields
            foreach ($this->fields as $i => $value) {
                $name = "Data #". ($i+1);
                $embed->addField($name, $value, true);
            }
        }

        return $embed;
    }
}
