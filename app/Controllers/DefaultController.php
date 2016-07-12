<?php

namespace App\Controllers;

use App\Services\ScrapeService;
use App\Helpers\Utilities;

/**
 * Default controller
 */
class DefaultController
{
	protected $ci;

	/**
     * Class constructor
     * @param Slim container instance
     */
    public function __construct(\Slim\Container $ci)
    {
        $this->ci = $ci;
    }

	/**
     * Web default action
     */
	public function home()
	{
		$service = new ScrapeService();
		$service->url = $this->ci->scrapeUrl;

		$items = $service->getItems();

		$json = Utilities::formatAsJson($items);

		echo Utilities::formatPre($json);
	}

	/**
     * Console default action
     */
	public function console()
	{
		$service = new ScrapeService();
		$service->url = $this->ci->scrapeUrl;

		$items = $service->getItems();

		$json = Utilities::formatAsJson($items);

		echo $json;
	}
}