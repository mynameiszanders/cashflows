<?php

    namespace Nosco\Cashflows\Transport;

    use Nosco\Cashflows\TransportInterface;
    use GuzzleHttp\Client as Guzzle;

    class Http implements TransportInterface
    {

        /**
         * @static
         * @access private
         * @var Guzzle\Http\Client $guzzle
         */
        private static $guzzle;

        /**
         * Constructor
         *
         * @access public
         * @return void
         */
        public function __construct()
        {
            if(!self::$guzzle instanceof Guzzle) {
                self::$guzzle = new Guzzle;
            }
        }

        /**
         * Send Request
         *
         * @access public
         * @return Nosco\Cashflows\ResponseInterface
         */
        public function send($url, array $fields)
        {
            var_dump(func_get_args());
        }

    }
