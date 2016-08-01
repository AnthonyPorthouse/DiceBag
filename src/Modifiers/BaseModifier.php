<?php
namespace DiceBag\Modifiers;

abstract class BaseModifier implements Modifier
{
    /** @var string $format */
    protected $format;

    protected $match = '';

    public function __construct(string $diceString)
    {
        $this->format = $diceString;
    }

    public function isValid() : bool
    {
        return preg_match($this->getMatch(), $this->format);
    }

    protected function getMatch()
    {
        return $this->match;
    }
}
