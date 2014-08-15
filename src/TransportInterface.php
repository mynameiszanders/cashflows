<?php

    namespace Nosco\Cashflows;

    interface TransportInterface
    {

        /**
         * Send Request
         *
         * @access public
         * @throws Nosco\Cashflows\Exceptions\ResponseException
         * @return Nosco\Cashflows\Response
         */
        public function send($segment, array $fields);

    }
