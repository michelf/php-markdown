<?php

# This file passes the content of the Readme.md file in the same directory
# through the Markdown filter. You can adapt this sample code in any way
# you like.

# Enable class autoloading
spl_autoload_register(function ($className) {
		$className = ltrim($className, '\\');
		$fileName  = '';
		$namespace = '';
		if ($lastNsPos = strrpos($className, '\\')) {
		    $namespace = substr($className, 0, $lastNsPos);
		    $className = substr($className, $lastNsPos + 1);
		    $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
		}
		$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
		@include $fileName;
	}
);

# Load Markdown class
use \Michelf\Markdown;

# Read file and pass content through the Markdown praser
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
			# Put HTML content in the document
			echo $html;
		?>
    </body>
</html>
