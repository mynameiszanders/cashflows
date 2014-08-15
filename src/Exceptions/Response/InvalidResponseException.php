<?php

    namespace Nosco\Cashflows\Exceptions\Response;

    use Nosco\Cashflows\Exceptions\ResponseException;

    class InvalidResponseException extends ResponseException
    {

        /**
         * @access protected
         * @var string $body
         */
        protected $body;

        /**
         * Constructor
         *
         * @access public
         * @param string $message
         * @param integer $responseStatusCode
         * @param string $bodyContent
         * @return void
         */
        public function __construct($message = null, $responseStatusCode = null, $bodyContent = null, \Exception $e = null)
        {
            $this->body = $bodyContent;
            parent::__construct($message, $responseStatusCode, $e);
        }

        /**
         * Get Response Body Content
         *
         * @access public
         * @return string
         */
        public function getBody()
        {
            return $this->body;
        }

    }
