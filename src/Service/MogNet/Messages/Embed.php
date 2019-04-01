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
    public $footer;
    public $thumbnail;
    public $image;
    public $url;
    public $author;
    // if set to true, it will be sent as a DM instead
    public $isPrivate = false;

    public function __construct(
        $title,
        $hexColour,
        $description,
        $fields = null,
        $footer = null,
        Image $thumbnail = null,
        Image $image = null,
        $url = null,
        Author $author = null,
        $isPrivate = false
    ) {
        $this->title = $title;
        $this->color = $hexColour;
        $this->description = $description;
        $this->fields = $fields;
        $this->footer = $footer;
        $this->thumbnail = $thumbnail;
        $this->image = $image;
        $this->url = $url;
        $this->author = $author;
        $this->isPrivate = $isPrivate;
    }

    /**
     * todo - add image support
     * todo - add thumbnail support
     * todo - add video support
     * todo - add provider support
     */
    public function getRestEmbed(): array
    {
        $embed = [
            'type'          => 'rich',
            'title'         => $this->title,
            'description'   => $this->description,
            'url'           => $this->url,
            'color'         => hexdec($this->color),
            'footer'        => [
                'text' => $this->footer,
            ],
        ];

        if ($this->thumbnail) {
            $embed['thumbnail'] = [
                'url' => $this->thumbnail->url
            ];
        }

        if ($this->image) {
            $embed['image'] = [
                'url' => $this->image->url
            ];
        }

        if ($this->author) {
            $embed['author'] = [
                'name' => $this->author->name,
                'icon_url' => $this->author->iconUrl,
            ];
        }

        if ($this->fields) {
            $embed['fields'] = [];

            // loop through fields
            /** @var Field $field */
            foreach ($this->fields as $field) {
                $embed['fields'][] = [
                    'name'   => $field->name,
                    'value'  => $field->value,
                    'inline' => $field->inline ?? false,
                ];
            }
        }

        if ($this->footer) {
            $embed['footer'] = [
                'text' => $this->footer,
            ];
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

        if ($this->footer) {
            $embed->setFooter($this->footer);
        }

        if ($this->url) {
            $embed->setURL($this->url);
        }

        if ($this->thumbnail) {
            $embed->setThumbnail($this->thumbnail->url);
        }

        if ($this->image) {
            $embed->setImage($this->image->url);
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
