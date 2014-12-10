<?php
#
# Markdown Extra  -  A text-to-HTML conversion tool for web writers
#
# PHP Markdown Extra
# Copyright (c) 2004-2014 Michel Fortin  
# <http://michelf.com/projects/php-markdown/>
#
# Original Markdown
# Copyright (c) 2004-2006 John Gruber  
# <http://daringfireball.net/projects/markdown/>
#
namespace Michelf;


# Just force Michelf/Markdown.php to load. This is needed to load
# the temporary implementation class. See below for details.
\Michelf\Markdown::MARKDOWNLIB_VERSION;

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

	### Parser Implementation ###

	# Temporarily, the implemenation is in the _MarkdownExtra_TmpImpl class.
	# See note above.

    /**
     * @param string $file
     *
     * @throws \InvalidArgumentException
     * @return string
     */
    public function transformFile( $file ) {
        if(file_exists($file)) {

            return $this->transform(file_get_contents($file));

        }
        throw new \InvalidArgumentException("File {$file} does not exist");
    }

    /**
     * @param array $matches
     *
     * @return string
     */
    protected function _doBlockQuotes_callback($matches) {
        $bq = $matches[1];

        # trim one level of quoting - trim whitespace-only lines
        $bq = preg_replace('/^[ ]*>[ ]?|^[ ]+$/m', '', $bq);

        $class = "";
        // check class
        if(preg_match('/^\{([\.a-z\-\_\#\ ]+?)\}$/m', $bq, $bqm)) {
            $class = $bqm[1];
            // remove first line

            $bq = implode("\n", array_slice(explode("\n", $bq), 1));
        }

        $bq = $this->runBlockGamut($bq);		# recurse

        $bq = preg_replace('/^/m', "  ", $bq);
        # These leading spaces cause problem with <pre> content,
        # so we need to fix that:
        $bq = preg_replace_callback('{(\s*<pre>.+?</pre>)}sx',
                                    array(&$this, '_doBlockQuotes_callback2'), $bq);

        if(!empty($class)) {
            $attr = $this->doExtraAttributes('blockquote', $class);
            return "\n". $this->hashBlock("<blockquote{$attr}>\n$bq\n</blockquote>")."\n\n";
        } else {
            return "\n". $this->hashBlock("<blockquote>\n$bq\n</blockquote>")."\n\n";
        }
    }

}

