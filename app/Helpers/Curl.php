<?php

namespace App\Helpers;

/**
 * Curl wrapper
 */
class Curl
{
    protected $handle;
    protected $body;
    protected $info;
    protected $status;
    protected $url;
    protected $filesize;

    /**
     * Class constructor
     * Initialise the Curl session, set some default options
     */
    public function __construct()
    {
        $this->handle = curl_init();
        $this->body = null;
        $this->info = null;
        $this->status = null;
        $this->url = null;
        $this->filesize = null;

        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handle, CURLOPT_USERAGENT, 'Curl Client');
    }

    /**
     * Set the URL to make Curl connection to
     * @param string $url the URL to connect to
     */
    public function setUrl($url)
    {
    	$this->url = $url;
        $this->setOption(CURLOPT_URL, $url);
    }

    /**
     * Set a Curl option
     * @param string $name the option name
     * @param string $value the option value
     */
    public function setOption($name, $value)
    {
        curl_setopt($this->handle, $name, $value);
    }

    /**
     * Return information about the last request
     * @param string $name the option name
     * @return mixed the option value
     */
    public function getInfo($name)
    {
        return curl_getinfo($this->handle, $name);
    }

    /**
     * Return the HTTP status code for the last request
     * @return integer the status code
     */
    public function getStatus()
    {
    	return $this->status;
    }

    /**
     * Return the content length of response
     * @return string the file size
     */
    public function getFileSize()
    {
    	return $this->filesize;
    }

    /**
     * Return the body returned by the last request
     * @return string the response body
     */
    public function getBody()
    {
    	return $this->body;
    }

    /**
     * Execute the Curl session
     */
    public function execute()
    {
        return curl_exec($this->handle);
    }

    /**
     * Close the Curl session
     */
    public function close()
    {
        curl_close($this->handle);
    }

    /**
     * Send the Curl request
     * @return Curl|null
     */
    public function send()
    {
        if (!$this->url)
            return null;

        $this->body = $this->execute();
        $this->filesize = $this->getInfo(CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $this->status = $this->getInfo(CURLINFO_HTTP_CODE);
        $this->close();

        return $this;
    }
}