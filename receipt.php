<?php
/**
 * Utility to extract text from binary ESC/POS data.
 */
require_once __DIR__ . '/vendor/autoload.php';

use ReceiptPrintHq\EscposTools\Parser\Parser;

if ($_GET) {
    $argument1 = $_GET['argument1'];
} else {
    $argument1 = $argv[1];
}

// Usage
if (!isset($argument1)) {
    print("Usage: " . $argv[0] . " filename\n");
    die();
}

// $debug = isset($argv[2]) && $argv[2] == "-v";
// $debug = 1;

// Load in a file
$fp = fopen($argument1, 'rb');

$parser = new Parser();
$parser -> addFile($fp);

// Extract text
$commands = $parser -> getCommands();

// print("Printing!<br/>");
foreach ($commands as $cmd) {
	
    if ($debug) {
        // Debug output if requested. List commands and the interface for retrieving the data.
        $className = shortName(get_class($cmd));
        $impl = class_implements($cmd);
        foreach ($impl as $key => $val) {
            $impl[$key] = shortName($val);
        }
        $implStr = count($impl) == 0 ? "" : "(" . implode(", ", $impl) . ")";
        // fwrite(STDERR, "[DEBUG] $className {$implStr}\n");
		print("[DEBUG]" . $className . $implStr . "<br/>");
    }
    if ($cmd -> isAvailableAs('TextContainer')) {
        // echo $cmd -> getText();
		print($cmd -> getText());
    }
    if ($cmd -> isAvailableAs('LineBreak')) {
        // echo "\n";
		print("<br/>");
    }
}

// Just for debugging
function shortName($longName)
{
    $nameParts = explode("\\", $longName);
    return array_pop($nameParts);
}
