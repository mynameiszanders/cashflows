<?php

    namespace Nosco\Cashflows\Exceptions\Response;

    use Nosco\Cashflows\Exceptions\ResponseException;

    class NotAuthorisedException extends ResponseException
    {

        protected $transactionId;
        protected $cvvCheck = 0;
        protected $addressCheck = 0;
        protected $postcodeCheck = 0;
        protected $errorCode;

        /**
         * Constructor
         *
         * @access public
         * @param string $transactionId
         * @param string $checks
         * @param string $errorCode
         * @param string $message
         * @param Exception $previous
         * @return void
         */
        public function __construct($transactionId, $checks, $errorCode, $message, \Exception $previous = null)
        {
            $this->transactionId = $transactionId;
            $checks = str_split($checks);
            list($this->cvvCheck, $this->addressCheck, $this->postcodeCheck) = $checks;
            $this->errorCode = $errorCode;
            parent::__construct($message, (int) preg_replace('/[^0-9]/', '', $errorCode), $previous);
        }

        /**
         * Get Transaction ID
         *
         * @access public
         * @return string
         */
        public function getTransactionId()
        {
            return $this->transactionId;
        }

        /**
         * Get CVV Check
         *
         * @access public
         * @return integer
         */
        public function getCvvCheck()
        {
            return (int) $this->cvvCheck;
        }

        /**
         * Get Address Check
         *
         * @access public
         * @return integer
         */
        public function getAddressCheck()
        {
            return (int) $this->addressCheck;
        }

        /**
         * Get Postcode Check
         *
         * @access public
         * @return integer
         */
        public function getPostcodeCheck()
        {
            return (int) $this->postcodeCheck;
        }

        /**
         * Get Error Code
         *
         * @access public
         * @return string
         */
        public function getErrorCode()
        {
            return $this->errorCode;
        }

    }
