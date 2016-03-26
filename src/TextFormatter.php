<?php

namespace PavelEkt\PhpSlack;

use PavelEkt\BaseComponents\Exceptions\MethodNotFoundException;
use PavelEkt\PhpSlack\exceptions\EmptyTextException;

/**
 * Class TextFormatter
 * @package PavelEkt\PhpSlack
 * @method static string asCode() asCode(string $text) Представляет текст как код.
 * @method static string asBold() asBold(string $text) Сделать текст жирным.
 * @method static string asStrikethrough() asStrikethrough(string $text) Сделать текст перечеркнутым.
 * @method static string asStrike() asStrike(string $text) Сделать текст перечеркнутым.
 * @method static string asItalic() asItalic(string $text) Сделать текст курсивом.
 * @method static string asList() asList(string $text, string $listType) Представляет текст как список.
 * @method static string asBlockquotes() asBlockquotes(string $text) Представляет текст цитатой.
 */
class TextFormatter
{
    /**
     * Тип списка нумерованный
     */
    const MESSAGE_LIST_TYPE_NUM = 'num';
    const MESSAGE_LIST_TYPE_DISK = '•';

    static public function __callStatic($name, $arguments)
    {
        if (empty($arguments[0])) {
            throw new EmptyTextException();
        }
        if (method_exists(__CLASS__, '_' . $name)) {
            $arguments[0] = self::_escape($arguments[0]);
            return call_user_func_array([__CLASS__, '_' . $name], $arguments);
        }
        throw new MethodNotFoundException(['method' => $name, 'class' => __CLASS__]);
    }

    static protected function _escape($text)
    {
        $replace = [
            'pattern' => [
                '/&(?!amp;)/',
                '/>/',
                '/</',
                '/\n/',
            ],
            'replacement' => [
                '&amp;',
                '&gt;',
                '&lt;',
                '\n',
            ]
        ];
        return preg_replace($replace['pattern'], $replace['replacement'], $text);
    }

    /**
     * Представить текст как код.
     * @param string $text Преобразуемый текст.
     * @return mixed|string
     */
    static protected function _asCode($text)
    {
        $text = preg_replace('/`/', '', $text);
        if (preg_match('/\\\\n/', $text)) {
            $text = '```' . $text . '```';
        } else {
            $text = '`' . $text . '`';
        }
        return $text;
    }

    /**
     * Сделать текст жирным.
     * @param string $text Преобразуемый текст.
     * @return string
     */
    static protected function _asBold($text)
    {
        $text = preg_replace('/\*/', '', $text);
        return '*' . $text . '*';
    }

    /**
     * Сделать текст перечеркнутым.
     * @param string $text Преобразуемый текст.
     * @return string
     */
    static protected function _asStrikethrough($text)
    {
        $text = preg_replace('/\~/', '', $text);
        return '~' . $text . '~';
    }

    /**
     * Алияс для метода _asStrikethrough
     * @param string $text Преобразуемый текст.
     * @return string
     */
    static protected function _asStrike($text)
    {
        return static::_asStrikethrough($text);
    }

    /**
     * Сделать текст курсивом.
     * @param string $text Преобразуемый текст.
     * @return string
     */
    static protected function _asItalic($text)
    {
        $text = preg_replace('/\_/', '', $text);
        return '_' . $text . '_';
    }

    static protected function _asList($text, $listType = self::MESSAGE_LIST_TYPE_NUM)
    {
        $result = '';
        if (!is_array($text) && is_string($text)) {
            $text = explode('\\n', $text);
        }
        $idx = 0;
        foreach ($text as $line) {
            if ($listType == self::MESSAGE_LIST_TYPE_NUM) {
                $result .= ++$idx;
            } else {
                $result .= $listType;
            }
            $result .= ' ' . $line . '\n';
        }
        return $result;
    }

    static protected function _asBlockquotes($text)
    {
        $text = preg_replace('/>/', '', $text);
        if (preg_match('/\\\\n/', $text)) {
            $text = '>>>' . $text;
        } else {
            $text = '>' . $text;
        }
        return $text;
    }
}
