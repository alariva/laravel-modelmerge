# ModelMerge Laravel package

[![Latest Stable Version](https://poser.pugx.org/alariva/modelmerge/v/stable?format=flat)](https://packagist.org/packages/alariva/modelmerge)
[![Total Downloads](https://poser.pugx.org/alariva/modelmerge/downloads?format=flat)](https://packagist.org/packages/alariva/modelmerge)
[![Latest Unstable Version](https://poser.pugx.org/alariva/modelmerge/v/unstable?format=flat)](https://packagist.org/packages/alariva/modelmerge)
[![Build Status](https://travis-ci.org/alariva/laravel-modelmerge.svg?branch=master)](https://travis-ci.org/alariva/laravel-modelmerge)
[![Maintainability](https://api.codeclimate.com/v1/badges/f8829aab2f787e403d3e/maintainability)](https://codeclimate.com/github/alariva/laravel-modelmerge/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/f8829aab2f787e403d3e/test_coverage)](https://codeclimate.com/github/alariva/laravel-modelmerge/test_coverage)
[![License](https://poser.pugx.org/alariva/modelmerge/license?format=flat)](https://packagist.org/packages/alariva/modelmerge)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Falariva%2Flaravel-modelmerge.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Falariva%2Flaravel-modelmerge?ref=badge_shield)

Easy merging for Eloquent Models.

<p align="center">
<img src="https://i.imgur.com/iT0vLSC.png" height="275">
</p>

## Installation

Via Composer

``` bash
$ composer require alariva/modelmerge
```

## Usage

```php
    $modelA = SampleModel::make(['firstname' => 'John', 'age' => 33]);
    $modelB = SampleModel::make(['firstname' => 'John', 'lastname' => 'Doe']);

    $mergedModel = ModelMerge::setModelA($modelA)->setModelB($modelB)->merge();

    $mergedModel->firstname; // John
    $mergedModel->lastname; // Doe
    $mergedModel->age; // 33
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Ariel Vallese](https://alariva.com)
- Icons made by [Freepik](http://www.freepik.com) from [Flaticon](http://www.flaticon.com) is licensed by [CC 3.0 BY](http://creativecommons.org/licenses/by/3.0/)
- Icons made by [Roundicons](https://www.flaticon.com/authors/roundicons) from [Flaticon](http://www.flaticon.com) is licensed by [CC 3.0 BY](http://creativecommons.org/licenses/by/3.0/)

## License

MIT. Please see the [license file](license.md) for more information.


[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Falariva%2Flaravel-modelmerge.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Falariva%2Flaravel-modelmerge?ref=badge_large)