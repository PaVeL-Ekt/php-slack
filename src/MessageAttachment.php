<?php

namespace PavelEkt\PhpSlack;

use PavelEkt\BaseComponents\Abstracts\BaseComponent;

class MessageAttachment extends BaseComponent
{
    protected $_attributes = [
        'fallback',
        'color',
        'pretext',
        'author_name',
        'author_link',
        'author_icon',
        'title',
        'title_link',
        'text',
        'fields',
        'image_url',
        'thumb_url',
    ];

    protected function setColor($color)
    {
        if (preg_match(''))
    }
}
