<?php

    namespace Nosco\Cashflows;

    use Nosco\Cashflows\TransportInterface;
    use Nosco\Cashflows\Transport\Http as HttpTransport;
    use Nosco\Cashflows\AbstractRequest as RequestInterface;
    use Nosco\Cashflows\Request;

    class Client
    {

        /**
         * The base URL of the Cashflows API. It is prepended to each request.
         *
         * @const BASEAPI
         */
        const BASEAPI = 'https://secure.cashflows.com/gateway/remote';

        protected $authId;
        protected $authPass;

        /**
         * @static
         * @access private
         * @var TransportInterface $transport
         */
        static private $transport;

        /**
         * Get Transport Adapter
         *
         * @static
         * @access public
         * @return TransportInterface
         */
        public static function getTransport()
        {
            if(!self::$transport instanceof TransportInterface) {
                // Default to GuzzleHTTP.
                self::setTransport(new HttpTransport);
            }
            return self::$transport;
        }

        /**
         * Set Transport Adapter
         *
         * @static
         * @access public
         * @param TransportAdapter $transport
         * @return void
         */
        public static function setTransport(TransportInterface $transport)
        {
            self::$transport = $transport;
        }

        /**
         * Constructor
         *
         * @access public
         * @param string $authId
         * @param string $authPass
         * @return void
         */
        public function __construct($authId, $authPass)
        {
            $this->authId = $authId;
            $this->authPass = $authPass;
        }

        /**
         * Apply Auth Settings
         *
         * @access protected
         * @param Nosco\Cashflows\AbstractRequest $request
         * @return Nosco\Cashflows\AbstractRequest
         */
        protected function applyAuthSettings(RequestInterface $request)
        {
            $request->attributes([
                'auth_id' => $this->authId,
                'auth_pass' => $this->authPass,
            ]);
            return $request;
        }

        /**
         * New Payment Request
         *
         * @access public
         * @return Nosco\Cashflows\Request\Payment
         */
        public function paymentRequest()
        {
            $request = new Request\Payment;
            return $this->applyAuthSettings($request);
        }

        /**
         * New Mobile Payment Request
         *
         * @access public
         * @return Nosco\Cashflows\Request\Payment\Mobile
         */
        public function mobilePaymentRequest()
        {
            $request = new Request\Payment\Mobile;
            return $this->applyAuthSettings($request);
        }

        /**
         * New COntinuous Payment Request
         *
         * @access public
         * @return Nosco\Cashflows\Request\Payment\Continuous
         */
        public function continuousPaymentRequest()
        {
            $request = new Request\Payment\Continuous;
            return $this->applyAuthSettings($request);
        }

        /**
         * New Alternative Recurring Payment Request
         *
         * @access public
         * @return Nosco\Cashflows\Request\Payment\AlternativeRecurring
         */
        public function alternativeRecurringPaymentRequest()
        {
            $request = new Request\Payment\AlternativeRecurring;
            return $this->applyAuthSettings($request);
        }

        /**
         * New Void Transaction Request
         *
         * @access public
         * @return Nosco\Cashflows\Request\VoidTransaction
         */
        public function voidRequest()
        {
            $request = new Request\VoidTransaction;
            return $this->applyAuthSettings($request);
        }

        /**
         * New Refund Transaction Request
         *
         * @access public
         * @return Nosco\Cashflows\Request\Refund
         */
        public function refundRequest()
        {
            $request = new Request\Refund;
            return $this->applyAuthSettings($request);
        }

        /**
         * New Verification Request
         *
         * @access public
         * @return Nosco\Cashflows\Request\Verification
         */
        public function verificationRequest()
        {
            $request = new Request\Verification;
            return $this->applyAuthSettings($request);
        }

    }
