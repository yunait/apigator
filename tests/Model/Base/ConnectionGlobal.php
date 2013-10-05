<?php

namespace Model\Base;

/**
 * Base class of Model\ConnectionGlobal document.
 */
abstract class ConnectionGlobal extends \Mongator\Document\Document
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
     * @return \Model\ConnectionGlobal The document (fluent interface).
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
        if (isset($data['field'])) {
            $this->data['fields']['field'] = (string) $data['field'];
        }

        return $this;
    }

    /**
     * Set the "field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\ConnectionGlobal The document (fluent interface).
     */
    public function setField($value)
    {
        if (!isset($this->data['fields']['field'])) {
            if (!$this->isNew()) {
                $this->getField();
                if (
                    ( is_object($value) && $value == $this->data['fields']['field'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['field'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['field'] = null;
                $this->data['fields']['field'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['field'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['field'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['field']) && !array_key_exists('field', $this->fieldsModified)) {
            $this->fieldsModified['field'] = $this->data['fields']['field'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['field'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['field'] )
        ) {
            unset($this->fieldsModified['field']);
        }

        $this->data['fields']['field'] = $value;

        return $this;
    }

    /**
     * Returns the "field" field.
     *
     * @return mixed The $name field.
     */
    public function getField()
    {
        $this->addFieldCache('field');

        if (!isset($this->data['fields']['field']) &&
            !$this->isFieldInQuery('field'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['field'])) {
            $this->data['fields']['field'] = null;
        }

        return $this->data['fields']['field'];
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
        if ('field' == $name) {
            return $this->setField($value);
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
        if ('field' == $name) {
            return $this->getField();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\ConnectionGlobal The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['field'])) {
            $this->setField($array['field']);
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
        $array['field'] = $this->getField();

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
                if (isset($this->data['fields']['field'])) {
                    $query['field'] = (string) $this->data['fields']['field'];
                }
            } else {
                if (isset($this->data['fields']['field']) || array_key_exists('field', $this->data['fields'])) {
                    $value = $this->data['fields']['field'];
                    $originalValue = $this->getOriginalFieldValue('field');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['field'] = (string) $this->data['fields']['field'];
                        } else {
                            $query['$unset']['field'] = 1;
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