<?php

    namespace Nosco\Cashflows;

    use Nosco\Cashflows\Field;
    use Nosco\Cashflows\FieldCollection;
    use Respect\Validation\Validator;

    abstract class AbstractRequest
    {

        /**
         * @access protected
         * @var Nosco\Cashflows\FieldCollection
         */
        protected $collection;

        /**
         * Constructor
         *
         * @access public
         * @return void
         */
        final public function __construct()
        {
            $this->collection = new FieldCollection;
            $fieldDefinitions = $this->getFieldDefinitions();
            if(!is_array($fieldDefinitions)) {
                throw new \UnexpectedValueException('Invalid field definitions for ' . get_called_class() . '. Array expected.');
            }
            foreach($fieldDefinitions as $fieldIdentifier => $fieldDefinition) {
                if(!is_string($fieldIdentifier) || empty($fieldIdentifier)) {
                    throw new \UnexpectedValueException('Invalid field identifier found in ' . get_called_class() . '. String expected.');
                }
                if(!is_string($fieldDefinition[0]) || empty($fieldDefinition[0])) {
                    throw new \UnexpectedValueException('Invalid field name found in ' . get_called_class() . '. String expected.');
                }
                // Create a new field instance with a name, validator and, if supplied, a default value.
                $field = new Field($fieldDefinition[0], $fieldDefinition[1], isset($fieldDefinition[2]) ? $fieldDefinition[2] : null);
                $this->collection->addField($fieldIdentifier, $field);
            }
        }

        /**
         * Get Field Definitions
         *
         * @abstract
         * @access protected
         * @return array
         */
        protected abstract function getFieldDefinitions();

        /**
         * Get Additional Fields
         *
         * @abstract
         * @access public
         * @return array
         */
        protected abstract function getAdditionalFields();

        /**
         * Get API Segment
         *
         * @access public
         * @return string
         */
        protected function getApiSegment()
        {
            return 'remote';
        }

        /**
         * Set Multiple Attributes
         *
         * @access public
         * @return void
         */
        public function attributes(array $attributes = null)
        {
            // If no attributes have been passed, return the currently-set ones.
            if(func_num_args() === 0 || $attributes === null) {
                return $this->collection->toArray();
            }
            // Otherwise, massive-assign the passed attributes.
            foreach($attributes as $attribute => $value) {
                if($this->collection->offsetExists($attribute)) {
                    $this->collection[$attribute] = $value;
                }
            }
        }

        /**
         * Validate Fields
         *
         * @final
         * @access public
         * @return boolean
         */
        final public function validate()
        {
            return $this->collection->validate();
        }

        /**
         * Get Validation Errors
         *
         * @final
         * @access public
         * @return array
         */
        final public function getErrors()
        {
            return $this->collection->getErrors();
        }

        /**
         * Send Request
         *
         * @access public
         * @return Nosco\Cashflows\Transport\ResponseInterface
         */
        public function send()
        {
            if(!$this->validate()) {
                throw new ValidationException();
            }
            Client::getTransport()->send(
                Client::BASEAPI . $this->getApiSegment(),
                $this->collection->toArray() + $this->getAdditionalFields()
            );
        }

    }
