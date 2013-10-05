<?php

namespace Model\Base;

/**
 * Base class of Model\EmbeddedEvents document.
 */
abstract class EmbeddedEvents extends \Mongator\Document\EmbeddedDocument
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
     * @return \Model\EmbeddedEvents The document (fluent interface).
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

        return $this;
    }

    /**
     * Set the "name" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\EmbeddedEvents The document (fluent interface).
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

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\EmbeddedEvents The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['name'])) {
            $this->setName($array['name']);
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

        return $array;
    }

    /**
     * INTERNAL. Invoke the "preInsert" event.
     */
    public function preInsertEvent()
    {
        $this->myPreInsert();
    }

    /**
     * INTERNAL. Invoke the "postInsert" event.
     */
    public function postInsertEvent()
    {
        $this->myPostInsert();
    }

    /**
     * INTERNAL. Invoke the "preUpdate" event.
     */
    public function preUpdateEvent()
    {
        $this->myPreUpdate();
    }

    /**
     * INTERNAL. Invoke the "postUpdate" event.
     */
    public function postUpdateEvent()
    {
        $this->myPostUpdate();
    }

    /**
     * INTERNAL. Invoke the "preDelete" event.
     */
    public function preDeleteEvent()
    {
        $this->myPreDelete();
    }

    /**
     * INTERNAL. Invoke the "postDelete" event.
     */
    public function postDeleteEvent()
    {
        $this->myPostDelete();
    }

    /**
     * Query for save.
     */
    public function queryForSave($query, $isNew, $reset = false)
    {
        $rap = $this->getRootAndPath();

        if ($isNew) {
            $this->preInsertEvent();
            $this->oncePreInsertEvent();
  
        } else {
            $this->preUpdateEvent();
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
                $embedded->postInsertEvent();
                $embedded->oncePostInsertEvent();
            });
        } else {
            $rap['root']->$registerPostEventMethod(function() use ($embedded) {
                $embedded->postUpdateEvent();
                $embedded->oncePostUpdateEvent();
            });
        }

        return $query;
    }
}