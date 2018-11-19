<?php


namespace App\Exceptions;


class ThrottleException extends \Exception
{
    public function render($request)
    {
        return response('You are posting too frequently', 429);
    }
}