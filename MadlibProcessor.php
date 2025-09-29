<?php

declare(strict_types=1);

namespace PhpKata;

/**
 * A class for processing madlib templates and files
 */
class MadlibProcessor
{
    /**
     * Reads the contents of a file and returns it as a string
     *
     * @param string $filename The name/path of the file to read
     * @return string The contents of the file
     * @throws \RuntimeException If the file cannot be read
     */
    public function readFile(string $filename): string
    {
        if (!file_exists($filename)) {
            throw new \RuntimeException("File '{$filename}' does not exist");
        }

        if (!is_readable($filename)) {
            throw new \RuntimeException("File '{$filename}' is not readable");
        }

        $content = file_get_contents($filename);
        
        if ($content === false) {
            throw new \RuntimeException("Failed to read file '{$filename}'");
        }

        return $content;
    }

    /**
     * Extracts placeholder words/phrases from a madlib string
     * Placeholders are wrapped in {{ }} symbols
     *
     * @param string $madlibString The madlib template string
     * @return array<string> Array of placeholder words/phrases
     */
    public function extractPlaceholders(string $madlibString): array
    {
        $pattern = '/\{\{([^}]+)\}\}/';
        $matches = [];
        
        if (preg_match_all($pattern, $madlibString, $matches)) {
            // Return the captured groups (content between {{ }})
            // Trim whitespace from each match
            return array_map('trim', $matches[1]);
        }
        
        return [];
    }

    /**
     * Replaces placeholders in a madlib string with provided words
     *
     * @param string $madlibString The madlib template string
     * @param array<array{string, string}> $replacements Array of [placeholder, replacement] tuples
     * @return string The madlib string with placeholders replaced
     */
    public function replacePlaceholders(string $madlibString, array $replacements): string
    {
        $result = $madlibString;
        
        foreach ($replacements as $replacement) {
            if (!is_array($replacement) || count($replacement) !== 2) {
                throw new \InvalidArgumentException("Each replacement must be a tuple [placeholder, replacement]");
            }
            
            [$placeholder, $word] = $replacement;
            
            // Replace only the FIRST occurrence of the placeholder wrapped in {{ }}
            // This allows duplicate placeholders to be treated as separate instances
            $pattern = '/\{\{\s*' . preg_quote(trim($placeholder), '/') . '\s*\}\}/';
            $result = preg_replace($pattern, $word, $result, 1); // Limit to 1 replacement
        }
        
        return $result;
    }
}