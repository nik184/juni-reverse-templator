<?php

namespace JuniReverseTemplator;

use Exception;

class ResultTemplateMismatchException extends Exception {
    public function __construct()
    {
        parent::__construct("Result not matches original template");
    }
}
