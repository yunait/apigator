<?php

namespace Model\Base;

/**
 * Base class of Model\Book document.
 */
abstract class Book extends \Mongator\Document\Document
{

    /**
     * Initializes the document defaults.
     */
    public function initializeDefaults()
    {
        $this->setComment('good');
        $this->setIsHere(true);
    }

    /**
     * Set the document data (hydrate).
     *
     * @param array $data  The document data.
     * @param bool  $clean Whether clean the document.
     *
     * @return \Model\Book The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if (true || $clean) {
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
        if (isset($data['title'])) {
            $this->data['fields']['title'] = (string) $data['title'];
        }
        if (isset($data['comment'])) {
            $this->data['fields']['comment'] = (string) $data['comment'];
        }
        if (isset($data['isHere'])) {
            $this->data['fields']['isHere'] = (bool) $data['isHere'];
        }

        return $this;
    }

    /**
     * Set the "title" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Book The document (fluent interface).
     */
    public function setTitle($value)
    {
        if (!isset($this->data['fields']['title'])) {
            if (!$this->isNew()) {
                $this->getTitle();
                if (
                    ( is_object($value) && $value == $this->data['fields']['title'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['title'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['title'] = null;
                $this->data['fields']['title'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['title'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['title'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['title']) && !array_key_exists('title', $this->fieldsModified)) {
            $this->fieldsModified['title'] = $this->data['fields']['title'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['title'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['title'] )
        ) {
            unset($this->fieldsModified['title']);
        }

        $this->data['fields']['title'] = $value;

        return $this;
    }

    /**
     * Returns the "title" field.
     *
     * @return mixed The $name field.
     */
    public function getTitle()
    {
        $this->addFieldCache('title');

        if (!isset($this->data['fields']['title']) &&
            !$this->isFieldInQuery('title'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['title'])) {
            $this->data['fields']['title'] = null;
        }

        return $this->data['fields']['title'];
    }

    /**
     * Set the "comment" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Book The document (fluent interface).
     */
    public function setComment($value)
    {
        if (!isset($this->data['fields']['comment'])) {
            if (!$this->isNew()) {
                $this->getComment();
                if (
                    ( is_object($value) && $value == $this->data['fields']['comment'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['comment'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['comment'] = null;
                $this->data['fields']['comment'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['comment'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['comment'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['comment']) && !array_key_exists('comment', $this->fieldsModified)) {
            $this->fieldsModified['comment'] = $this->data['fields']['comment'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['comment'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['comment'] )
        ) {
            unset($this->fieldsModified['comment']);
        }

        $this->data['fields']['comment'] = $value;

        return $this;
    }

    /**
     * Returns the "comment" field.
     *
     * @return mixed The $name field.
     */
    public function getComment()
    {
        $this->addFieldCache('comment');

        if (!isset($this->data['fields']['comment']) &&
            !$this->isFieldInQuery('comment'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['comment'])) {
            $this->data['fields']['comment'] = null;
        }

        return $this->data['fields']['comment'];
    }

    /**
     * Set the "isHere" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Book The document (fluent interface).
     */
    public function setIsHere($value)
    {
        if (!isset($this->data['fields']['isHere'])) {
            if (!$this->isNew()) {
                $this->getIsHere();
                if (
                    ( is_object($value) && $value == $this->data['fields']['isHere'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['isHere'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['isHere'] = null;
                $this->data['fields']['isHere'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['isHere'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['isHere'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['isHere']) && !array_key_exists('isHere', $this->fieldsModified)) {
            $this->fieldsModified['isHere'] = $this->data['fields']['isHere'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['isHere'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['isHere'] )
        ) {
            unset($this->fieldsModified['isHere']);
        }

        $this->data['fields']['isHere'] = $value;

        return $this;
    }

    /**
     * Returns the "isHere" field.
     *
     * @return mixed The $name field.
     */
    public function getIsHere()
    {
        $this->addFieldCache('isHere');

        if (!isset($this->data['fields']['isHere']) &&
            !$this->isFieldInQuery('isHere'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['isHere'])) {
            $this->data['fields']['isHere'] = null;
        }

        return $this->data['fields']['isHere'];
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
        if ('title' == $name) {
            return $this->setTitle($value);
        }
        if ('comment' == $name) {
            return $this->setComment($value);
        }
        if ('isHere' == $name) {
            return $this->setIsHere($value);
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
        if ('title' == $name) {
            return $this->getTitle();
        }
        if ('comment' == $name) {
            return $this->getComment();
        }
        if ('isHere' == $name) {
            return $this->getIsHere();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\Book The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['comment'])) {
            $this->setComment($array['comment']);
        }
        if (isset($array['isHere'])) {
            $this->setIsHere($array['isHere']);
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
        $array['title'] = $this->getTitle();
        $array['comment'] = $this->getComment();
        $array['isHere'] = $this->getIsHere();

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
                if (isset($this->data['fields']['title'])) {
                    $query['title'] = (string) $this->data['fields']['title'];
                }
                if (isset($this->data['fields']['comment'])) {
                    $query['comment'] = (string) $this->data['fields']['comment'];
                }
                if (isset($this->data['fields']['isHere'])) {
                    $query['isHere'] = (bool) $this->data['fields']['isHere'];
                }
            } else {
                if (isset($this->data['fields']['title']) || array_key_exists('title', $this->data['fields'])) {
                    $value = $this->data['fields']['title'];
                    $originalValue = $this->getOriginalFieldValue('title');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['title'] = (string) $this->data['fields']['title'];
                        } else {
                            $query['$unset']['title'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['comment']) || array_key_exists('comment', $this->data['fields'])) {
                    $value = $this->data['fields']['comment'];
                    $originalValue = $this->getOriginalFieldValue('comment');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['comment'] = (string) $this->data['fields']['comment'];
                        } else {
                            $query['$unset']['comment'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['isHere']) || array_key_exists('isHere', $this->data['fields'])) {
                    $value = $this->data['fields']['isHere'];
                    $originalValue = $this->getOriginalFieldValue('isHere');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['isHere'] = (bool) $this->data['fields']['isHere'];
                        } else {
                            $query['$unset']['isHere'] = 1;
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