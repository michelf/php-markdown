<?php

require __DIR__ . '/../Michelf/Markdown.php';

class HeadingTest extends PHPUnit_Framework_TestCase
{
	private static $_unicode_string = "Testing åäö ❤ ☀ ☆ ☂ ☻ ♞ ☯";
	private static $_latin_string = "Testing åäö";
	
    public function testUnicode()
    {
    	$nl = "\n";
        $markdown = \Michelf\Markdown::defaultTransform(
        	self::$_unicode_string . $nl .
        	"="
        );
        
        $this->assertEquals('<h1>' . self::$_unicode_string . '</h1>' . $nl, $markdown);
    }
	
    public function testLatin()
    {
    	$nl = "\n";
        $html = \Michelf\Markdown::defaultTransform(
        	self::$_latin_string . $nl .
        	"="
        );
        
        $this->assertEquals('<h1>' . self::$_latin_string . '</h1>' . $nl, $html);
    }
	
    public function testCustomElements()
    {
    	$nl = "\n";
    	$parser = new \Michelf\Markdown();
    	$parser->heading_elements = array(1 => 'h2', 2 => 'h3');
        $html = $parser->transform(
        	self::$_latin_string . $nl .
        	"="
        );
        
        $this->assertEquals('<h2>' . self::$_latin_string . '</h2>' . $nl, $html);
    }
}