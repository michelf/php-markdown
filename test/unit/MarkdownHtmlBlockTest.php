<?php

class MarkdownHtmlBlockTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * Inputs made of many unclosed block-level HTML tags, each alone on its
	 * line. The HTML-block regex used to explore an exponential number of ways
	 * to pair these up, so a few hundred bytes either exhausted
	 * pcre.backtrack_limit (wiping the whole document to an empty string) or,
	 * with the limit raised, took time doubling about every 8 tags.
	 */
	public function unclosedBlocks(): array
	{
		return array(
			'div, blank lines' => array(str_repeat("<div>\n\n", 2000)),
			'div, single lines' => array(str_repeat("<div>\n", 2000)),
			'ins (group a)' => array(str_repeat("<ins>\n\n", 2000)),
			'del (group a)' => array(str_repeat("<del>\n", 2000)),
			'section' => array(str_repeat("<section>\n\n", 2000)),
			'attr with > in quotes' => array(str_repeat("<div class=\"a>b\">\n\n", 2000)),
		);
	}

	/**
	 * @dataProvider unclosedBlocks
	 */
	public function testUnclosedBlocksDoNotWipeOutput(string $prefix)
	{
		$html = (new \Michelf\Markdown())->transform($prefix . "the trailing paragraph\n");
		// Before the fix this came back as "" under the default backtrack
		// limit, or took seconds to minutes with the limit raised.
		$this->assertStringContainsString('the trailing paragraph', $html);
	}

	/**
	 * A realistic document whose real content surrounds a run of stray
	 * block-level tags must not be lost. Before the fix the unclosed tags
	 * blew the backtrack limit and the whole document came back empty,
	 * taking the heading and both paragraphs with it.
	 */
	public function testSurroundingContentSurvivesStrayTagRun()
	{
		$markdown =
			"# My Page\n\n" .
			"Intro paragraph.\n\n" .
			str_repeat("<section>\n", 60) .
			"\nConclusion paragraph.\n";

		$html = (new \Michelf\Markdown())->transform($markdown);

		$this->assertStringContainsString('My Page', $html);
		$this->assertStringContainsString('Intro paragraph.', $html);
		$this->assertStringContainsString('Conclusion paragraph.', $html);
	}

	/**
	 * The CPU-denial-of-service variant: with the backtrack limit raised (as
	 * the Readme suggests when output comes back empty) the old regex instead
	 * ran in time doubling roughly every dozen-and-a-half tags. Here a large
	 * unclosed run must parse quickly and keep its trailing content.
	 */
	public function testLargeUnclosedRunIsNotCatastrophic()
	{
		$markdown = str_repeat("<div>\n\n", 5000) . "the trailing paragraph\n";

		$start = microtime(true);
		$html = (new \Michelf\Markdown())->transform($markdown);
		$elapsed = microtime(true) - $start;

		$this->assertStringContainsString('the trailing paragraph', $html);
		// Linear now: ~0.05s in practice. A generous bound still fails hard
		// against the old exponential behaviour.
		$this->assertLessThan(10.0, $elapsed, 'HTML block parsing should be linear');
	}

	/**
	 * Well-formed nested block tags (up to the parser's supported depth) must
	 * still be recognised as a single HTML block and passed through verbatim.
	 */
	public function testWellFormedNestedBlocksAreUnchanged()
	{
		$html = "<div>\n<div>\n<div>\n<div>\nhello\n</div>\n</div>\n</div>\n</div>";

		$result = (new \Michelf\Markdown())->transform($html);

		// The whole block is emitted as-is, not wrapped in <p> and not escaped.
		$this->assertStringContainsString("<div>\nhello\n</div>", $result);
		$this->assertStringNotContainsString('<p>', $result);
		$this->assertStringNotContainsString('&lt;', $result);
	}

	public function tooDeeplyNested(): array
	{
		$cases = array();
		foreach (array(5, 6, 8) as $depth) {
			$cases["depth $depth"] = array(
				str_repeat("<div>\n", $depth) . "hello\n" . str_repeat("</div>\n", $depth),
			);
		}
		return $cases;
	}

	/**
	 * Nesting deeper than the parser's hard limit (nested_tags_level = 4) was
	 * never supported and still produces malformed HTML either way. What must
	 * hold is that it never triggers the catastrophic empty-string wipe: the
	 * inner content always survives.
	 *
	 * @dataProvider tooDeeplyNested
	 */
	public function testNestingBeyondSupportedDepthKeepsContent(string $markdown)
	{
		$html = (new \Michelf\Markdown())->transform($markdown);

		$this->assertNotSame('', trim($html));
		$this->assertStringContainsString('hello', $html);
	}
}
