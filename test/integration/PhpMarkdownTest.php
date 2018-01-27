<?php

use PHPUnit\Framework\TestCase;
use Michelf\Markdown;

class PhpMarkdownTest extends TestCase
{
	/**
	 * @return array
	 */
	public function dataProviderForRegular() {
		$dir = TEST_RESOURCES_ROOT . '/php-markdown.mdtest';
		return MarkdownTestHelper::getInputOutputPaths($dir);
	}

	/**
	 * @dataProvider dataProviderForRegular
	 *
	 * @param string $inputPath Input markdown path
	 * @param string $htmlPath File path of expected transformed output (X)HTML
	 *
	 * @return void
	 */
	public function testTransformingOfPhpMarkdown($inputPath, $htmlPath) {
		$inputMarkdown = file_get_contents($inputPath);
		$expectedHtml = file_get_contents($htmlPath);
		$result = Markdown::defaultTransform($inputMarkdown);

		$this->assertSame(
			$expectedHtml,
			$result,
			"Markdown in $inputPath converts exactly to expected $htmlPath"
		);
	}

	/**
	 * @return array
	 */
	public function dataProviderForMarkdownExtra() {
		$dir = TEST_RESOURCES_ROOT . '/php-markdown-extra.mdtest';
		return MarkdownTestHelper::getInputOutputPaths($dir);
	}

	/**
	 * @dataProvider dataProviderForMarkdownExtra
	 *
	 * @param string $inputPath Input markdown path
	 * @param string $htmlPath File path of expected transformed output (X)HTML
	 *
	 * @return void
	 */
	public function testTransformingOfMarkdownExtra($inputPath, $htmlPath) {
		$inputMarkdown = file_get_contents($inputPath);
		$expectedHtml = file_get_contents($htmlPath);
		$result = Markdown::defaultTransform($inputMarkdown);

		$this->assertSame(
			$expectedHtml,
			$result,
			"Markdown in $inputPath converts exactly to expected $htmlPath"
		);
	}

	/**
	 * @return array
	 */
	public function dataProviderForRegularMarkdown()
	{
		$dir = TEST_RESOURCES_ROOT . '/markdown.mdtest';
		return MarkdownTestHelper::getInputOutputPaths($dir);
	}

	/**
	 * @dataProvider dataProviderForRegularMarkdown
	 *
	 * @param string $inputPath Input markdown path
	 * @param string $htmlPath File path of expected transformed output (X)HTML
	 *
	 * @return void
	 */
	public function testTransformingOfRegularMarkdown($inputPath, $htmlPath)
	{
		$inputMarkdown = file_get_contents($inputPath);
		$expectedHtml = file_get_contents($htmlPath);
		$result = Markdown::defaultTransform($inputMarkdown);

		$this->assertSame(
			$expectedHtml,
			$result,
			"Markdown in $inputPath converts exactly to expected $htmlPath"
		);
	}
}
