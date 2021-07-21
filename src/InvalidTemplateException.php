<?php

namespace JuniReverseTemplator;

use Exception;

class InvalidTemplateException extends Exception {
    public function __construct()
    {
        parent::__construct("Invalid template.");
    }
}
