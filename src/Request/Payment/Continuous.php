<?php

    namespace Nosco\Cashflows\Request\Payment;

    use Nosco\Cashflows\AbstractRequest;
    use Respect\Validation\Validator as V;

    class Continuous extends AbstractRequest
    {

        /**
         * Get Fields Definitions
         *
         * @access public
         * @return array
         */
        protected function getFieldDefinitions()
        {
            $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
            return [
                'auth_id'       => ['Authorisation ID',                                 V::notEmpty()->numeric()                                                       ],
                'auth_pass'     => ['Authorisation Password',                           V::notEmpty()->string()                                                        ],

                'cust_name'     => ['Customer Name',                                    V::notEmpty()->string()                                                        ],
                'cust_address'  => ['Customer Address',                                 V::notEmpty()->string()                                                        ],
                'cust_postcode' => ['Customer Postcode',                                V::notEmpty()->string()                                                        ],
                'cust_country'  => ['Customer Country',                                 V::notEmpty()->string() ->countryCode()                                        ],
                'cust_ip'       => ['Customer IP Address',                              V::notEmpty()->string() ->ip(),                                     $ipAddress ],
                'cust_email'    => ['Customer Email Address',                           V::notEmpty()->string() ->email()                                              ],
                'cust_tel'      => ['Customer Telephone Number',                        V::notEmpty()->string() ->phone()                                              ],
                'tran_ref'      => ['Transaction Reference',                            V::notEmpty()->string()                                                        ],
                'tran_desc'     => ['Transaction Description',                          V::notEmpty()->string()                                                        ],
                'tran_amount'   => ['Transaction Amount',                               V::notEmpty()->float()                                                         ],
                'tran_currency' => ['Transaction Currency',                             V::notEmpty()->string() ->length(3, 3)->alpha()->noWhitespace()                ],
                'tran_testmode' => ['Test Mode',                                        V::notEmpty()->bool(),                                                   false ],
                'tran_orig_id'  => ['Original Transaction ID',                          V::notEmpty()->string()->length(11, 11)                                        ],
                // Additional Fields for Merchants with the MCC 6012 (Financial Institutions).
                'primary_recipient_dob'             => ['Date of Birth (of Primary Recipient)',     V::date('Ymd')                                                     ],
                'primary_recipient_surname'         => ['Surname (of Primary Recipient)',           V::string()->length(2, 64)->alpha('-'),                         '' ],
                'primary_recipient_postcode'        => ['Postcode (of Primary Recipient)',          V::string()->length(2, 16)->alnum(),                            '' ],
                'primary_recipient_account_number'  => ['Account Number (of Primary Recipient)',    V::string()->length(1, 32)->alnum('+-'),                        '' ],
            ];
        }

        /**
         * Get Additional Fields
         *
         * @access public
         * @return void
         */
        protected function getAdditionalFields()
        {
            return [
                'tran_type' => 'sale',
                'tran_class' => 'cont',
            ];
        }

    }
