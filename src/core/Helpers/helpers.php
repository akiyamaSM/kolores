<?php

use Chibi\Exceptions\ViewNotFoundException;
use Chibi\Session\Flash;
use Chibi\Template\Template;
use Chibi\App;

if (!function_exists('route')) {

    /**
     * Get the route path
     *
     * @param $name
     * @param array $params
     * @return mixed
     */
    function route($name, $params = [])
    {
        $router = app()->getContainer()->router;

        return $router->getUrlOfNamedRoute($name, $params);
    }
}

if (!function_exists('view')) {

    /**
     * Pass data to the view
     *
     * @param $view
     * @param array $variables
     * @throws ViewNotFoundException
     */
    function view($view, $variables = [])
    {
        $view = str_replace('.', '/', $view);

        $path = BASE_PATH . DS ."app/Views/{$view}.chibi.php";
        if (!(file_exists($path))) {
            throw new ViewNotFoundException("The {$view} view is not found");
        }
        $template = new Template($path);
        $template->fill($variables)->compile()->render();
    }
}

if (!function_exists('redirect')) {

    /**
     * Redirect to a specific path
     *
     * @param $path
     * @param array $vars
     */
    function redirect($path, $vars = [])
    {
        if(count($vars) !== 0){
            foreach ($vars as $key => $value){
                flash($key, $value);
            }
        }
        header("Location: {$path}");
    }
}

if (!function_exists('env')) {
    function env($key,$default = '') {
        return getenv($key) ? getenv($key) : $default;
    }
}

if (!function_exists('bdump')) {
    function bdump() {
        $args = func_get_args();
        foreach ($args as $value) {
            if (function_exists('dump')) {
                dump($value);
            } else {
                var_dump($value);
            }
        }
        if (!function_exists('dump')) {
            echo '<style>pre.sf-dump .sf-dump-str{color: #3A69DB;}pre.sf-dump, pre.sf-dump .sf-dump-default{background-color: #F3F3F3;border:1px dashed #cfcfcf}pre.sf-dump .sf-dump-public{color: #333;}</style>';
        }
        exit;
    }
}

if (!function_exists('base_url')) {

    /**
     * Get the base url
     */
    function base_url()
    {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];

        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
        $pathInfo = pathinfo($currentPath);

        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];

        // output: http://
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

        // return: http://localhost/myproject/
        return $protocol.'://'.$hostName.$pathInfo['dirname']."/";
    }
}

if (!function_exists('app')) {
    /**
     * Get the app
     * @param null $key
     * @return string
     */
    function app($key = null) {
        $app = App::getInstance();
        if(is_null($key)){
            return $app;
        }

        return $app->getContainer()->{$key};
    }
}

if (!function_exists('get_class_name')) {

    /**
     * Get the class Name without namespace
     *
     * @param $class
     * @return string
     * @throws ReflectionException
     */
    function get_class_name($class) {
        return (new ReflectionClass($class))->getShortName();
    }
}

if (!function_exists('get_crsf_token')) {
    /**
     * Get the generated token
     *
     * @return string
     */
    function get_crsf_token() {
        return \Chibi\Session\Session::get('csrf_token');
    }
}

if (!function_exists('base_path')) {
    /**
     * get app base path
     * @param  string $path get given path
     * @return string       [description]
     */
    function base_path($path = '') {
        return dirname(dirname(__dir__)).($path == ''?'': '/'.$path);
    }
}

if (!function_exists('flash')) {

    /**
     * Get the flash
     *
     * @param $key
     * @param null $value
     * @return bool|mixed|null
     */
    function flash($key, $value = null)
    {
        if(!is_null($value)){

            Flash::put($key, $value);

            return true;
        }

        if($value = Flash::get($key))
        {
            Flash::forget($key);

            return $value;
        }

        return null;
    }
}
