<?php

    namespace Nosco\Cashflows;

    use Respect\Validation\Validator;

    class Field
    {

        protected $name;
        protected $value;
        protected $validator;

        /**
         * Constructor
         *
         * @access public
         * @param string $name
         * @param Respect\Validation\Validator $validator
         * @return void
         */
        public function __construct($name, Validator $validator, $default = null)
        {
            $this->name = $name;
            $this->validator = $validator;
            $this->validator->setName($name);
            $this->setValue($default);
        }

        /**
         * Get Value
         *
         * @access public
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * Set Value
         *
         * @access public
         * @param mixed $value
         * @return void
         */
        public function setValue($value)
        {
            $this->value = $value;
        }

        /**
         * Validate
         *
         * Validate the field's value according to the rules set by the validation object passed to the constructor.
         *
         * @access public
         * @return boolean|array
         */
        public function validate()
        {
            try {
                $this->validator->assert($this->value);
                return true;
            }
            catch(\InvalidArgumentException $e) {
                $errors = [];
                foreach($e->getRelated() as $validationException) {
                    $errors[] = $validationException->getMessage();
                }
                return $errors;
            }
        }

    }
