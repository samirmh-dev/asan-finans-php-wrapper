<?php

namespace AsanFinance\Exceptions;

class MalformedResponseException extends BaseException {

    protected $message = 'Response from AsanFinance isn\'t formatted as correct JSON string';

    protected $code = 400;

}