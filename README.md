# php-cf-utils

A library revolving around repetitive and recurring tasks.

| branch | status |
| --- | --- |
| master | [![Build Status](https://travis-ci.org/crazyfactory/php-cf-utils.svg?branch=master)](https://travis-ci.org/crazyfactory/php-cf-utils) |

## Features

General
* Relies on throwing exceptions. Most things don't fail gracefully by design.
* Heavily tested to ensure stability.
* Static helper classes for php native types
* Sql Query builders for primary_key-based batch inserts, updates and deletes.

## Usage

- add a custom repository to your composer.json file
  ```
  "repositories": [
   {
     "type": "vcs",
     "url": "https://github.com/crazyfactory/php-cf-utils"
   }
  ]
  ```

- run ```composer require crazyfactory/php-cf-utils```

## Testing

- run ``composer update``
- run ``composer test`` for PHPUnit tests.
- run ``composer lint`` for code style tests (linux only)