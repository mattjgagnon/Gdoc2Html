#!/usr/bin/env php
<?php

if ($argc !== 2) {
    echo "Usage: php convert-google-doc.php <path-to-text-file>\n";
    exit(1);
}

$inputFilePath = $argv[1];

if (!file_exists($inputFilePath)) {
    echo "The file '{$inputFilePath}' does not exist.\n";
    exit(1);
}

$plainTextContent = file_get_contents($inputFilePath);

if ($plainTextContent === false) {
    echo "Failed to read the file '{$inputFilePath}'.\n";
    exit(1);
}

// Simple processing example: wrap text in <pre> HTML tags
$htmlContent = "<html><body><pre>" . htmlspecialchars($plainTextContent) . "</pre></body></html>";

$outputFile = pathinfo($inputFilePath, PATHINFO_FILENAME) . ".html";
file_put_contents($outputFile, $htmlContent);

echo "File successfully processed and saved as '{$outputFile}'.\n";
