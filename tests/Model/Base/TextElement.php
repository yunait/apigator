<?php

namespace Model\Base;

/**
 * Base class of Model\TextElement document.
 */
abstract class TextElement extends \Model\Element
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
     * @return \Model\TextElement The document (fluent interface).
     */
    public function setDocumentData($data, $clean = false)
    {
        parent::setDocumentData($data);

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
        if (isset($data['htmltext'])) {
            $this->data['fields']['htmltext'] = (string) $data['htmltext'];
        }
        if (isset($data['categories'])) {
            $this->data['fields']['categories_reference_field'] = $data['categories'];
        }

        return $this;
    }

    /**
     * Set the "label" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\TextElement The document (fluent interface).
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
     * Set the "htmltext" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\TextElement The document (fluent interface).
     */
    public function setHtmltext($value)
    {
        if (!isset($this->data['fields']['htmltext'])) {
            if (!$this->isNew()) {
                $this->getHtmltext();
                if (
                    ( is_object($value) && $value == $this->data['fields']['htmltext'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['htmltext'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['htmltext'] = null;
                $this->data['fields']['htmltext'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['htmltext'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['htmltext'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['htmltext']) && !array_key_exists('htmltext', $this->fieldsModified)) {
            $this->fieldsModified['htmltext'] = $this->data['fields']['htmltext'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['htmltext'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['htmltext'] )
        ) {
            unset($this->fieldsModified['htmltext']);
        }

        $this->data['fields']['htmltext'] = $value;

        return $this;
    }

    /**
     * Returns the "htmltext" field.
     *
     * @return mixed The $name field.
     */
    public function getHtmltext()
    {
        $this->addFieldCache('htmltext');

        if (!isset($this->data['fields']['htmltext']) &&
            !$this->isFieldInQuery('htmltext'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['htmltext'])) {
            $this->data['fields']['htmltext'] = null;
        }

        return $this->data['fields']['htmltext'];
    }

    /**
     * Set the "categories_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\TextElement The document (fluent interface).
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
     * @return \Model\TextElement The document (fluent interface).
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
     * @return \Model\TextElement The document (fluent interface).
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
        parent::updateReferenceFields();
    }

    /**
     * Save the references.
     */
    public function saveReferences()
    {
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
        if ('htmltext' == $name) {
            return $this->setHtmltext($value);
        }
        if ('categories_reference_field' == $name) {
            return $this->setCategories_reference_field($value);
        }
        if ('source' == $name) {
            return $this->setSource($value);
        }
        try {
            return parent::set($name, $value);
        } catch (\InvalidArgumentException $e) {
        }
        try {
            return parent::get($name);
        } catch (\InvalidArgumentException $e) {
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
        if ('htmltext' == $name) {
            return $this->getHtmltext();
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
        try {
            return parent::get($name);
        } catch (\InvalidArgumentException $e) {
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\TextElement The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        parent::fromArray($array);
        if (isset($array['htmltext'])) {
            $this->setHtmltext($array['htmltext']);
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
        $array = parent::toArray($withReferenceFields);
        $array['htmltext'] = $this->getHtmltext();

        return $array;
    }

    /**
     * Query for save.
     */
    public function queryForSave()
    {
        $isNew = $this->isNew();
        $query = parent::queryForSave();
        if ($isNew) {
            $query['type'] = 'textelement';
        }
        $reset = false;

        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                if (isset($this->data['fields']['htmltext'])) {
                    $query['htmltext'] = (string) $this->data['fields']['htmltext'];
                }
            } else {
                if (isset($this->data['fields']['htmltext']) || array_key_exists('htmltext', $this->data['fields'])) {
                    $value = $this->data['fields']['htmltext'];
                    $originalValue = $this->getOriginalFieldValue('htmltext');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['htmltext'] = (string) $this->data['fields']['htmltext'];
                        } else {
                            $query['$unset']['htmltext'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }
        if (isset($this->data['embeddedsOne'])) {
        }


        return $query;
    }
}