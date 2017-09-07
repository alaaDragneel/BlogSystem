<?php

namespace System;

class Route
{
    /**
    * Application object
    *
    * @var \System\Application
    */
    private $app;

    /**
    * Routes Container
    *
    * @var array
    */
    private $routes;

    /**
    * Not Fount Url
    *
    * @var string
    */
    private $notFound;

    /**
    * Constructor
    * @param \System\Application $app
    */

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
    * Add New Route
    *
    * @param string $url
    * @param string $action
    * @param string $requestMethod
    * @return void
    */
   public function add($url, $action, $requestMethod = 'GET')
   {
       $route = [
           'url'        => $url,
           'pattern'    => $this->generatePattern($url),
           'action'     => $this->getAction($action),
           'method'     => strtoupper($requestMethod),
       ];

        $this->routes[] = $route;
   }

   /**
    * Set Not Found Url
    *
    * @param string $url
    * @return void
    */
    public function notFound($url)
    {
        $this->notFound = $url;
    }

    /**
     * Get Proper Route
     *
     * @return array
     */
    public function getProperRoute()
    {
        foreach ($this->routes as $route) {
            if ($this->isMatching($route['pattern'])) {
                $arguments = $this->getArgumentsFrom($route['pattern']);

                // controller@method
                list($controller, $method) = explode('@', $route['action']);

                return [$controller, $method, $arguments];
            }
        }
    }

    /**
     * Determind If The Given pattern Matches The Current Request Url
     *
     * @param string $pattern
     * @return boolean
     */
    private function isMatching($pattern)
    {
        return preg_match($pattern, $this->app->request->url());
    }

    /**
     * Get Argument From The Current Request Url based On The Given Pattern
     *
     * @param string $pattern
     * @return array
     */
    private function getArgumentsFrom($pattern)
    {
        // get the matches pattern
        preg_match($pattern, $this->app->request->url(), $matches);
        /*
            dd($matches)
            array[
                    0 => "/posts/alaa-dragneel/21"
                    1 => "alaa-dragneel"
                    2 => "21"
                ]
        */
        // remove the firest element
        array_shift($matches);

        return $matches;

    }

   /**
    * Generate  a regex pattern For  The Given url
    *
    * @param string $url
    * @return string
    */
   private function generatePattern($url)
   {
       // open Pattern With [ # ] Because the link will Contains Many [ / ] So We CAn't Use It
       // start Sign [ ^ ]
       // end Sign [ $ ]
       // close Sign [ # ]
       $pattern = '#^';

       // :test ([a-zA-Z0-9-]+)
       // :id (\d+) Get All Decimal Number [ + ] mean more than number
       // str_replace([the argumants contains an array because there are more than more value ]);
       $pattern .= str_replace(['{text}', '{id}'], ['([a-zA-Z0-9-]+)', '(\d+)'], $url);


       $pattern .= '$#';

       return $pattern;
   }

   /**
    * Get Proper Action
    *
    * @param string $action
    * @return string
    */
    private function getAction($action)
    {
        $action = str_replace('/', '\\', $action);

        return strpos($action, '@') !== false ? $action : $action . '@index';
    }
}
