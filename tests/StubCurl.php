<?php

namespace Tests;

use App\Helpers\Curl;

/**
 * Curl stub class
 */
class StubCurl extends Curl
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->body = null;
        $this->info = null;
        $this->status = null;
        $this->url = null;
    }

    /**
     * Set the response to be returned by the server
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Set the HTTP status code to be returned by the server
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set the URL to make Curl connection to
     * @param string $url the URL to connect to
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Send the Curl request.
     * @return StubCurl|null
     */
    public function send()
    {
        if (!$this->url)
            return null;

        return $this;
    }
}