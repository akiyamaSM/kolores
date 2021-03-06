<?php

namespace Chibi\Hurdle;


use Chibi\Auth\Auth;
use Chibi\Request;
use Chibi\Response;

abstract class ShouldAuthenticate implements Wall, ShouldRedirect
{

    /**
     * Filter the Form inputs
     *
     * @param Request $request
     * @param Response $Response
     * @param array $guard
     * @return bool
     */
    public function filter(Request $request, Response $Response,  ...$guard)
    {
        if(Auth::guest()){
            return false;
        }

        $name = $this->defaultIfNull($guard);


        if(is_null(Auth::against($name)->user())){
            return false;
        }

        return true;
    }

    /**
     * Get the default guard if not found
     *
     * @param null $name
     * @return string|null
     */
    protected function defaultIfNull($name = null)
    {
        if(is_null($name)){

            $guards = include(BASE_PATH . DS . 'config/auth.php');

            return count($guards) == 0 ? null : array_keys($guards)[0];
        }

        return $name[0];
    }
}