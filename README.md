# PHP Madlib Processor

A reusable PHP class for processing madlib templates with placeholder replacement functionality.

## Features

- **File Reading**: Read madlib templates from files
- **Placeholder Extraction**: Extract placeholders wrapped in `{{ }}` from strings
- **Template Processing**: Replace placeholders with provided words
- **Modern PHP Standards**: Uses PHP 8+ features with strict typing and proper error handling

## Class: MadlibProcessor

### Methods

#### `readFile(string $filename): string`

Reads the contents of a file and returns it as a string.

**Parameters:**
- `$filename`: The path to the file to read

**Returns:** The file contents as a string

**Throws:** `RuntimeException` if file doesn't exist, isn't readable, or can't be read

**Example:**
```php
$processor = new MadlibProcessor();
$content = $processor->readFile('template.txt');
```

#### `extractPlaceholders(string $madlibString): array`

Extracts placeholder words/phrases from a madlib string. Placeholders are wrapped in `{{ }}` symbols.

**Parameters:**
- `$madlibString`: The madlib template string containing placeholders

**Returns:** Array of placeholder strings (content between `{{ }}`)

**Example:**
```php
$template = "My favorite {{color}} {{animal}} lives in a {{place}}.";
$placeholders = $processor->extractPlaceholders($template);
// Returns: ['color', 'animal', 'place']
```

#### `replacePlaceholders(string $madlibString, array $replacements): string`

Replaces placeholders in a madlib string with provided words.

**Parameters:**
- `$madlibString`: The madlib template string
- `$replacements`: Array of tuples `[placeholder, replacement]`

**Returns:** The madlib string with placeholders replaced

**Example:**
```php
$template = "The {{adjective}} {{animal}} {{verb}}.";
$replacements = [
    ['adjective', 'quick'],
    ['animal', 'fox'],
    ['verb', 'jumps']
];
$result = $processor->replacePlaceholders($template, $replacements);
// Returns: "The quick fox jumps."
```

## Usage Examples

### Basic Usage

```php
<?php
require_once 'MadlibProcessor.php';
use PhpKata\MadlibProcessor;

$processor = new MadlibProcessor();

// Read template from file
$template = $processor->readFile('madlib.txt');

// Extract placeholders
$placeholders = $processor->extractPlaceholders($template);

// Create replacements
$replacements = [
    ['noun', 'cat'],
    ['adjective', 'fluffy'],
    ['verb', 'sleeps']
];

// Generate final madlib
$result = $processor->replacePlaceholders($template, $replacements);
echo $result;
```

### Interactive Console Usage

Run the interactive madlib generator:

```bash
php madlibs.php
```

### Running Tests

```bash
php test.php     # Run unit tests
php demo.php     # See demonstration
```

## File Structure

```
/workspaces/php_kata/
├── MadlibProcessor.php    # Main class
├── madlibs.php           # Interactive console interface
├── demo.php              # Usage demonstration
├── test.php              # Unit tests
├── sample_madlib.txt     # Sample template file
└── README.md            # This file
```

## Requirements

- PHP 8.0 or higher
- No external dependencies

## Error Handling

The class includes comprehensive error handling:
- File operations throw `RuntimeException` for missing or unreadable files
- Invalid replacement format throws `InvalidArgumentException`
- All methods use strict typing for better reliability