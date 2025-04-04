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

// Encode specific punctuation marks, excluding standard punctuation like commas and periods
$search = ["'", "’", '"', "“", "”", "–", "—", "…"];
$replace = ["&rsquo;", "&rsquo;", "&ldquo;", "&ldquo;", "&rdquo;", "&ndash;", "&mdash;", "&hellip;"];
$processedContent = str_replace($search, $replace, htmlspecialchars($plainTextContent, ENT_NOQUOTES, 'UTF-8'));

// Split into paragraphs by empty lines and wrap each paragraph in <p> tags without <br>
$paragraphs = preg_split('/\r?\n\r?\n/', trim($processedContent));
$htmlParagraphs = array_map(fn($para) => '<p>' . trim(preg_replace('/\r?\n/', ' ', $para)) . '</p>' . "\r\n", $paragraphs);

$htmlContent = implode("\n", $htmlParagraphs);

$outputFile = pathinfo($inputFilePath, PATHINFO_FILENAME) . ".html";
file_put_contents($outputFile, $htmlContent);

echo "File successfully processed and saved as '{$outputFile}'.\n";
