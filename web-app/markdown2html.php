<?php

//sleep(3);

if (empty($_POST['markdown_text'])) {
	$return['error'] = true;
	$return['msg'] = '';
}
else {
	$return['error'] = false;
	
	include ('../markdown.php');
	$text = $_POST['markdown_text'];

	$html = markdown($text);

	$return['msg'] = $html;
}


//echo json_encode($return);
echo $return['msg'];

?>