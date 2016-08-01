<?php
namespace DiceBag\Modifiers;

interface Modifier
{
    public function isValid() : bool;
    public function apply(array $dice) : array;
}
