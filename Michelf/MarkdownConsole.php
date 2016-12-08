<?php

namespace Michelf;

function runTransform($parser_class)
{
    # Install PSR-0-compatible class autoloader
    spl_autoload_register(function($class){
        require preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
    });

    # Initialize the parser and check interface
    $parser = new $parser_class();
    if (!($parser instanceof MarkdownInterface)) {
        die('Parser class should implement Michelf\MarkdownInterface');
    }

    # Read command line options
    global $argc, $argv;
    if ($argc == 2) {
        switch ($argv[1]) {
            case '-v':
            case '--version':
                echo $parser::MARKDOWNLIB_VERSION, PHP_EOL;
                exit;
            case '-h':
            case '--help':
                echo 'Usage: markdownextra [input1.md [input2.md ...]]', PHP_EOL;
                echo 'If no input file is specified, it reads stdin.', PHP_EOL;
                exit;
        }
    }

    # Read stdin or input files and pass content through the Markdown parser
    if ($argc == 1) {
        echo $parser->transform(file_get_contents('php://stdin'));
    } else {
        for ($i = 1; $i < $argc; $i++) {
            echo $parser->transform(file_get_contents($argv[$i]));
        }
    }
}
