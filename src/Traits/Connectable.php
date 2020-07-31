<?php

namespace AsanFinance\Traits;

use GuzzleHttp\Client as HttpClient;

trait Connectable {

    private $handler, $uuid;

    /**
     * Connectable constructor.
     */
    public function __construct() {
        $this->handler = new HttpClient([
            'base_uri'    => self::BASE_URI,
            'debug'       => self::DEBUG,
            'timeout'     => self::REQUEST_TIMEOUT,
            'verify'      => self::VERIFY_PEER,
            'http_errors' => FALSE,
            'headers'     => [
                'ApiKey'            => self::KEY,
                'RequestIdentifier' => $this->uuid = $this->generateUUID(),
                'Content-Type'      => 'application/json',
                'Accept'            => 'application/json'
            ],
        ]);
    }

    /**
     * Generates UUID for AsanFinance Request
     *
     * @return string
     */
    private function generateUUID() : string {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }

}