<?php

namespace Model\Base;

/**
 * Base class of Model\Element document.
 */
abstract class Element extends \Mongator\Document\Document
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
     * @return \Model\Element The document (fluent interface).
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
        if (isset($data['label'])) {
            $this->data['fields']['label'] = (string) $data['label'];
        }
        if (isset($data['categories'])) {
            $this->data['fields']['categories_reference_field'] = $data['categories'];
        }
        if (isset($data['source'])) {
            $embedded = $this->getMongator()->create('Model\Source');
            $embedded->setRootAndPath($this, 'source');
            $embedded->setDocumentData($data['source']);
            $this->data['embeddedsOne']['source'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "label" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Element The document (fluent interface).
     */
    public function setLabel($value)
    {
        if (!isset($this->data['fields']['label'])) {
            if (!$this->isNew()) {
                $this->getLabel();
                if (
                    ( is_object($value) && $value == $this->data['fields']['label'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['label'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['label'] = null;
                $this->data['fields']['label'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['label'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['label'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['label']) && !array_key_exists('label', $this->fieldsModified)) {
            $this->fieldsModified['label'] = $this->data['fields']['label'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['label'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['label'] )
        ) {
            unset($this->fieldsModified['label']);
        }

        $this->data['fields']['label'] = $value;

        return $this;
    }

    /**
     * Returns the "label" field.
     *
     * @return mixed The $name field.
     */
    public function getLabel()
    {
        $this->addFieldCache('label');

        if (!isset($this->data['fields']['label']) &&
            !$this->isFieldInQuery('label'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['label'])) {
            $this->data['fields']['label'] = null;
        }

        return $this->data['fields']['label'];
    }

    /**
     * Set the "categories_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Element The document (fluent interface).
     */
    public function setCategories_reference_field($value)
    {
        if (!isset($this->data['fields']['categories_reference_field'])) {
            if (!$this->isNew()) {
                $this->getCategories_reference_field();
                if (
                    ( is_object($value) && $value == $this->data['fields']['categories_reference_field'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['categories_reference_field'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['categories_reference_field'] = null;
                $this->data['fields']['categories_reference_field'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['categories_reference_field'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['categories_reference_field'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['categories_reference_field']) && !array_key_exists('categories_reference_field', $this->fieldsModified)) {
            $this->fieldsModified['categories_reference_field'] = $this->data['fields']['categories_reference_field'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['categories_reference_field'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['categories_reference_field'] )
        ) {
            unset($this->fieldsModified['categories_reference_field']);
        }

        $this->data['fields']['categories_reference_field'] = $value;

        return $this;
    }

    /**
     * Returns the "categories_reference_field" field.
     *
     * @return mixed The $name field.
     */
    public function getCategories_reference_field()
    {
        $this->addFieldCache('categories');

        if (!isset($this->data['fields']['categories_reference_field']) &&
            !$this->isFieldInQuery('categories_reference_field'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['categories_reference_field'])) {
            $this->data['fields']['categories_reference_field'] = null;
        }

        return $this->data['fields']['categories_reference_field'];
    }

    /**
     * Returns the "categories" reference.
     *
     * @return \Mongator\Group\ReferenceGroup The reference.
     */
    public function getCategories()
    {
        if (!isset($this->data['referencesMany']['categories'])) {
            if (!$this->isNew()) {
                $this->addReferenceCache('categories');
            }
            $this->data['referencesMany']['categories'] = new \Mongator\Group\ReferenceGroup('Model\Category', $this, 'categories_reference_field');
        }

        return $this->data['referencesMany']['categories'];
    }

    /**
     * Adds documents to the "categories" reference many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\Element The document (fluent interface).
     */
    public function addCategories($documents)
    {
        $this->getCategories()->add($documents);

        return $this;
    }

    /**
     * Removes documents to the "categories" reference many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\Element The document (fluent interface).
     */
    public function removeCategories($documents)
    {
        $this->getCategories()->remove($documents);

        return $this;
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
        if (isset($this->data['referencesMany']['categories'])) {
            $group = $this->data['referencesMany']['categories'];
            $add = $group->getAdd();
            $remove = $group->getRemove();
            if ($add || $remove) {
                $ids = array();
                foreach ($group->all() as $document) {
                    $ids[] = $document->getId();
                }
                $this->setCategories_reference_field($ids ? array_values($ids) : null);
            }
        }
        if (isset($this->data['embeddedsOne']['source'])) {
            $this->data['embeddedsOne']['source']->updateReferenceFields();
        }
    }

    /**
     * Save the references.
     */
    public function saveReferences()
    {
        if (isset($this->data['referencesMany']['categories'])) {
            $group = $this->data['referencesMany']['categories'];
            $documents = array();
            foreach ($group->getAdd() as $document) {
                $documents[] = $document;
            }
            if ($group->isSavedInitialized()) {
                foreach ($group->getSaved() as $document) {
                    $documents[] = $document;
                }
            }
            if ($documents) {
                $this->getMongator()->getRepository('Model\Category')->save($documents);
            }
        }
        if (isset($this->data['embeddedsOne']['source'])) {
            $this->data['embeddedsOne']['source']->saveReferences();
        }
    }

    /**
     * Set the "source" embedded one.
     *
     * @param \Model\Source|null $value The "source" embedded one.
     *
     * @return \Model\Element The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the value is not an instance of Model\Source or null.
     */
    public function setSource($value)
    {
        if (null !== $value && !$value instanceof \Model\Source) {
            throw new \InvalidArgumentException('The "source" embedded one is not an instance of Model\Source.');
        }
        if (null !== $value) {
            if ($this instanceof \Mongator\Document\Document) {
                $value->setRootAndPath($this, 'source');
            } elseif ($rap = $this->getRootAndPath()) {
                $value->setRootAndPath($rap['root'], $rap['path'].'.source');
            }
        }

        if (!$this->getArchive()->has('embedded_one.source')) {
            $originalValue = isset($this->data['embeddedsOne']['source']) ? $this->data['embeddedsOne']['source'] : null;
            $this->getArchive()->set('embedded_one.source', $originalValue);
        } elseif ($this->getArchive()->get('embedded_one.source') === $value) {
            $this->getArchive()->remove('embedded_one.source');
        }

        $this->data['embeddedsOne']['source'] = $value;

        return $this;
    }

    /**
     * Returns the "source" embedded one.
     *
     * @return \Model\Source|null The "source" embedded one.
     */
    public function getSource()
    {
        if (!isset($this->data['embeddedsOne']['source'])) {
            if ($this->isNew()) {
                $this->data['embeddedsOne']['source'] = null;
            } elseif (
                !isset($this->data['embeddedsOne']) ||
                !array_key_exists('source', $this->data['embeddedsOne']))
            {
                if (!$this->isFieldInQuery('source')) {
                    $this->loadFull();
                }

                if (!isset($this->data['embeddedsOne']['source'])) {
                    $this->data['embeddedsOne']['source'] = null;
                }
            }
        }

        return $this->data['embeddedsOne']['source'];
    }

    /**
     * Resets the groups of the document.
     */
    public function resetGroups()
    {
        if (isset($this->data['referencesMany']['categories'])) {
            $this->data['referencesMany']['categories']->reset();
        }
        if (isset($this->data['embeddedsOne']['source'])) {
            $this->data['embeddedsOne']['source']->resetGroups();
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
        if ('label' == $name) {
            return $this->setLabel($value);
        }
        if ('categories_reference_field' == $name) {
            return $this->setCategories_reference_field($value);
        }
        if ('source' == $name) {
            return $this->setSource($value);
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
        if ('label' == $name) {
            return $this->getLabel();
        }
        if ('categories_reference_field' == $name) {
            return $this->getCategories_reference_field();
        }
        if ('categories' == $name) {
            return $this->getCategories();
        }
        if ('source' == $name) {
            return $this->getSource();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\Element The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['label'])) {
            $this->setLabel($array['label']);
        }
        if (isset($array['categories_reference_field'])) {
            $this->setCategories_reference_field($array['categories_reference_field']);
        }
        if (isset($array['categories'])) {
            $this->removeCategories($this->getCategories()->all());
            $this->addCategories($array['categories']);
        }
        if (isset($array['source'])) {
            $embedded = new \Model\Source($this->getMongator());
            $embedded->fromArray($array['source']);
            $this->setSource($embedded);
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
        $array['label'] = $this->getLabel();
        if ($withReferenceFields) {
            $array['categories_reference_field'] = $this->getCategories_reference_field();
        }

        return $array;
    }

    /**
     * INTERNAL. Invoke the "preInsert" event.
     */
    public function preInsertEvent()
    {
        $this->elementPreInsert();
    }

    /**
     * INTERNAL. Invoke the "postInsert" event.
     */
    public function postInsertEvent()
    {
        $this->elementPostInsert();
    }

    /**
     * INTERNAL. Invoke the "preUpdate" event.
     */
    public function preUpdateEvent()
    {
        $this->elementPreUpdate();
    }

    /**
     * INTERNAL. Invoke the "postUpdate" event.
     */
    public function postUpdateEvent()
    {
        $this->elementPostUpdate();
    }

    /**
     * INTERNAL. Invoke the "preDelete" event.
     */
    public function preDeleteEvent()
    {
        $this->elementPreDelete();
    }

    /**
     * INTERNAL. Invoke the "postDelete" event.
     */
    public function postDeleteEvent()
    {
        $this->elementPostDelete();
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
                if (isset($this->data['fields']['label'])) {
                    $query['label'] = (string) $this->data['fields']['label'];
                }
                if (isset($this->data['fields']['categories_reference_field'])) {
                    $query['categories'] = $this->data['fields']['categories_reference_field'];
                }
            } else {
                if (isset($this->data['fields']['label']) || array_key_exists('label', $this->data['fields'])) {
                    $value = $this->data['fields']['label'];
                    $originalValue = $this->getOriginalFieldValue('label');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['label'] = (string) $this->data['fields']['label'];
                        } else {
                            $query['$unset']['label'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['categories_reference_field']) || array_key_exists('categories_reference_field', $this->data['fields'])) {
                    $value = $this->data['fields']['categories_reference_field'];
                    $originalValue = $this->getOriginalFieldValue('categories_reference_field');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['categories'] = $this->data['fields']['categories_reference_field'];
                        } else {
                            $query['$unset']['categories'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }
        if (isset($this->data['embeddedsOne'])) {
            $originalValue = $this->getOriginalEmbeddedOneValue('source');
            if (isset($this->data['embeddedsOne']['source'])) {
                $resetValue = $reset ? $reset : (!$isNew && $this->data['embeddedsOne']['source'] !== $originalValue);
                $query = $this->data['embeddedsOne']['source']->queryForSave($query, $isNew, $resetValue);
            } elseif (array_key_exists('source', $this->data['embeddedsOne'])) {
                if ($originalValue) {
                    $rap = $originalValue->getRootAndPath();
                    $query['$unset'][$rap['path']] = 1;
                }
            }
        }


        return $query;
    }
}