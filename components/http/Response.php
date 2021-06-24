<?php

namespace components\http;

class Response extends ResponseBase
{
    private $message;
    private $status;
    private $headers;
    private $stringMessage;
    private $type;

    /**
     * Response constructor.
     *
     * @param array $message
     * @param int $status
     * @param string $type //TODO: make it enum
     * @param array $headers
     */
    public function __construct($message, $status = 200, $type = 'json',  $headers = [])
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Send http response
     *
     * @throws ResponseException
     */
    public function execute() {
        switch ($this->type) {
            case 'json':
                $this->setToJson();
                break;
            case 'query-string':
                $this->setToQueryString();
                break;
            default:
                throw new ResponseException('Invalid response type.');
        }

        $this->setStatus();
        $this->setHeaders();
        echo $this->stringMessage;
    }

    /**
     * Send headers
     */
    private function setHeaders() {
        foreach ($this->headers as $header) {
            header($header);
        }
    }

    /**
     * Send status
     */
    private function setStatus() {
        http_response_code($this->status);
    }

    /**
     * Apply JSON response
     *
     * @throws ResponseException
     */
    private function setToJson() {
        $encodedMessage = json_encode($this->message);
        if ($encodedMessage === false) {
            throw new ResponseException('Json encoding failed.');
        } else {
            $this->stringMessage =  $encodedMessage;
            $this->headers[] = 'Content-Type:application/json';
        }
    }

    /**
     * Apply FORM response
     *
     * @throws ResponseException
     */
    private function setToQueryString() {
        if (is_array($this->message) || is_object($this->message)) {
            $this->stringMessage = http_build_query($this->message);
            $this->headers[] = 'Content-Type:application/x-www-form-urlencoded';
        } else {
            throw new ResponseException('Query String encoding failed');
        }
    }
}