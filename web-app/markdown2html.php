<?php

//sleep(3);

if (empty($_POST['markdown_text'])) {
	$return['error'] = true;
	$return['msg'] = '';
}
else {
	$return['error'] = false;
	
	include ('../markdown.php');
	
	//get input
	$text = $_POST['markdown_text'];

	//process the input
	$html = markdown($text);

	//store the result to be returned
	$return['msg'] = $html;
}


//return the result back.
//echo json_encode($return);
echo $return['msg'];

?>