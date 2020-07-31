<?php

namespace AsanFinance\Traits;

use AsanFinance\Exceptions\BadRequestException;
use AsanFinance\Exceptions\BaseException;
use AsanFinance\Exceptions\MalformedResponseException;
use AsanFinance\Exceptions\ValidationException;

trait Requestable {

    private $request, $response;

    /**
     * Send request with some credentials
     *
     * @param string $endpoint
     * @param array  $body
     * @param string $method
     *
     * @return mixed|string
     */
    public function send(string $endpoint, array $body = [], string $method = 'get'):string {
        $method = strtolower($method);

        $this->request = $body;

        /** @var $response \Psr\Http\Message\ResponseInterface */
        $response = $this->handler->$method($endpoint, [
            'json' => $body
        ]);

        $body = $response->getBody()->getContents();

        $this->response = json_decode($body, TRUE);

        try {
            if(!$body = json_decode($body)) throw new MalformedResponseException();

            $this->checkResponse($body);
        }catch (BaseException $e) {
            return $this->response([], $e->getMessage(), $e->getCode(), FALSE);
        }

        return $this->response($body->Response);
    }

    /**
     * Check response for given rules
     *
     * @param \stdClass $body
     *
     * @throws \AsanFinance\Exceptions\BadRequestException
     * @throws \AsanFinance\Exceptions\MalformedResponseException
     * @throws \AsanFinance\Exceptions\ValidationException
     */
    private function checkResponse(\stdClass $body) : void {
        if(empty($body->RequestIdentifier)) throw new MalformedResponseException('Missing `RequestIdentifier` key on response');
        if(empty($body->Response)) throw new MalformedResponseException('Missing `Response` key on response');
        if(empty($body->Status)) throw new MalformedResponseException('Missing `Status` key on response');
        if(empty($body->Status->Name)) throw new MalformedResponseException('Missing `Status->Name` key on response');
        if(empty($body->Status->Code) || !is_int($body->Status->Code)) throw new MalformedResponseException('Missing `Status->Code` key on response');

        if($body->Status->Code === self::SUCCESSFULLY_RESPONSE_CODE && $body->Status->Name === self::SUCCESSFULLY_RESPONSE_MESSAGE) return;

        if($body->RequestIdentifier !== $this->uuid) throw new MalformedResponseException('`RequestIdentifier` isn\'t correct');

        if(empty($body->Status->Message)) throw new MalformedResponseException('Missing `Messaged` key on response');

        if($body->Status->Code === self::VALIDATION_ERROR_CODE && $body->Status->Name === self::VALIDATION_ERROR_MESSAGE) {
            throw new BadRequestException($body->Status->Message);
        }

        if($body->Status->Code === self::SERVICE_ERROR_CODE && $body->Status->Name === self::SERVICE_ERROR_MESSAGE) {
            throw new ValidationException($body->Status->Message);
        }

    }

    /**
     * Parse given data as formatted JSON object
     *
     * @param array  $body
     * @param string $message
     * @param int    $code
     *
     * @param bool   $success
     *
     * @return string
     */
    private function response(array $body = [], string $message = 'OK', int $code = 200, bool $success = TRUE) : string {
        if(!$success && $this->onFailed) call_user_func($this->onFailed, $this->request, $this->response);
        if($success && $this->onSuccess) call_user_func($this->onSuccess, $this->request, $this->response);

        return json_encode([
            'code'    => $code,
            'success' => $success,
            'message' => $message,
            'body'    => $body
        ], JSON_FORCE_OBJECT);
    }

}