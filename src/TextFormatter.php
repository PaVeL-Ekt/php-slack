<?php

namespace PavelEkt\PhpSlack;

use PavelEkt\BaseComponents\Abstracts\BaseComponent;
use PavelEkt\PhpSlack\exceptions\EmptyTextException;

class TextFormatter extends BaseComponent
{
    protected $text;

    public function __construct($text)
    {
        if (empty($text)) {
            throw new EmptyTextException([]);
        }
        $this->text = $text;
    }
}
