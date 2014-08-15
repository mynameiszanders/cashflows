<?php

    namespace Nosco\Cashflows\Request\Payment;

    use Nosco\Cashflows\AbstractRequest;
    use Respect\Validation\Validator as V;

    class Mobile extends AbstractRequest
    {

        /**
         * Get Fields Definitions
         *
         * @access public
         * @return array
         */
        protected function getFieldDefinitions()
        {
            return [
                'auth_id'       => ['Authorisation ID',                                 V::notEmpty()->numeric()                                                       ],
                'auth_pass'     => ['Authorisation Password',                           V::notEmpty()->string()                                                        ],
                'cust_mobile'   => ['Customer Mobile Phone Number',                     V::notEmpty()->string()                                                        ],
                'cust_ip'       => ['Customer IP Address',                              V::notEmpty()->string()->ip()                                                  ],
                'cust_email'    => ['Customer Email Address',                           V::notEmpty()->string() ->email()                                              ],
                'tran_ref'      => ['Transaction Reference',                            V::notEmpty()->string()                                                        ],
                'tran_desc'     => ['Transaction Description',                          V::notEmpty()->string()                                                        ],
                'tran_amount'   => ['Transaction Amount',                               V::notEmpty()->float()                                                         ],
                'tran_currency' => ['Transaction Currency',                             V::notEmpty()->string() ->length(3, 3)->alpha()->noWhitespace()                ],
            ];
        }

        /**
         * Get Addtitional Fields
         *
         * @access public
         * @return array
         */
        protected function getAdditionalFields()
        {
            return [
                'tran_type' => 'payment',
            ];
        }

        /**
         * Get API Segment
         *
         * @access public
         * @return string
         */
        protected function getApiSegment()
        {
            return 'remote_ivr';
        }

    }
