<?php

namespace App\Services;

use App\Helpers\Curl;
use App\Helpers\HtmlScraper;
use App\Helpers\Utilities;

/**
 * HTML Scraper class
 */
class ScrapeService
{
    public $url;

    /**
     * Fetch the contents of a URL via curl
     * @param string $url the url to fetch
     * @return array curl response
     */
    public function getData($url, Curl $curl)
    {
        $curl->setUrl($url);

        $curl->send();

        if($curl->getStatus() != 200)
            return false;

        return $curl;
    }

    /**
     * Create DOM object from string
     * @param string $html the HTML string
     * @return object the DOM object
     */
    public function getHtmlDom($html, HtmlScraper $scraper)
    {
        return $scraper->getHtmlDom($html);
    }

    /**
     * Process DOM object and return values
     * @return array of data to output
     */
    public function getItems()
    {
        $data = $this->getData($this->url, new Curl());

        // set up return array
        $return_array = [];

        // ensure a non-empty response was received
        if (!empty($data) && !empty($data->getBody()))
        {
            // parse the html into a dom object
            $html = $this->getHtmlDom($data->getBody(), new HtmlScraper());

            // find item containers (return array of dom objects)
            $items = $html->find('ul.productLister li');

            // get data for all items
            $results = $this->getItemsData($items);

            $return_array = [
                'results' => $results['results'],
                'total' => $results['total']
            ];
        }

        return $return_array;
    }

    /**
     * Get items data
     * @param $items array of data items
     * @return array of processed data items
     */
    public function getItemsData($items)
    {
        // define default return values
        $results = [];
        $total = 0;

        // ensure we have a valid data array
        if (!empty($items) && is_array($items))
        {
            foreach ($items as $item)
            {
                // find the necessary html nodes
                $titleNode = $item->find('.productInfoWrapper h3 a text', 0);
                $priceNode = $item->find('.addToTrolleytabBox p text', 0);
                $linkNode = $item->find('.productInfoWrapper h3 a', 0);

                // get text content of the html nodes
                $title = is_object($titleNode) ?
                    trim($titleNode->plaintext) : null;

                $unitPrice = is_object($priceNode) ?
                    trim(str_replace('&pound', '', $priceNode->plaintext)) : null;

                $productUrl = is_object($linkNode) ?
                    $linkNode->href : null;

                // get the inner product
                $data = $this->getData($productUrl, new Curl());

                // ensure there is a valud result
                if (!empty($data) && !empty($data->getBody()) && !empty($data->getFileSize()))
                {
                    // parse the html into a dom object
                    $html = $this->getHtmlDom($data->getBody(), new HtmlScraper());

                    // get the html filesize
                    $filesize = Utilities::formatBytesToKb($data->getFileSize());

                    // get the meta description node
                    $descriptionNode = $html->find('meta[name=description]', 0);

                    // get text content of the description node
                    $description = is_object($descriptionNode) ?
                        html_entity_decode($descriptionNode->content, ENT_QUOTES) : null;

                    // generate results array
                    $results[] = [
                        'title' => $title,
                        'unit_price' => $unitPrice,
                        'size' => $filesize,
                        'description' => $description
                    ];
                }

                // increment the running total
                $total += $unitPrice;
            }
        }

        return [
            'results' => $results,
            'total' => number_format($total, 2)
        ];
    }
}