<?php	

	//local markdown text files.
	$filename = '../readme.md';
	$filename = 'sample.md';
	$filename = 'syntax.text';

	//uncomment to read and parse markdown file from internet
	//$filename = 'http://dl.dropbox.com/u/14543536/XparK.docs/FAQ.txt';
	


	include ('../markdown.php');
	$text = file_get_contents($filename);

	$html = markdown($text);
?>
<html>
<head>
	<meta charset="utf-8">	
	<title>php-markdown Test Page</title>
	<link href="assests/css/bootstrap.css" rel="stylesheet">

</head>
<body>
	<h1>php-markdown</h1>

	<div class="container">
	
	<div class="row">
		<div class="span8">
			<div class="row">
				<div class="span8">
					<form action="markdown2html.php" method="post">
						<textarea class="span8" name="markdown_text" row=1000 id="markdown-textbox"></textarea>
						<span class="help-block">Enter your markdown above</span>						
					</form>
				</div>				

			</div>
			
			<div class="row">
			<div class="span8">

				<!--<h2>HTML Code</h2>-->
				<pre id="output-html-raw">
<?php //print(htmlentities($html)); ?>
				</pre>

				<h2>Sample Markup/Cheat-sheet</h2>
				<pre>
<?php print(htmlentities($text)); ?>
				</pre>	


			</div>
			</div>
		</div> <!-- end of column 1 -->

		<div class="span8">

			<!--<h2>HTML Formated Output</h2><hr>-->
			<div id="output-html-formated">
				<?php print($html); ?>
			</div>
		</div><!-- end of column 2 -->
</div><!-- end of 2-column layout -->
	
</div>

	
	<script src="assests/js/jquery.js"></script>
	<script src="assests/js/plugin.js"></script>
	<script src="assests/js/script.js"></script>

</body>
</html>