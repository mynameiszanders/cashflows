<?php

    namespace Nosco\Cashflows\Exceptions\Response;

    use Nosco\Cashflows\Exceptions\ResponseException;

    class NotAuthorisedException extends ResponseException
    {

        protected $transactionId;
        protected $cvvCheck = 0;
        protected $addressCheck = 0;
        protected $postcodeCheck = 0;

        public function __construct($transactionId, $checks, $authCode, $message)
        {
            $this->transactionId = $transactionId;
            $checks = str_split($checks);
            list($this->cvvCheck, $this->addressCheck, $this->postcodeCheck) = $checks;
            parent::__construct($message, $authCode);
        }

    }
