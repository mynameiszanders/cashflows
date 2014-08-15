<?php

    namespace Nosco\Cashflows\Response;

    use Nosco\Cashflows\AbstractResponse;

    class Authorised extends AbstractResponse
    {

        /**
         * Constructor
         *
         * @access public
         * @return void
         */
        public function __construct($transactionId, $checks, $authCode)
        {
            parent::__construct($transactionId, $checks, $authCode, $message);
        }

    }
