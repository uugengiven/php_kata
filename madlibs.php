<?php

declare(strict_types=1);

require_once 'MadlibProcessor.php';

use PhpKata\MadlibProcessor;

/**
 * Simple console interface for the MadlibProcessor
 */
function main(): void
{
    $processor = new MadlibProcessor();
    
    echo "=== Madlib Generator ===\n\n";
    
    // Example usage
    $template = "The {{adjective}} {{animal}} {{verb}} through the {{place}} carrying a {{object}}.";
    
    echo "Template: {$template}\n\n";
    
    // Get placeholders
    $placeholders = $processor->extractPlaceholders($template);
    echo "Please provide words for the following:\n";
    
    $userInputs = [];
    foreach ($placeholders as $placeholder) {
        echo "Enter a {$placeholder}: ";
        $input = trim(fgets(STDIN));
        $userInputs[] = [$placeholder, $input];
    }
    
    // Generate final madlib
    $result = $processor->replacePlaceholders($template, $userInputs);
    
    echo "\n=== Your Madlib ===\n";
    echo $result . "\n";
}

// Run only if this file is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    main();
}