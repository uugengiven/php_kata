<?php

declare(strict_types=1);

require_once 'MadlibProcessor.php';

use PhpKata\MadlibProcessor;

$processor = new MadlibProcessor();

echo "=== Testing MadlibProcessor ===\n\n";

// Test 1: File reading
echo "Test 1: File operations\n";
try {
    $content = $processor->readFile('sample_madlib.txt');
    echo "✓ Successfully read file\n";
} catch (Exception $e) {
    echo "✗ Error reading file: " . $e->getMessage() . "\n";
}

try {
    $processor->readFile('nonexistent.txt');
    echo "✗ Should have thrown exception for missing file\n";
} catch (Exception $e) {
    echo "✓ Correctly handled missing file: " . $e->getMessage() . "\n";
}

// Test 2: Placeholder extraction
echo "\nTest 2: Placeholder extraction\n";
$testCases = [
    "No placeholders here" => [],
    "{{single}}" => ["single"],
    "{{first}} and {{second}}" => ["first", "second"],
    "{{ spaced }}" => ["spaced"],
    "{{}} empty brackets" => [""],
    "{{duplicate}} text {{duplicate}}" => ["duplicate", "duplicate"]
];

foreach ($testCases as $input => $expected) {
    $result = $processor->extractPlaceholders($input);
    $match = $result === $expected;
    echo ($match ? "✓" : "✗") . " '{$input}' -> [" . implode(', ', $result) . "]\n";
    if (!$match) {
        echo "  Expected: [" . implode(', ', $expected) . "]\n";
    }
}

// Test 3: Placeholder replacement
echo "\nTest 3: Placeholder replacement\n";
$template = "Hello {{name}}, welcome to {{place}}!";
$replacements = [
    ['name', 'Alice'],
    ['place', 'Wonderland']
];
$result = $processor->replacePlaceholders($template, $replacements);
$expected = "Hello Alice, welcome to Wonderland!";
echo ($result === $expected ? "✓" : "✗") . " Template replacement\n";
echo "Result: {$result}\n";

// Test 4: Duplicate placeholders with different values
echo "\nTest 4: Duplicate placeholders as separate instances\n";
$duplicateTemplate = "My favorite color was {{color}} but now it is {{color}}.";

// Test extraction
$extractedPlaceholders = $processor->extractPlaceholders($duplicateTemplate);
$expectedExtraction = ['color', 'color'];
$extractionMatch = $extractedPlaceholders === $expectedExtraction;
echo ($extractionMatch ? "✓" : "✗") . " Extraction: [" . implode(', ', $extractedPlaceholders) . "]\n";
if (!$extractionMatch) {
    echo "  Expected: [" . implode(', ', $expectedExtraction) . "]\n";
}

// Test replacement - this should replace in order of appearance
$duplicateReplacements = [
    ['color', 'red'],
    ['color', 'blue']
];
$duplicateResult = $processor->replacePlaceholders($duplicateTemplate, $duplicateReplacements);
$expectedReplacement = "My favorite color was red but now it is blue.";

echo ($duplicateResult === $expectedReplacement ? "✓" : "✗") . " Replacement with different values\n";
echo "Template: {$duplicateTemplate}\n";
echo "Result:   {$duplicateResult}\n";
echo "Expected: {$expectedReplacement}\n";

if ($duplicateResult !== $expectedReplacement) {
    echo "✗ MISMATCH: Duplicate placeholders not handled as separate instances\n";
}

// Test 5: Error handling for invalid replacements
echo "\nTest 5: Error handling\n";
try {
    $processor->replacePlaceholders("{{test}}", [['invalid']]);
    echo "✗ Should have thrown exception for invalid replacement format\n";
} catch (Exception $e) {
    echo "✓ Correctly handled invalid replacement format\n";
}

echo "\n=== All tests completed ===\n";