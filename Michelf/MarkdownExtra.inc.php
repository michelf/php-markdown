<?php
/**
 * Use this file if you cannot use class autoloading. It will include all the
 * files needed for the MarkdownExtra parser.
 *
 * Take a look at the PSR-0-compatible class autoloading implementation
 * in the Readme.php file if you want a simple autoloader setup.
 *
 * @package   php-markdown
 * @author    Michael Fortin <michael.fortin@michaelf.com>
 * @copyright 2004-2016 Michel Fortin <http://michelf.com/projects/php-markdown/>
 * @copyright (Original Markdown) 2004-2006 John Gruber <http://daringfireball.net/projects/markdown/>
 */

require_once dirname(__FILE__) . '/MarkdownInterface.php';
require_once dirname(__FILE__) . '/Markdown.php';
require_once dirname(__FILE__) . '/MarkdownExtra.php';
