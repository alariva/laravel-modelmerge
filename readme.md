# ModelMerge Laravel package

[![Latest Stable Version](https://poser.pugx.org/alariva/modelmerge/v/stable?format=flat)](https://packagist.org/packages/alariva/modelmerge)
[![Total Downloads](https://poser.pugx.org/alariva/modelmerge/downloads?format=flat)](https://packagist.org/packages/alariva/modelmerge)
[![Latest Unstable Version](https://poser.pugx.org/alariva/modelmerge/v/unstable?format=flat)](https://packagist.org/packages/alariva/modelmerge)
[![Build Status](https://travis-ci.org/alariva/laravel-modelmerge.svg?branch=master)](https://travis-ci.org/alariva/laravel-modelmerge)
[![Maintainability](https://api.codeclimate.com/v1/badges/f8829aab2f787e403d3e/maintainability)](https://codeclimate.com/github/alariva/laravel-modelmerge/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/f8829aab2f787e403d3e/test_coverage)](https://codeclimate.com/github/alariva/laravel-modelmerge/test_coverage)
[![License](https://poser.pugx.org/alariva/modelmerge/license?format=flat)](https://packagist.org/packages/alariva/modelmerge)

Easy merging for Eloquent Models.

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

## License

MIT. Please see the [license file](license.md) for more information.
