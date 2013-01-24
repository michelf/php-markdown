<?php

# This file passes the content of the Readme.md file in the same directory
# through the Markdown filter. You can adapt this sample code in any way
# you like.

# Note: this line is only needed when PSR-0 class autoloading is not in place.
require_once './Michelf/Markdown.php';

# Get Markdown class
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
