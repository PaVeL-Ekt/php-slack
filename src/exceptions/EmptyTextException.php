<?php

namespace PavelEkt\PhpSlack\exceptions;

use PavelEkt\BaseComponents\Abstracts\BaseMessageException;

class EmptyTextException extends BaseMessageException
{
    /**
     * @const int EXCEPTION_CODE The Exception code.
     */
    const EXCEPTION_CODE = 201;
    /**
     * @const string EXCEPTION_MESSAGE The Exception message.
     */
    const EXCEPTION_MESSAGE = 'Text can`t be empty.';
}
