# Nova Toggleable Field
This package provides a standard select field which can toggle visibility of other fields in page, no matter the section they are in.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nalingia/nova-toggleable-select)](https://packagist.org/packages/nalingia/nova-toggleable-select)
![License](https://img.shields.io/github/license/nalingia/nova-toggleable-select)

## Installation

```shell
composer require nalingia/nova-toggleable-select
```

## Usage

Use the `toggle` method to provide a _key-value_ map, where _key_ is the option's value and the _value_ is an array of fields' names you want to be visible when _key_ is selected.

In the example below, field _note_ will be visibile only when _C_ option is selected.

```php
use Nalingia\ToggleableSelect\Select;

//...

public function fields()
{
    return [
        Select::make('Size')
          ->options([
            'S' => 'Small',
            'M' => 'Medium',
            'L' => 'Large',
            'C' => 'Custom',
          ])
          ->toggle([
            'C' => ['note'],
          ]),
          
          // ...

          Text::make('Note'),
    ];
}
```