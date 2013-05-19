<?php

/**
 * Markdown Extra - A text-to-HTML conversion tool for web writers
 *
 * @copyright 2004-2013 Michel Fortin <http://michelf.com/projects/php-markdown/>
 * @copyright (Original Markdown) 2004-2006 John Gruber <http://daringfireball.net/projects/markdown/>
 *
 * @license http://michelf.ca/projects/php-markdown/#license
 */

namespace Michelf;


# Just force Michelf/Markdown.php to load. This is needed to load
# the temporary implementation class. See below for details.
\Michelf\Markdown::MARKDOWNLIB_VERSION;

/**
 * Markdown Extra Parser Class
 *
 * Note: Currently the implementation resides in the temporary class
 * \Michelf\MarkdownExtra_TmpImpl (in the same file as \Michelf\Markdown).
 * This makes it easier to propagate the changes between the three different
 * packaging styles of PHP Markdown. Once this issue is resolved, the
 * _MarkdownExtra_TmpImpl will disappear and this one will contain the code.
 *
 * @see Michelf\_MarkdownExtra_TmpImpl
 */
class MarkdownExtra extends \Michelf\_MarkdownExtra_TmpImpl {

}


?>