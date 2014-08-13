<?php

    namespace Nosco\Cashflows;

    class FieldCollection implements \ArrayAccess, \Countable, \IteratorAggregate
    {

        protected $fields = [];

        /**
         * Get Offset
         *
         * @access public
         * @param string $offset
         * @return mixed
         */
        public function offsetGet($offset)
        {
            if(!$this->offsetExists($offset)) {
                throw new \OutOfRangeException('No field has been defined with given offset.');
            }
            return $this->fields[$offset]->getValue();
        }

        /**
         * Set Offset to Value
         *
         * @access public
         * @param string $offset
         * @param mixed $value
         * @return void
         */
        public function offsetSet($offset, $value)
        {
            if(!$this->offsetExists($offset)) {
                throw new \OutOfRangeException('No field has been defined with given offset.');
            }
            $this->fields[$offset]->setValue($value);
        }

        /**
         * Offset Exists?
         *
         * @access public
         * @return boolean
         */
        public function offsetExists($offset)
        {
            return isset($this->fields[$offset]);
        }

        /**
         * Unset Value at Offset
         *
         * @access public
         * @return void
         */
        public function offsetUnset($offset)
        {
            if($this->offsetExists($offset)) {
                $this->fields[$offset]->setValue(null);
            }
        }

        /**
         * Return Field Count
         *
         * @access public
         * @return integer
         */
        public function count()
        {
            return count($this->fields);
        }

        /**
         * Get Iterator
         *
         * @access public
         * @return Traversable
         */
        public function getIterator()
        {
            return new \ArrayIterator($this->fields);
        }

        public function addField($identifier, Field $field)
        {
            if($this->offsetExists($identifier)) {
                throw new \OutOfBoundsException('Field definition already exists for the given identifier.');
            }
            $this->fields[$identifier] = $field;
        }

        public function removeField($identifier)
        {
            unset($this->fields[$identifier]);
        }

        public function toArray()
        {
            $return = [];
            foreach($this->fields as $identifier => $field) {
                $return[$identifier] = $field->getValue();
            }
            return $return;
        }

        /**
         * Validate All Fields in Collection
         *
         * @access public
         * @return boolean
         */
        public function validate()
        {
            $validate = true;
            foreach($this->fields as $field) {
                $validate = $validate && $field->validate() === true;
            }
            return $validate;
        }

        public function getErrors()
        {
            $errors = [];
            foreach($this->fields as $identifier => $field) {
                $error = $field->validate();
                if(is_array($error)) {
                    $errors[$identifier] = $error;
                }
            }
            return $errors;
        }

    }
