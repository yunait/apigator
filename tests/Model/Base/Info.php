<?php

namespace Model\Base;

/**
 * Base class of Model\Info document.
 */
abstract class Info extends \Mongator\Document\EmbeddedDocument
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
     * @return \Model\Info The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        if ($clean) {
            $this->data = array();
            $this->fieldsModified = array();
        }

        if (isset($data['name'])) {
            $this->data['fields']['name'] = (string) $data['name'];
        }
        if (isset($data['text'])) {
            $this->data['fields']['text'] = (string) $data['text'];
        }
        if (isset($data['note'])) {
            $this->data['fields']['note'] = (string) $data['note'];
        }
        if (isset($data['line'])) {
            $this->data['fields']['line'] = (string) $data['line'];
        }

        return $this;
    }

    /**
     * Set the "name" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Info The document (fluent interface).
     */
    public function setName($value)
    {
        if (!isset($this->data['fields']['name'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
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
        $rap = $this->getRootAndPath();
        $new = $this->isEmbeddedManyNew();
        if ( $rap && !$new ) {
            $field = $rap['path'].'.name';
            $rap['root']->addFieldCache($field);
        }

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
     * Set the "text" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Info The document (fluent interface).
     */
    public function setText($value)
    {
        if (!isset($this->data['fields']['text'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
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
        $rap = $this->getRootAndPath();
        $new = $this->isEmbeddedManyNew();
        if ( $rap && !$new ) {
            $field = $rap['path'].'.text';
            $rap['root']->addFieldCache($field);
        }

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
     * Set the "note" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Info The document (fluent interface).
     */
    public function setNote($value)
    {
        if (!isset($this->data['fields']['note'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getNote();
                if (
                    ( is_object($value) && $value == $this->data['fields']['note'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['note'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['note'] = null;
                $this->data['fields']['note'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['note'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['note'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['note']) && !array_key_exists('note', $this->fieldsModified)) {
            $this->fieldsModified['note'] = $this->data['fields']['note'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['note'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['note'] )
        ) {
            unset($this->fieldsModified['note']);
        }

        $this->data['fields']['note'] = $value;

        return $this;
    }

    /**
     * Returns the "note" field.
     *
     * @return mixed The $name field.
     */
    public function getNote()
    {
        $rap = $this->getRootAndPath();
        $new = $this->isEmbeddedManyNew();
        if ( $rap && !$new ) {
            $field = $rap['path'].'.note';
            $rap['root']->addFieldCache($field);
        }

        if (!isset($this->data['fields']['note']) &&
            !$this->isFieldInQuery('note'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['note'])) {
            $this->data['fields']['note'] = null;
        }

        return $this->data['fields']['note'];
    }

    /**
     * Set the "line" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Info The document (fluent interface).
     */
    public function setLine($value)
    {
        if (!isset($this->data['fields']['line'])) {
            if (($rap = $this->getRootAndPath()) && !$rap['root']->isNew()) {
                $this->getLine();
                if (
                    ( is_object($value) && $value == $this->data['fields']['line'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['line'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['line'] = null;
                $this->data['fields']['line'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['line'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['line'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['line']) && !array_key_exists('line', $this->fieldsModified)) {
            $this->fieldsModified['line'] = $this->data['fields']['line'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['line'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['line'] )
        ) {
            unset($this->fieldsModified['line']);
        }

        $this->data['fields']['line'] = $value;

        return $this;
    }

    /**
     * Returns the "line" field.
     *
     * @return mixed The $name field.
     */
    public function getLine()
    {
        $rap = $this->getRootAndPath();
        $new = $this->isEmbeddedManyNew();
        if ( $rap && !$new ) {
            $field = $rap['path'].'.line';
            $rap['root']->addFieldCache($field);
        }

        if (!isset($this->data['fields']['line']) &&
            !$this->isFieldInQuery('line'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['line'])) {
            $this->data['fields']['line'] = null;
        }

        return $this->data['fields']['line'];
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
        if ('name' == $name) {
            return $this->setName($value);
        }
        if ('text' == $name) {
            return $this->setText($value);
        }
        if ('note' == $name) {
            return $this->setNote($value);
        }
        if ('line' == $name) {
            return $this->setLine($value);
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
        if ('text' == $name) {
            return $this->getText();
        }
        if ('note' == $name) {
            return $this->getNote();
        }
        if ('line' == $name) {
            return $this->getLine();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\Info The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['text'])) {
            $this->setText($array['text']);
        }
        if (isset($array['note'])) {
            $this->setNote($array['note']);
        }
        if (isset($array['line'])) {
            $this->setLine($array['line']);
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
        $array = array();
        $array['name'] = $this->getName();
        $array['text'] = $this->getText();
        $array['note'] = $this->getNote();
        $array['line'] = $this->getLine();

        return $array;
    }

    /**
     * Query for save.
     */
    public function queryForSave($query, $isNew, $reset = false)
    {
        $rap = $this->getRootAndPath();

        if ($isNew) {
            $this->oncePreInsertEvent();
  
        } else {
            $this->oncePreUpdateEvent();
        }
        
        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                $rootQuery = $query;
                $query =& $rootQuery;
                
                if (true === $reset) {
                    $path = array('$set', $rap['path']);
                } elseif ('deep' == $reset) {
                    $path = explode('.', '$set.'.$rap['path']);
                } else {
                    $path = explode('.', $rap['path']);
                }
                foreach ($path as $name) {
                    if (0 === strpos($name, '_add')) {
                        $name = substr($name, 4);
                    }
                    if (!isset($query[$name])) {
                        $query[$name] = array();
                    }
                    $query =& $query[$name];
                }
                if (isset($this->data['fields']['name'])) {
                    $query['name'] = (string) $this->data['fields']['name'];
                }
                if (isset($this->data['fields']['text'])) {
                    $query['text'] = (string) $this->data['fields']['text'];
                }
                if (isset($this->data['fields']['note'])) {
                    $query['note'] = (string) $this->data['fields']['note'];
                }
                if (isset($this->data['fields']['line'])) {
                    $query['line'] = (string) $this->data['fields']['line'];
                }
                unset($query);
                $query = $rootQuery;
            } else {
                $documentPath = $rap['path'];
                if (isset($this->data['fields']['name']) || array_key_exists('name', $this->data['fields'])) {
                    $value = $this->data['fields']['name'];
                    $originalValue = $this->getOriginalFieldValue('name');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.name'] = (string) $this->data['fields']['name'];
                        } else {
                            $query['$unset'][$documentPath.'.name'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['text']) || array_key_exists('text', $this->data['fields'])) {
                    $value = $this->data['fields']['text'];
                    $originalValue = $this->getOriginalFieldValue('text');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.text'] = (string) $this->data['fields']['text'];
                        } else {
                            $query['$unset'][$documentPath.'.text'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['note']) || array_key_exists('note', $this->data['fields'])) {
                    $value = $this->data['fields']['note'];
                    $originalValue = $this->getOriginalFieldValue('note');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.note'] = (string) $this->data['fields']['note'];
                        } else {
                            $query['$unset'][$documentPath.'.note'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['line']) || array_key_exists('line', $this->data['fields'])) {
                    $value = $this->data['fields']['line'];
                    $originalValue = $this->getOriginalFieldValue('line');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set'][$documentPath.'.line'] = (string) $this->data['fields']['line'];
                        } else {
                            $query['$unset'][$documentPath.'.line'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }

        $embedded = $this;
        $registerPostEventMethod = 'registerOncePostUpdateEvent';
        if ($rap['root']->isNew()) {
            $registerPostEventMethod = 'registerOncePostInsertEvent';
        }

        if ($isNew) {
            $rap['root']->$registerPostEventMethod(function() use ($embedded) {
                $embedded->oncePostInsertEvent();
            });
        } else {
            $rap['root']->$registerPostEventMethod(function() use ($embedded) {
                $embedded->oncePostUpdateEvent();
            });
        }

        return $query;
    }
}