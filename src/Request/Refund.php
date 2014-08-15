<?php

    namespace Nosco\Cashflows\Request;

    use Nosco\Cashflows\AbstractRequest;
    use Respect\Validation\Validator as V;

    class Refund extends AbstractRequest
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
                'tran_amount'   => ['Transaction Amount',                               V::notEmpty()->float()                                                         ],
                'tran_currency' => ['Transaction Currency',                             V::notEmpty()->string() ->length(3, 3)->alpha()->noWhitespace()                ],
                'tran_testmode' => ['Test Mode',                                        V::notEmpty()->bool(),                                                   false ],
                'tran_orig_id'  => ['Original Transaction ID',                          V::notEmpty()->string()->length(11, 11)                                        ],
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
                'tran_type' => 'refund',
                'tran_class' => 'ecom',
            ];
        }

    }
