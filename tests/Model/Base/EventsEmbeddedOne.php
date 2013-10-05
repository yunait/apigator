<?php

namespace Model\Base;

/**
 * Base class of Model\EventsEmbeddedOne document.
 */
abstract class EventsEmbeddedOne extends \Mongator\Document\Document
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
     * @return \Model\EventsEmbeddedOne The document (fluent interface).
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
        if (isset($data['name'])) {
            $this->data['fields']['name'] = (string) $data['name'];
        }
        if (isset($data['embedded'])) {
            $embedded = $this->getMongator()->create('Model\EmbeddedEvents');
            $embedded->setRootAndPath($this, 'embedded');
            $embedded->setDocumentData($data['embedded']);
            $this->data['embeddedsOne']['embedded'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "name" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\EventsEmbeddedOne The document (fluent interface).
     */
    public function setName($value)
    {
        if (!isset($this->data['fields']['name'])) {
            if (!$this->isNew()) {
                $this->getName();
                if (
                    ( is_object($value) && $value == $this->data['fields']['name'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['name'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['name'] = null;
                $this->data['fields']['name'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['name'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['name'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['name']) && !array_key_exists('name', $this->fieldsModified)) {
            $this->fieldsModified['name'] = $this->data['fields']['name'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['name'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['name'] )
        ) {
            unset($this->fieldsModified['name']);
        }

        $this->data['fields']['name'] = $value;

        return $this;
    }

    /**
     * Returns the "name" field.
     *
     * @return mixed The $name field.
     */
    public function getName()
    {
        $this->addFieldCache('name');

        if (!isset($this->data['fields']['name']) &&
            !$this->isFieldInQuery('name'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['name'])) {
            $this->data['fields']['name'] = null;
        }

        return $this->data['fields']['name'];
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
     * Set the "embedded" embedded one.
     *
     * @param \Model\EmbeddedEvents|null $value The "embedded" embedded one.
     *
     * @return \Model\EventsEmbeddedOne The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the value is not an instance of Model\EmbeddedEvents or null.
     */
    public function setEmbedded($value)
    {
        if (null !== $value && !$value instanceof \Model\EmbeddedEvents) {
            throw new \InvalidArgumentException('The "embedded" embedded one is not an instance of Model\EmbeddedEvents.');
        }
        if (null !== $value) {
            if ($this instanceof \Mongator\Document\Document) {
                $value->setRootAndPath($this, 'embedded');
            } elseif ($rap = $this->getRootAndPath()) {
                $value->setRootAndPath($rap['root'], $rap['path'].'.embedded');
            }
        }

        if (!$this->getArchive()->has('embedded_one.embedded')) {
            $originalValue = isset($this->data['embeddedsOne']['embedded']) ? $this->data['embeddedsOne']['embedded'] : null;
            $this->getArchive()->set('embedded_one.embedded', $originalValue);
        } elseif ($this->getArchive()->get('embedded_one.embedded') === $value) {
            $this->getArchive()->remove('embedded_one.embedded');
        }

        $this->data['embeddedsOne']['embedded'] = $value;

        return $this;
    }

    /**
     * Returns the "embedded" embedded one.
     *
     * @return \Model\EmbeddedEvents|null The "embedded" embedded one.
     */
    public function getEmbedded()
    {
        if (!isset($this->data['embeddedsOne']['embedded'])) {
            if ($this->isNew()) {
                $this->data['embeddedsOne']['embedded'] = null;
            } elseif (
                !isset($this->data['embeddedsOne']) ||
                !array_key_exists('embedded', $this->data['embeddedsOne']))
            {
                if (!$this->isFieldInQuery('embedded')) {
                    $this->loadFull();
                }

                if (!isset($this->data['embeddedsOne']['embedded'])) {
                    $this->data['embeddedsOne']['embedded'] = null;
                }
            }
        }

        return $this->data['embeddedsOne']['embedded'];
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
        if ('name' == $name) {
            return $this->setName($value);
        }
        if ('embedded' == $name) {
            return $this->setEmbedded($value);
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
        if ('name' == $name) {
            return $this->getName();
        }
        if ('embedded' == $name) {
            return $this->getEmbedded();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\EventsEmbeddedOne The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['embedded'])) {
            $embedded = new \Model\EmbeddedEvents($this->getMongator());
            $embedded->fromArray($array['embedded']);
            $this->setEmbedded($embedded);
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
        $array['name'] = $this->getName();

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
                if (isset($this->data['fields']['name'])) {
                    $query['name'] = (string) $this->data['fields']['name'];
                }
            } else {
                if (isset($this->data['fields']['name']) || array_key_exists('name', $this->data['fields'])) {
                    $value = $this->data['fields']['name'];
                    $originalValue = $this->getOriginalFieldValue('name');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['name'] = (string) $this->data['fields']['name'];
                        } else {
                            $query['$unset']['name'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }
        if (isset($this->data['embeddedsOne'])) {
            $originalValue = $this->getOriginalEmbeddedOneValue('embedded');
            if (isset($this->data['embeddedsOne']['embedded'])) {
                $resetValue = $reset ? $reset : (!$isNew && $this->data['embeddedsOne']['embedded'] !== $originalValue);
                $query = $this->data['embeddedsOne']['embedded']->queryForSave($query, $isNew, $resetValue);
            } elseif (array_key_exists('embedded', $this->data['embeddedsOne'])) {
                if ($originalValue) {
                    $rap = $originalValue->getRootAndPath();
                    $query['$unset'][$rap['path']] = 1;
                }
            }
        }


        return $query;
    }
}