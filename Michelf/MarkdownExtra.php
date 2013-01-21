<?php
#
# Markdown Extra  -  A text-to-HTML conversion tool for web writers
#
# PHP Markdown Extra
# Copyright (c) 2004-2012 Michel Fortin  
# <http://michelf.com/projects/php-markdown/>
#
# Original Markdown
# Copyright (c) 2004-2006 John Gruber  
# <http://daringfireball.net/projects/markdown/>
#
namespace Michelf;


#
# Markdown Extra Parser Class
#
# Note: Currently the implementation resides in the temporary class
# \Michelf\MarkdownExtra_TmpImpl (in the same file as \Michelf\Markdown).
# This makes it easier to propagate the changes between the three different
# packaging styles of PHP Markdown. Once this issue is resolved, the
# _MarkdownExtra_TmpImpl will disappear and this one will contain the code.
#

class MarkdownExtra extends \Michelf\_MarkdownExtra_TmpImpl {

	### Version ###

	const  MARKDOWNEXTRA_VERSION  = \Michelf\MARKDOWNEXTRA_VERSION;

	### Parser Implementation ###

	# Temporarily, the implemenation is in the _MarkdownExtra_TmpImpl class.
	# See note above.

}


?>