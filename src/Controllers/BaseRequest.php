<?php

namespace AsanFinance\Controllers;

use AsanFinance\Interfaces\RequestInterface;
use AsanFinance\Traits\Connectable;
use AsanFinance\Traits\Requestable;
use DateTime;
use Throwable;

abstract class BaseRequest implements RequestInterface {

    use Connectable, Requestable {
        Connectable::__construct as private constructConnect;
    }

    /**
     * @var callable
     */
    private $onFailed;

    /**
     * @var callable
     */
    private $onSuccess;

    /**
     * BaseRequest constructor.
     *
     * @param null|callable $onFailed
     * @param null|callable $onSuccess
     */
    public function __construct(callable $onFailed = NULL, callable $onSuccess = NULL) {
        $this->onFailed  = $onFailed;
        $this->onSuccess = $onSuccess;

        $this->constructConnect();
    }

    /**
     * Check if given timestamp is correct or not
     *
     * @param string $string
     *
     * @return bool
     */
    protected function isTimestamp(string $string) : bool {
        try {
            new DateTime('@' . $string);
        }catch (Throwable $e) {
            return FALSE;
        }

        return TRUE;
    }
}