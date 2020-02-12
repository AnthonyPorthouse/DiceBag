<?php

declare(strict_types=1);

namespace DiceBag\Modifiers;

use JsonSerializable;

abstract class BaseModifier implements ModifierInterface, JsonSerializable
{
    /** @var string $format */
    protected $format;

    protected const MATCH = '//i';

    /**
     * BaseModifier constructor.
     *
     * @param string $diceString
     */
    public function __construct(string $diceString)
    {
        $this->format = $diceString;
    }

    /** {@inheritdoc} */
    public static function isValid(string $format) : bool
    {
        return (bool)preg_match(static::MATCH, $format);
    }

    public function jsonSerialize() : string
    {
        return $this->__toString();
    }
}
