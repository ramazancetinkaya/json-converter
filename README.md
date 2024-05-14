# JSON Converter

[![License](https://img.shields.io/github/license/ramazancetinkaya/json-converter)](https://github.com/ramazancetinkaya/json-converter/blob/master/LICENSE)
[![GitHub issues](https://img.shields.io/github/issues/ramazancetinkaya/json-converter)](https://github.com/ramazancetinkaya/json-converter/issues)
[![GitHub stars](https://img.shields.io/github/stars/ramazancetinkaya/json-converter)](https://github.com/ramazancetinkaya/json-converter/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/ramazancetinkaya/json-converter)](https://github.com/ramazancetinkaya/json-converter/network)

JSON Converter is a PHP library that provides advanced functionality to convert data between JSON, CSV, and XML formats.

## Features

- Convert `JSON` data to `CSV` format.
- Convert `JSON` data to `XML` format.
- Convert `CSV` data to `JSON` format.
- Convert `XML` data to `JSON` format.
- Support for custom delimiters and enclosures in CSV files.
- Pretty print option for XML output.

## Installation

You can install JSON Converter library via [Composer](https://getcomposer.org/):

```bash
composer require ramazancetinkaya/json-converter
```

## Usage

```php
// Include the Composer autoloader
require 'vendor/autoload.php';

use JSONConverter\JSONConverter;
```

Let's create a JSON data to use for this example:
```php
$jsonData = '[
    {
        "id": 1,
        "name": "John Doe",
        "position": "Software Engineer",
        "department": "Engineering",
        "salary": 75000
    },
    {
        "id": 2,
        "name": "Jane Smith",
        "position": "Marketing Manager",
        "department": "Marketing",
        "salary": 65000
    },
    {
        "id": 3,
        "name": "Michael Johnson",
        "position": "HR Specialist",
        "department": "Human Resources",
        "salary": 55000
    }
]';
```

Files used for this example:
```php
// CSV file
$csvFilePath = 'employees.csv';

// XML file
$xmlFilePath = 'employees.xml';
```

Convert JSON to CSV:
```php
// Convert JSON to CSV
JSONConverter::jsonToCSV($jsonData, 'output.csv');
```

Convert JSON to XML:
```php
// Convert JSON to XML
JSONConverter::jsonToXML($jsonData, 'output.xml', true);
```

Convert CSV to JSON:
```php
// Convert CSV to JSON
$jsonFromCSV = JSONConverter::csvToJSON($csvFilePath);
echo $jsonFromCSV;
```

Convert XML to JSON:
```php
// Convert XML to JSON
$jsonFromXML = JSONConverter::xmlToJSON($xmlFilePath);
echo $jsonFromXML;
```

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or create a pull request.

## License

This project is licensed under the MIT License. For more details, see the [LICENSE](LICENSE) file.

## Copyright

© 2024 Ramazan Çetinkaya. All rights reserved.
