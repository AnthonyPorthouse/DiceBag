# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added
- Include Applied Modifier Descriptions in JSON serialized DicePool Results.
### Fixed
- Dice Formats are all case insensitive, since we lowercase all input. This makes Fate Dice possible to from the
`DiceBag::factory` method.

## [v0.0.1] - 2016-08-09
### Added
- Standard Dice
- Fate Dice
- Fixed Value Modifiers
- Modifiers (Drop/Keep Highest/Lowest)
- Modifiers (Exploding Dice)
- JSON Serialization

[Unreleased]: https://github.com/AnthonyPorthouse/DiceBag/compare/v0.0.1...HEAD
[v0.0.1]: https://github.com/AnthonyPorthouse/DiceBag/compare/c65a7f1...v0.0.1
