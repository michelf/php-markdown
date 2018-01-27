<?php

class MarkdownTestHelper
{
	/**
	 * Takes an input directory containing .text and .(x)html files, and returns an array
	 * of .text files and the corresponding output xhtml or html file. Can be used in a unit test data provider.
	 *
	 * @param string $directory Input directory
	 *
	 * @return array
	 */
	public static function getInputOutputPaths($directory) {
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
		$regexIterator = new RegexIterator(
			$iterator,
			'/^.+\.text$/',
			RecursiveRegexIterator::GET_MATCH
		);

		$dataValues = [];

		/** @var SplFileInfo $inputFile */
		foreach ($regexIterator as $inputFiles) {
			foreach ($inputFiles as $inputMarkdownPath) {
				$expectedHtmlPath = substr($inputMarkdownPath, 0, -4) . 'xhtml';
				if (!file_exists($expectedHtmlPath)) {
					$expectedHtmlPath = substr($inputMarkdownPath, 0, -4) . 'html';
				}
				$dataValues[] = [$inputMarkdownPath, $expectedHtmlPath];
			}
		}

		return $dataValues;
	}
}