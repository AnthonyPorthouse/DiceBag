# DiceBag

[![Build Status](https://github.com/AnthonyPorthouse/DiceBag/workflows/CI/badge.svg)][Repo]

Create dice roll results from standard dice notation

## A Simple Example
```php
<?php
use DiceBag\DiceBag;

$diceBag = DiceBag::factory('4d6dl1');

echo $diceBag;
```

## Installation
### Prerequisites
DiceBag Requires PHP 7.1 or greater.

### Installation Through Composer
Installation through composer is simple, just require it through the command line with the following command:
```bash
composer require porthou/dicebag
```

## Using DiceBag
DiceBag is designed to allow you to create results with as little as possible configuration, whilst being as random as
possible. By default it will use PHP7's default CSRNG generation using `random_int`.

If a custom RNG is desired then it can be passed in to the `DiceBag::factory()` method as the second parameter. This
will be passed through to any instances needing the RNG.
```php
<?php
use DiceBag\DiceBag;
use DiceBag\Randomization\MersenneTwister;

$randomizationEngine = new MersenneTwister();

$diceBag = DiceBag::factory('10f', $randomizationEngine);
```

### Dice Types
There are 3 types of "Dice"

#### Standard Dice `NdX`
This rolls `N` standard Numeric dice with `X` sides per die. If `N` is not specified it is assumed to be `1`
##### Examples
+ `d6` Rolls a 6 Sided Die. 
+ `4d6` Rolls 4 6 Sided Dice.
+ `d20` Rolls a 20 Sided Die.

#### Fate Dice `NdF`
This rolls `N` Fate (also known as fudge) dice. If `N` is not specified it is assumed to be `1`. Fate dies can roll -1, 0 or 1.
##### Examples
+ `f` Rolls a Fate die. 
+ `4f` Rolls 4 Fate die.

#### Fixed Modifiers `X`
Fixed modifiers are most useful when combined with other dice formats. They add (or subtract) a fixed value
##### Examples
+ `2d6+10` Rolls 2 6 sided dice and adds 10 to the result.

### Dice Pool Modifiers
Dice pool modifiers are used to change the results of a dice pool.

#### Keep Highest `khX`
This keeps the Highest `X` results from the dice pool.
##### Examples
+ `4d6kh3` Rolls 4 d6 and keeps the highest 3.

#### Drop Lowest `dlX`
This drops the Lowest `X` results from the dice pool.
##### Examples
+ `4d6dl1` Rolls 4 d6 and drops the lowest result.

#### Keep Lowest `klX`
This Keeps the Lowest `X` results from the dice pool.
##### Examples
+ `4d6kl1` Rolls 4 d6 and keeps the lowest result.

#### Drop Highest `dhX`
This Drops the Highest `X` results from the dice pool.
##### Examples
+ `4d6dh1` Rolls 4 d6 and drops the highest result.

#### Exploding Dice `!cN`
Exploding Dice add an additional dice to the pool if the maximum is rolled. These additional dice may also explode.

If `N` is specified then the dice will explode on the value specified.

`c` is a conditional, which can be either `<` or `>`. When specified with `N` dice will explode when the value is either
equal to or greater than, or equal to or less than, the value specified.

##### Examples
+ `4d6!` Rolls 4 d6 and and any results of 6 will add an additional die to the pool.
+ `4d6!1` Rolls 4 d6 and and any results of 1 will add an additional die to the pool.
+ `4d6!>5` Rolls 4 d6 and and any results of 5 or greater will add an additional die to the pool.
+ `4d6!<2` Rolls 4 d6 and and any results of 2 or less will add an additional die to the pool.

[Repo]: https://github.com/AnthonyPorthouse/DiceBag
