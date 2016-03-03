<?php
/**
 * This file passes the content of the Readme.md file in the same directory
 * through the Markdown filter. You can adapt this sample code in any way
 * you like.
 *
 * @package   php-markdown
 * @author    Michel Fortin <michel.fortin@michelf.com>
 * @copyright 2004-2016 Michel Fortin <http://michelf.com/projects/php-markdown/>
 * @copyright (Original Markdown) 2004-2006 John Gruber <http://daringfireball.net/projects/markdown/>
 */

// Install PSR-0-compatible class autoloader
spl_autoload_register(function($class) {
	require preg_replace(
		'{\\\\|_(?!.*\\\\)}',
		DIRECTORY_SEPARATOR,
		ltrim($class, '\\')
	) . '.php';
});

// Get Markdown class
use \Michelf\Markdown;

// Read file and pass content through the Markdown parser
$text = file_get_contents('Readme.md');
$html = Markdown::defaultTransform($text);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>PHP Markdown Lib - Readme</title>
	</head>
	<body>
		<?php
		// Put HTML content in the document
		echo $html;
		?>
	</body>
</html>
