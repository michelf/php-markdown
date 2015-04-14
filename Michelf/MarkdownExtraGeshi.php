<?php
#
# Markdown Extra Geshi -  A text-to-HTML conversion tool for web writers
#
# PHP Markdown Extra Geshi
# Copyright (c) 2015 Mario Konrad
#
# PHP Markdown Extra
# Copyright (c) 2004-2015 Michel Fortin  
# <https://michelf.ca/projects/php-markdown/>
#
# Original Markdown
# Copyright (c) 2004-2006 John Gruber  
# <http://daringfireball.net/projects/markdown/>
#
namespace Michelf;

require_once("geshi.php");

#
# Markdown Extra Geshi Parser Class
#

class MarkdownExtraGeshi extends \Michelf\MarkdownExtra {

	protected function doFencedCodeBlocks($text) {
	#
	# Adding the fenced code block syntax to regular Markdown:
	#
	# ~~~
	# Code block
	# ~~~
	#
	# also possible to state a language for syntax highlighting:
	#
	# ~~~ cpp
	# Code block
	# ~~~
	#
	# optional starting line number:
	#
	# ~~~ cpp:22
	# Code block
	# ~~~
	#
		$less_than_tab = $this->tab_width;
		
		$text = preg_replace_callback('{
				(?:\n|\A)
				# 1: Opening marker
				(
					(?:~{3,}|`{3,}) # 3 or more tildes/backticks.
				)
				[ ]*
				(?:
					([a-zA-Z0-9]+) # 2: language name
				|
					([a-zA-Z0-9]+:[1-9][0-9]*) # 3: language name and line number
				)?
				[ ]* \n # Whitespace and newline following marker.
				
				# 4: Content
				(
					(?>
						(?!\1 [ ]* \n)	# Not a closing marker.
						.*\n+
					)+
				)
				
				# Closing marker.
				\1 [ ]* (?= \n )
			}xm',
			array($this, '_doFencedCodeBlocks_geshi_callback'), $text);

		return $text;
	}

	protected function _doFencedCodeBlocks_geshi_callback($matches) {
		$language =& $matches[2];
		$codeblock = $matches[4];
		$codeblock = preg_replace_callback('/^\n+/',
			array($this, '_doFencedCodeBlocks_newlines'), $codeblock);

		if ($language == "") {
			$language =& $matches[3];
		}

		$linenumber = "1";
		if ($language != "") {
			$attrs = preg_split("/:/", $language);
			if (count($attrs) > 0) {
				$language = $attrs[0];
			}
			if (count($attrs) > 1) {
				$linenumber = $attrs[1];
			}
		}

		$geshi = new \Geshi($codeblock, $language);
		$geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
		$geshi->start_line_numbers_at($linenumber);
		$codeblock = $geshi->parse_code();
		return "\n\n".$this->hashBlock($codeblock)."\n\n";
	}
}

