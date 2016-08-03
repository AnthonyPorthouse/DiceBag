<?php
namespace DiceBag\Modifiers;

abstract class BaseModifier implements Modifier
{
    /** @var string $format */
    protected $format;

    const MATCH = '//';

    public function __construct(string $diceString)
    {
        $this->format = $diceString;
    }

    public static function isValid(string $format) : bool
    {
        return preg_match(static::MATCH, $format);
    }
}
