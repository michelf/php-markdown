<?php

namespace Michelf;

class MardownTest extends \PHPUnit_Framework_TestCase
{
	private static $md;

	static public function setupBeforeClass()
	{
		self::$md = new MarkdownExtra;
	}

	public function transformProvider()
	{
		$ar = array();
		$di = new \DirectoryIterator(__DIR__ . '/samples');
		$ri = new \RegexIterator($di, '#\.md$#');

		foreach ($ri as $file)
		{
			$path = $file->getPath();
			$base = $file->getBaseName('.md');

			$ar[$base] = array
			(
				file_get_contents($path . DIRECTORY_SEPARATOR . $base . '.md'),
				file_get_contents($path . DIRECTORY_SEPARATOR . $base . '.html')
			);
		}

		return $ar;
	}

	/**
	 * @dataProvider transformProvider
	 */
	public function testTransform($md, $html)
	{
		$this->assertEquals($html . "\n", self::$md->transform($md));
	}
}