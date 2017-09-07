<?php

namespace System\Http;

class Request
{
    /**
    * Url
    *
    * @var string
    */
    private $url;

    /**
    * Base Url
    *
    * @var string
    */
    private $baseUrl;

    /**
    * Prepare Url
    *
    * @return void
    */
   public function prepareUrl()
   {
       $requestUri = $this->server('REQUEST_URI');

       if (strpos($requestUri, '?') !== false) {
           list($requestUri, $queryString) = explode('?', $requestUri);
       }

       $this->url = $requestUri;

       $this->baseUrl = $this->server('REQUEST_SCHEME') . '://' . $this->server('HTTP_HOST') . $requestUri;
   }

   /**
   * Get Value From _GET by The Given Key
   *
   * @param string $key
   * @param mixed $default
   * @return mixed
   */
   public function get($key, $default = null)
   {
       return array_get($_GET, $key, $default);
   }

   /**
   * Get Value From _POST by The Given Key
   *
   * @param string $key
   * @param mixed $default
   * @return mixed
   */
   public function post($key, $default = null)
   {
       return array_get($_POST, $key, $default);
   }

   /**
   * Get Value From _SERVER by The Given Key
   *
   * @param string $key
   * @param mixed $default
   * @return mixed
   */
   public function server($key, $default = null)
   {
       return array_get($_SERVER, $key, $default);
   }

   /**
   * Get Current Request Method
   *
   * @return strng
   */
   public function method()
   {
       return $this->server('REQUEST_METHOD');
   }

   /**
   * Get Full Url
   *
   * @return strng
   */
   public function baseUrl()
   {
       return $this->baseUrl;
   }

   /**
   * Get Only relative url (clear url)
   *
   * @return strng
   */
   public function url()
   {
       return $this->url;
   }

}
