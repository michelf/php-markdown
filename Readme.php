<?php

// This file passes the content of the Readme.md file in the same directory
// through the Markdown filter. You can adapt this sample code in any way
// you like.

// Install PSR-4-compatible class autoloader
spl_autoload_register(function($class){
	require str_replace('\\', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});
// If using Composer, use this instead:
//require 'vendor/autoload.php';

// Get Markdown class
use Michelf\Markdown;

// Read file and pass content through the Markdown parser

// Added $file variable for clarity
$file = 'readme.md';
$text = file_get_contents($file);
$html = Markdown::defaultTransform($text);

// variable $title: Contains the first line of $file. 
// Set the Webpage title dynamically so this can be used for any readme.md in any repo ... 
// ... or other markdown documents at some point ... 

$title = (new SplFileObject($file))->fgets();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<? 
				// Put title content in the document
				echo $title 
			?>
		</title>
	</head>
	<body>
		<?php
			// Put HTML content in the document
			echo $html;
		?>
	</body>
</html>
