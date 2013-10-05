<?php

namespace Model\Base;

/**
 * Base class of Model\User document.
 */
abstract class User extends \Mongator\Document\Document
{

    /**
     * Initializes the document defaults.
     */
    public function initializeDefaults()
    {
    }

    /**
     * Set the document data (hydrate).
     *
     * @param array $data  The document data.
     * @param bool  $clean Whether clean the document.
     *
     * @return \Model\User The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['_query_hash'])) {
            $this->addQueryHash($data['_query_hash']);
        }
        if (isset($data['_query_fields'])) {
            $this->setQueryFields($data['_query_fields']);
        }
        if (isset($data['_id'])) {
            $this->setId($data['_id']);
            $this->setIsNew(false);
        }
        if (isset($data['username'])) {
            $this->data['fields']['username'] = (string) $data['username'];
        }

        return $this;
    }

    /**
     * Set the "username" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\User The document (fluent interface).
     */
    public function setUsername($value)
    {
        if (!isset($this->data['fields']['username'])) {
            if (!$this->isNew()) {
                $this->getUsername();
                if (
                    ( is_object($value) && $value == $this->data['fields']['username'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['username'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['username'] = null;
                $this->data['fields']['username'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['username'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['username'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['username']) && !array_key_exists('username', $this->fieldsModified)) {
            $this->fieldsModified['username'] = $this->data['fields']['username'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['username'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['username'] )
        ) {
            unset($this->fieldsModified['username']);
        }

        $this->data['fields']['username'] = $value;

        return $this;
    }

    /**
     * Returns the "username" field.
     *
     * @return mixed The $name field.
     */
    public function getUsername()
    {
        $this->addFieldCache('username');

        if (!isset($this->data['fields']['username']) &&
            !$this->isFieldInQuery('username'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['username'])) {
            $this->data['fields']['username'] = null;
        }

        return $this->data['fields']['username'];
    }

    /**
     * Process onDelete.
     */
    public function processOnDelete()
    {
    }

    private function processOnDeleteCascade($class, array $criteria)
    {
        $repository = $this->getMongator()->getRepository($class);
        $documents = $repository->createQuery($criteria)->all();
        if (count($documents)) {
            $repository->delete($documents);
        }
    }

    private function processOnDeleteUnset($class, array $criteria, array $update)
    {
        $this->getMongator()->getRepository($class)->update($criteria, $update, array('multiple' => true));
    }

    /**
     * Set a document data value by data name as string.
     *
     * @param string $name  The data name.
     * @param mixed  $value The value.
     *
     * @return mixed the data name setter return value.
     *
     * @throws \InvalidArgumentException If the data name is not valid.
     */
    public function set($name, $value)
    {
        if ('username' == $name) {
            return $this->setUsername($value);
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Returns a document data by data name as string.
     *
     * @param string $name The data name.
     *
     * @return mixed The data name getter return value.
     *
     * @throws \InvalidArgumentException If the data name is not valid.
     */
    public function get($name)
    {
        if ('username' == $name) {
            return $this->getUsername();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\User The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['username'])) {
            $this->setUsername($array['username']);
        }

        return $this;
    }

    /**
     * Export the document data to an array.
     *
     * @param Boolean $withReferenceFields Whether include the fields of references or not (false by default).
     *
     * @return array An array with the document data.
     */
    public function toArray($withReferenceFields = false)
    {
        $array = array('id' => $this->getId());
        $array['username'] = $this->getUsername();

        return $array;
    }

    /**
     * Query for save.
     */
    public function queryForSave()
    {
        $isNew = $this->isNew();
        $query = array();
        $reset = false;

        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                if (isset($this->data['fields']['username'])) {
                    $query['username'] = (string) $this->data['fields']['username'];
                }
            } else {
                if (isset($this->data['fields']['username']) || array_key_exists('username', $this->data['fields'])) {
                    $value = $this->data['fields']['username'];
                    $originalValue = $this->getOriginalFieldValue('username');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['username'] = (string) $this->data['fields']['username'];
                        } else {
                            $query['$unset']['username'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }


        return $query;
    }
}