# _Fudge\Parsi_

_Easily edit and read your CSV's. Query them too!_

## Project Setup
In terminal/commandline:

    composer require fudge/parsi [dev-master]

Or you can add this to your `composer.json`:

    "require": {
        "fudge/parsi": "dev-master"
    }


## Unit Tests

I am proud to say that Fudge\Parsi is *100%* covered by unit tests.

1. `phpunit`

If you wish to make modifications to the `phpunit.xml.dist`, please create your own
`phpunit.xml` to override what is currently being used in the dist file.

## Examples

### Reading CSVs

```php
<?php
require_once './vendor/autoload.php';

$file  = new SplFileObject('path/to/csv.csv');
$csv   = new \Parsi\Readers\Csv($file);

// Headers may be included.
// $csv->headers(true)->load();
// OR
// $csv = new \Parsi\Readers\Csv($file, $headers = true);

$array = $csv->data(); // Returns an array of the data found within the file
```
### Writing CSVs

```php
<?php
require_once './vendor/autoload.php';

$data = array(
    array(1, 'Ben', 'Hello, World!'),
    array(2, 'Kev', 'Shiny Shoes!'),
);

$file = new SplFileObject('path/to/creation.csv', 'w+'); // Please ensure you use 'w+'
$csv  = new \Parsi\Writers\Csv($file);

// Data may be set during construction like so;
// new \Parsi\Writers\Csv($file, $data);

$csv->setData($data)->create(); // File will now be created.
```

### Querying CSVs
```php
<?php
require_once './vendor/autoload.php';

$file  = new SplFileObject('path/to/csv.csv');
$csv   = new \Parsi\Readers\Csv($file);
$query = \Parsi\Query::query($csv)->select(array('1', '2'))->where(1, '=', 2); // Similar syntax to Laravel Fluent/Eloquent.

/**
 * $data will now be populated with a multi-dimensional array with keys 1, 2
 * which match the where clause
 */
$data = $query->get();
```

## Documentation

__To Come...__

## Contributing changes

Please feel free to open pull requests for new features/bugs.

If you find bugs but do not have the time to fix them yourself, please open an issue.
