<?php

    namespace Nosco\Cashflows\Response;

    use Nosco\Cashflows\AbstractResponse;

    class Authorised extends AbstractResponse
    {

        /**
         * @access protected
         * @var string $message
         */
        protected $message = 'Authorised';

        /**
         * Constructor
         *
         * @access public
         * @return void
         */
        public function __construct($transactionId, $checks, $authCode)
        {
            parent::__construct($transactionId, $checks, $authCode, $this->message);
        }

    }
