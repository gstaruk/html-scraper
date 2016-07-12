<?php

namespace App\Helpers;

use Sunra\PhpSimple\HtmlDomParser;

/**
 * HTML Scraper wrapper
 */
class HtmlScraper
{
	/**
     * Create DOM object from string
     * @param string $html the HTML string
     * @return object the DOM object
     */
	public function getHtmlDom($html)
	{
		return HtmlDomParser::str_get_html($html);
	}
}