<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/12/2017
 * Time: 17:58
 */

namespace Acme\Exceptions;


class CustomExceptions extends \Exception
{
    public function customMessage()
    {
        echo "Message: " . $this->getMessage(). "<br />";
        echo "File: " . $this->getFile(). "<br />";
        echo "Line: " . $this->getLine(). "<br />";
        echo "Trace: <br />" . $this->getTraceAsString(). "<br />";
    }
}