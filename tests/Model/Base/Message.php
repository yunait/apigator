<?php

namespace Model\Base;

/**
 * Base class of Model\Message document.
 */
abstract class Message extends \Mongator\Document\Document
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
     * @return \Model\Message The document (fluent interface).
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
        if (isset($data['author'])) {
            $this->data['fields']['author'] = (string) $data['author'];
        }
        if (isset($data['text'])) {
            $this->data['fields']['text'] = (string) $data['text'];
        }
        if (isset($data['replyTo'])) {
            $this->data['fields']['replyToId'] = $data['replyTo'];
        }

        return $this;
    }

    /**
     * Set the "author" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Message The document (fluent interface).
     */
    public function setAuthor($value)
    {
        if (!isset($this->data['fields']['author'])) {
            if (!$this->isNew()) {
                $this->getAuthor();
                if (
                    ( is_object($value) && $value == $this->data['fields']['author'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['author'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['author'] = null;
                $this->data['fields']['author'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['author'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['author'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['author']) && !array_key_exists('author', $this->fieldsModified)) {
            $this->fieldsModified['author'] = $this->data['fields']['author'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['author'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['author'] )
        ) {
            unset($this->fieldsModified['author']);
        }

        $this->data['fields']['author'] = $value;

        return $this;
    }

    /**
     * Returns the "author" field.
     *
     * @return mixed The $name field.
     */
    public function getAuthor()
    {
        $this->addFieldCache('author');

        if (!isset($this->data['fields']['author']) &&
            !$this->isFieldInQuery('author'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['author'])) {
            $this->data['fields']['author'] = null;
        }

        return $this->data['fields']['author'];
    }

    /**
     * Set the "text" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Message The document (fluent interface).
     */
    public function setText($value)
    {
        if (!isset($this->data['fields']['text'])) {
            if (!$this->isNew()) {
                $this->getText();
                if (
                    ( is_object($value) && $value == $this->data['fields']['text'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['text'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['text'] = null;
                $this->data['fields']['text'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['text'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['text'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['text']) && !array_key_exists('text', $this->fieldsModified)) {
            $this->fieldsModified['text'] = $this->data['fields']['text'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['text'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['text'] )
        ) {
            unset($this->fieldsModified['text']);
        }

        $this->data['fields']['text'] = $value;

        return $this;
    }

    /**
     * Returns the "text" field.
     *
     * @return mixed The $name field.
     */
    public function getText()
    {
        $this->addFieldCache('text');

        if (!isset($this->data['fields']['text']) &&
            !$this->isFieldInQuery('text'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['text'])) {
            $this->data['fields']['text'] = null;
        }

        return $this->data['fields']['text'];
    }

    /**
     * Set the "replyToId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Message The document (fluent interface).
     */
    public function setReplyToId($value)
    {
        if (!isset($this->data['fields']['replyToId'])) {
            if (!$this->isNew()) {
                $this->getReplyToId();
                if (
                    ( is_object($value) && $value == $this->data['fields']['replyToId'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['replyToId'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['replyToId'] = null;
                $this->data['fields']['replyToId'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['replyToId'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['replyToId'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['replyToId']) && !array_key_exists('replyToId', $this->fieldsModified)) {
            $this->fieldsModified['replyToId'] = $this->data['fields']['replyToId'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['replyToId'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['replyToId'] )
        ) {
            unset($this->fieldsModified['replyToId']);
        }

        $this->data['fields']['replyToId'] = $value;

        return $this;
    }

    /**
     * Returns the "replyToId" field.
     *
     * @return mixed The $name field.
     */
    public function getReplyToId()
    {
        $this->addFieldCache('replyTo');

        if (!isset($this->data['fields']['replyToId']) &&
            !$this->isFieldInQuery('replyToId'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['replyToId'])) {
            $this->data['fields']['replyToId'] = null;
        }

        return $this->data['fields']['replyToId'];
    }

    /**
     * Set the "replyTo" reference.
     *
     * @param \Model\Message|null $value The reference, or null.
     *
     * @return \Model\Message The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the class is not an instance of Model\Message.
     */
    public function setReplyTo($value)
    {
        if (null !== $value && !$value instanceof \Model\Message) {
            throw new \InvalidArgumentException('The "replyTo" reference is not an instance of Model\Message.');
        }

        $this->setReplyToId((null === $value || $value->isNew()) ? null : $value->getId());

        $this->data['referencesOne']['replyTo'] = $value;

        return $this;
    }

    /**
     * Returns the "replyTo" reference.
     *
     * @return \Model\Message|null The reference or null if it does not exist.
     */
    public function getReplyTo()
    {
        if (!isset($this->data['referencesOne']['replyTo'])) {
            if (!$this->isNew()) {
                $this->addReferenceCache('replyTo');
            }
            if (!$id = $this->getReplyToId()) {
                return null;
            }
            if (!$document = $this->getMongator()->getRepository('Model\Message')->findOneById($id)) {
                throw new \RuntimeException('The reference "replyTo" does not exist.');
            }
            $this->data['referencesOne']['replyTo'] = $document;
        }

        return $this->data['referencesOne']['replyTo'];
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
     * Update the value of the reference fields.
     */
    public function updateReferenceFields()
    {
        if (isset($this->data['referencesOne']['replyTo']) && !isset($this->data['fields']['replyToId'])) {
            $this->setReplyToId($this->data['referencesOne']['replyTo']->getId());
        }
    }

    /**
     * Save the references.
     */
    public function saveReferences()
    {
        if (isset($this->data['referencesOne']['replyTo'])) {
            $this->data['referencesOne']['replyTo']->save();
        }
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
        if ('author' == $name) {
            return $this->setAuthor($value);
        }
        if ('text' == $name) {
            return $this->setText($value);
        }
        if ('replyToId' == $name) {
            return $this->setReplyToId($value);
        }
        if ('replyTo' == $name) {
            return $this->setReplyTo($value);
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
        if ('author' == $name) {
            return $this->getAuthor();
        }
        if ('text' == $name) {
            return $this->getText();
        }
        if ('replyToId' == $name) {
            return $this->getReplyToId();
        }
        if ('replyTo' == $name) {
            return $this->getReplyTo();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\Message The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['author'])) {
            $this->setAuthor($array['author']);
        }
        if (isset($array['text'])) {
            $this->setText($array['text']);
        }
        if (isset($array['replyToId'])) {
            $this->setReplyToId($array['replyToId']);
        }
        if (isset($array['replyTo'])) {
            $this->setReplyTo($array['replyTo']);
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
        $array['author'] = $this->getAuthor();
        $array['text'] = $this->getText();
        if ($withReferenceFields) {
            $array['replyToId'] = $this->getReplyToId();
        }

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
                if (isset($this->data['fields']['author'])) {
                    $query['author'] = (string) $this->data['fields']['author'];
                }
                if (isset($this->data['fields']['text'])) {
                    $query['text'] = (string) $this->data['fields']['text'];
                }
                if (isset($this->data['fields']['replyToId'])) {
                    $query['replyTo'] = $this->data['fields']['replyToId'];
                }
            } else {
                if (isset($this->data['fields']['author']) || array_key_exists('author', $this->data['fields'])) {
                    $value = $this->data['fields']['author'];
                    $originalValue = $this->getOriginalFieldValue('author');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['author'] = (string) $this->data['fields']['author'];
                        } else {
                            $query['$unset']['author'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['text']) || array_key_exists('text', $this->data['fields'])) {
                    $value = $this->data['fields']['text'];
                    $originalValue = $this->getOriginalFieldValue('text');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['text'] = (string) $this->data['fields']['text'];
                        } else {
                            $query['$unset']['text'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['replyToId']) || array_key_exists('replyToId', $this->data['fields'])) {
                    $value = $this->data['fields']['replyToId'];
                    $originalValue = $this->getOriginalFieldValue('replyToId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['replyTo'] = $this->data['fields']['replyToId'];
                        } else {
                            $query['$unset']['replyTo'] = 1;
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