var debug = false;

$(document).ready(function(){

	if (debug) {console.log('app started')};
	$('#output-html-raw').hide();
	
	var txtbox =  $('#markdown-textbox');

	// limt the size of expanding input texbox
	txtbox.autoResize({limit: 500}).focus().keyup(diplay_output);
	
	function diplay_output() {		
		
		$('#output-html-raw, #output-html-formated').addClass('loading');
		$('#output-html-raw').show();	
		$.ajax({
			type : 'POST',
			url : 'markdown2html.php',
			dataType : 'html',
			data: {
				markdown_text : $('#markdown-textbox').val()
			},
			success : function(data){				
				if (debug) {
					console.log(data)
				};
				$('#output-html-raw, #output-html-formated').removeClass('loading');
				$('#output-html-raw').text(data).html();
				$('#output-html-formated').html(data);				
						
			}
		});

		return false;
	}

	//color fix
	$('pre > code').css({'backgroundColor':'transparent'});
	

});