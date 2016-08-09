<?php
namespace DiceBag\Modifiers;

abstract class BaseModifier implements ModifierInterface, \JsonSerializable
{
    /** @var string $format */
    protected $format;

    const MATCH = '//i';

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
        return preg_match(static::MATCH, $format);
    }

    public function jsonSerialize() : string
    {
        return $this->__toString();
    }
}
