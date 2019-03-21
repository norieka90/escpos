<?php
namespace ReceiptPrintHq\EscposTools\Parser\Command;

use ReceiptPrintHq\EscposTools\Parser\Command\Command;
use ReceiptPrintHq\EscposTools\Parser\Command\TextContainer;

class TextCmd extends Command implements TextContainer
{
    private $str = "";

    public function addChar($char)
    {
        if (isset(Printout::$tree[$char])) {
            // Reject ESC/POS control chars.
            return false;
        }
		
		
		// echo "<script>console.log('char Objects: " . $char . "')</script>";
		
		// TODO: convert using fixed iconv or other lib
        $this -> str .=  $char; // iconv('CP437', 'UTF-8', $char);
		
		// echo "<script>console.log('str Objects: " . $this -> str . "')</script>";
		
        return true;
    }

    public function getText()
    {
		// echo "<script>console.log('Debug Objects: " . $this -> str . "')</script>";
		
        return $this -> str;
    }
}
