<?php

    namespace Nosco\Cashflows\Request;

    use Nosco\Cashflows\Client;
    use Nosco\Cashflows\AbstractRequest;
    use Respect\Validation\Validator as V;

    class Payment extends AbstractRequest
    {

        const VERB = 'post';
        const API_URI = 'remote';

        protected function getFieldDefinitions()
        {
            return [
                'auth_id'       => ['Authorisation ID',                                 V::notEmpty()->numeric()                                                       ],
                'auth_pass'     => ['Authorisation Password',                           V::notEmpty()->string()                                                        ],
                'card_num'      => ['Card Number',                                      V::notEmpty()->string()->length(16, 16)->digit()->noWhitespace()->creditCard() ],
                'card_cvv'      => ['Card CVV',                                         V::notEmpty()->string()->length(3, 3)->digit()->noWhitespace()                 ],
                'card_start'    => ['Card Start Date',                                  V::date('my')                                                                  ],
                'card_issue'    => ['Card Issue Number',                                V::string()  ->length(null, 2)->digit()->noWhitespace()                        ],
                'card_expiry'   => ['Card Expiry Date',                                 V::notEmpty()->date('my')                                                      ],
                'cust_name'     => ['Customer Name',                                    V::notEmpty()->string()                                                        ],
                'cust_address'  => ['Customer Address',                                 V::notEmpty()->string()                                                        ],
                'cust_postcode' => ['Customer Postcode',                                V::notEmpty()->string()                                                        ],
                'cust_country'  => ['Customer Country',                                 V::notEmpty()->string() ->countryCode()                                        ],
                'cust_ip'       => ['Customer IP Address',                              V::notEmpty()->string() ->ip(),                        $_SERVER['REMOTE_ADDR'] ],
                'cust_email'    => ['Customer Email Address',                           V::notEmpty()->string() ->email()                                              ],
                'cust_tel'      => ['Customer Telephone Number',                        V::notEmpty()->string() ->phone()                                              ],
                'tran_ref'      => ['Transaction Reference',                            V::notEmpty()->string()                                                        ],
                'tran_desc'     => ['Transaction Description',                          V::notEmpty()->string()                                                        ],
                'tran_amount'   => ['Transaction Amount',                               V::notEmpty()->float()                                                         ],
                'tran_currency' => ['Transaction Currency',                             V::notEmpty()->string() ->length(3, 3)->alpha()->noWhitespace()                ],
                'tran_testmode' => ['Test Mode',                                        V::notEmpty()->bool(),                                                   false ],
                'tran_class'    => ['Transaction Class',                                V::string()                                                                    ],
                'acs_eci'       => ['Access Control Server (ECI)',                      V::int()                                                                       ],
                'acs_cavv'      => ['Cardholder Authentication Verification Value',     V::string()  ->length(28, 28)                                                  ],
                'acs_xid'       => ['Access Control Server (Unique Authentication ID)', V::string()  ->length(28, 28)                                                  ],
            ];
        }

        protected function getAdditionalFields()
        {
            return [
                'tran_type' => 'sale',
            ];
        }

    }
