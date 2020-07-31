<?php

namespace AsanFinance\Interfaces;

interface RequestInterface {

    const KEY                           = ASAN_FINANCE_KEY;

    const DEBUG                         = ASAN_FINANCE_DEBUG;

    const BASE_URI                      = ASAN_FINANCE_BASE_URI;

    const REQUEST_TIMEOUT               = ASAN_FINANCE_REQUEST_TIMEOUT;

    const VERIFY_PEER                   = ASAN_FINANCE_VERIFY_SSL_PEER;

    const SUCCESSFULLY_RESPONSE_CODE    = 0;

    const SUCCESSFULLY_RESPONSE_MESSAGE = "Successful";

    const VALIDATION_ERROR_CODE         = 1;

    const VALIDATION_ERROR_MESSAGE      = "ValidationError";

    const SERVICE_ERROR_CODE            = 2;

    const SERVICE_ERROR_MESSAGE         = "ServiceError";

    public function getPersonInfoByFin(string $fin) : string;

    public function getEmployeeInfoByFin(string $fin) : string;

    public function getBalanceInfo(string $startTimeStamp, string $endTimeStamp) : string;

    public function getPassportInfoByFin(string $fin) : string;

    public function getDmxInfoByFin(string $fin) : string;

    public function getLegalPersonInfoByTaxPayerNumber(string $taxPayerNumber) : string;

    public function getPersonInfoByVin(string $vin) : string;

    public function getAllPersonInfoByFin(string $fin) : string;

    public function getPensionInfoByFin(string $fin) : string;

    public function getFarmInfoByFin(string $fin) : string;

    public function getFarmInfoByTaxPayerNumber(string $taxPayerNumber) : string;

    public function getQhtInfoByTaxPayerNumber(string $taxPayerNumber) : string;

    public function send(string $endpoint, array $body = [], string $method = 'get') : string;

}