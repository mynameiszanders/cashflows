<?php

    namespace Nosco\Cashflows;

    abstract class AbstractResponse
    {

        const CHECK_NOT_CHECKED     = 0;
        const CHECK_UNAVAILABLE     = 1;
        const CHECK_FULL_MATCH      = 2;
        const CHECK_PARTIAL_MATCH   = 3;
        const CHECK_NOT_MATCHED     = 4;
        const CHECK_ERROR           = 5;

        protected $transactionId;
        protected $cvvCheck = 0;
        protected $addressCheck = 0;
        protected $postcodeCheck = 0;
        protected $authCode;
        protected $message = 'Authorised';

        public function __construct($transactionId, $checks, $authCode)
        {
            $this->transactionId = $transactionId;
            $this->authCode = $authCode;
            $checks = str_split($checks);
            list($this->cvvCheck, $this->addressCheck, $this->postcodeCheck) = $checks;
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
            return $this->cvvCheck;
        }

        /**
         * Get Address Check
         *
         * @access public
         * @return integer
         */
        public function getAddressCheck()
        {
            return $this->addressCheck;
        }

        /**
         * Get Postcode Check
         *
         * @access public
         * @return integer
         */
        public function getPostcodeCheck()
        {
            return $this->postcodeCheck;
        }

        /**
         * Get Authorisation Code
         *
         * @access public
         * @return string
         */
        public function getAuthCode()
        {
            return $this->authCode;
        }

        /**
         * Get Message
         *
         * @access public
         * @return string
         */
        public function getMessage()
        {
            return $this->message;
        }

    }
