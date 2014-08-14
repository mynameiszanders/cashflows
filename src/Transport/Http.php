<?php

    namespace Nosco\Cashflows\Transport;

    use Nosco\Cashflows\TransportInterface;
    use GuzzleHttp\Client as Guzzle;
    use Nosco\Cashflows\Exceptions;
    use Nosco\Cashflows\Response\Authorised as AuthorisedResponse;

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
            $post = self::$guzzle->createRequest('POST', $url, ['body' => $fields]);
            try {
                $response = $self::$guzzle->send($post);
            }
            catch(GuzzleHttp\Exception\TransferException $e) {
                throw new TransportException('The transport adapter encountered an error: "' . $e->getMessage() . '"', $e->getCode(), $e);
            }
            $responseParts = preg_split('/\\s*\\\\|\\s*/', (string) $response->getBody(), -1, PREG_SPLIT_NO_EMPTY);
            if(is_array($responseParts) && count($responseParts) === 5) {
                switch($responseParts[0]) {
                    case 'A':
                        break;
                    case 'B':
                        throw new Exceptions\Response\NotAuthorised\BlockedException($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'C':
                        throw new Exceptions\Response\NotAuthorised\CancelledException($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'D':
                    case 'R':
                        throw new Exceptions\Response\NotAuthorised\DeclinedException($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'V':
                        throw new Exceptions\Response\InvalidRequestException($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'S':
                        throw new Exceptions\CashflowsSystemException;
                        break;
                    default:
                        throw new Exceptions\Response\InvalidResponseException;
                        break;
                }
                return new AuthorisedResponse($responseParts[1], $responseParts[2], $responseParts[3]);
            }
            else {
                throw new Exceptions\Response\InvalidResponseException;
            }
        }

    }
