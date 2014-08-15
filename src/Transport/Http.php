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
                $response = self::$guzzle->send($post);
            }
            catch(GuzzleHttp\Exception\TransferException $e) {
                throw new Exceptions\Transport('The transport adapter encountered an error: "' . $e->getMessage() . '"', $e->getCode(), $e);
            }
            $responseParts = preg_split('/\\s*\\|\\s*/', trim((string) $response->getBody()), -1, PREG_SPLIT_NO_EMPTY);
            if(is_array($responseParts) && count($responseParts) === 5) {
                switch($responseParts[0]) {
                    case 'A':
                        break;
                    case 'B':
                        throw new Exceptions\Response\NotAuthorised\Blocked($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'C':
                        throw new Exceptions\Response\NotAuthorised\Cancelled($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'D':
                    case 'R':
                        throw new Exceptions\Response\NotAuthorised\Declined($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'V':
                        throw new Exceptions\Response\NotAuthorised\InvalidRequest($responseParts[1], $responseParts[2], $responseParts[3], $responseParts[4]);
                        break;
                    case 'S':
                        throw new Exceptions\System;
                        break;
                    default:
                        throw new Exceptions\Response\InvalidResponse(
                            'An unrecongnised response code was returned from Cashflows.',
                            $response->getStatusCode(),
                            (string) $response->getBody()
                        );
                        break;
                }
                return new AuthorisedResponse($responseParts[1], $responseParts[2], $responseParts[3]);
            }
            else {
                throw new Exceptions\Response\InvalidResponse(
                    'An unrecognised response format was returned from Cashflows.',
                    $response->getStatusCode(),
                    (string) $response->getBody()
                );
            }
        }

    }
