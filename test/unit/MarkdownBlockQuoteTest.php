<?php

class MarkdownBlockQuoteTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * Deepest nesting of blockquotes in the HTML
	 */
	private static function blockQuoteDepth(string $html): int
	{
		$depth = $deepest = 0;
		preg_match_all('{<(/?)blockquote>}', $html, $tags);
		foreach ($tags[1] as $closing) {
			$depth += $closing === '' ? 1 : -1;
			$deepest = max($deepest, $depth);
		}
		return $deepest;
	}

	public function deepBlockQuotes(): array
	{
		return array(
			'markers' => array(str_repeat('>', 2000) . ' x'),
			'markers with spaces' => array(str_repeat('> ', 2000) . 'x'),
			'one level more per line' => array(implode("\n", array_map(function ($i) {
				return str_repeat('>', $i) . ' x';
			}, range(1, 300)))),
			'in a list item' => array("- a\n\n    " . str_repeat('>', 2000) . ' x'),
		);
	}

	/**
	 * @dataProvider deepBlockQuotes
	 */
	public function testNestingIsLimited(string $text)
	{
		// without the limit, these need from hundreds of megabytes to gigabytes of memory
		foreach (array(new \Michelf\Markdown(), new \Michelf\MarkdownExtra()) as $parser) {
			$html = $parser->transform($text);
			$this->assertSame($parser->max_blockquote_depth, self::blockQuoteDepth($html));
		}
	}

	public function testMarkersBeyondTheLimitAreText()
	{
		$parser = new \Michelf\Markdown();
		$parser->max_blockquote_depth = 2;

		$this->assertSame(
			"<blockquote>\n  <blockquote>\n    <p>> x</p>\n  </blockquote>\n</blockquote>",
			trim($parser->transform('>>> x'))
		);
		$this->assertSame(
			"<blockquote>\n  <blockquote>\n    <p>y</p>\n  </blockquote>\n</blockquote>",
			trim($parser->transform('>> y')),
			'the depth starts again at 0 for each transformation'
		);
	}

	public function testLimitCanBeDisabled()
	{
		$parser = new \Michelf\Markdown();
		$parser->max_blockquote_depth = 0;

		$this->assertSame(150, self::blockQuoteDepth($parser->transform(str_repeat('>', 150) . ' x')));
	}
}
