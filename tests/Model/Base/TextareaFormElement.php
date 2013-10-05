<?php

namespace Model\Base;

/**
 * Base class of Model\TextareaFormElement document.
 */
abstract class TextareaFormElement extends \Model\FormElement
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
     * @return \Model\TextareaFormElement The document (fluent interface).
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
        if (isset($data['default'])) {
            $this->data['fields']['default'] = (string) $data['default'];
        }
        if (isset($data['author'])) {
            $this->data['fields']['author_reference_field'] = $data['author'];
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
     * @return \Model\TextareaFormElement The document (fluent interface).
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
     * Set the "default" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\TextareaFormElement The document (fluent interface).
     */
    public function setDefault($value)
    {
        if (!isset($this->data['fields']['default'])) {
            if (!$this->isNew()) {
                $this->getDefault();
                if (
                    ( is_object($value) && $value == $this->data['fields']['default'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['default'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['default'] = null;
                $this->data['fields']['default'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['default'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['default'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['default']) && !array_key_exists('default', $this->fieldsModified)) {
            $this->fieldsModified['default'] = $this->data['fields']['default'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['default'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['default'] )
        ) {
            unset($this->fieldsModified['default']);
        }

        $this->data['fields']['default'] = $value;

        return $this;
    }

    /**
     * Returns the "default" field.
     *
     * @return mixed The $name field.
     */
    public function getDefault()
    {
        $this->addFieldCache('default');

        if (!isset($this->data['fields']['default']) &&
            !$this->isFieldInQuery('default'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['default'])) {
            $this->data['fields']['default'] = null;
        }

        return $this->data['fields']['default'];
    }

    /**
     * Set the "author_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\TextareaFormElement The document (fluent interface).
     */
    public function setAuthor_reference_field($value)
    {
        if (!isset($this->data['fields']['author_reference_field'])) {
            if (!$this->isNew()) {
                $this->getAuthor_reference_field();
                if (
                    ( is_object($value) && $value == $this->data['fields']['author_reference_field'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['author_reference_field'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['author_reference_field'] = null;
                $this->data['fields']['author_reference_field'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['author_reference_field'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['author_reference_field'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['author_reference_field']) && !array_key_exists('author_reference_field', $this->fieldsModified)) {
            $this->fieldsModified['author_reference_field'] = $this->data['fields']['author_reference_field'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['author_reference_field'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['author_reference_field'] )
        ) {
            unset($this->fieldsModified['author_reference_field']);
        }

        $this->data['fields']['author_reference_field'] = $value;

        return $this;
    }

    /**
     * Returns the "author_reference_field" field.
     *
     * @return mixed The $name field.
     */
    public function getAuthor_reference_field()
    {
        $this->addFieldCache('author');

        if (!isset($this->data['fields']['author_reference_field']) &&
            !$this->isFieldInQuery('author_reference_field'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['author_reference_field'])) {
            $this->data['fields']['author_reference_field'] = null;
        }

        return $this->data['fields']['author_reference_field'];
    }

    /**
     * Set the "categories_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\TextareaFormElement The document (fluent interface).
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
     * Set the "author" reference.
     *
     * @param \Model\Author|null $value The reference, or null.
     *
     * @return \Model\TextareaFormElement The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the class is not an instance of Model\Author.
     */
    public function setAuthor($value)
    {
        if (null !== $value && !$value instanceof \Model\Author) {
            throw new \InvalidArgumentException('The "author" reference is not an instance of Model\Author.');
        }

        $this->setAuthor_reference_field((null === $value || $value->isNew()) ? null : $value->getId());

        $this->data['referencesOne']['author'] = $value;

        return $this;
    }

    /**
     * Returns the "author" reference.
     *
     * @return \Model\Author|null The reference or null if it does not exist.
     */
    public function getAuthor()
    {
        if (!isset($this->data['referencesOne']['author'])) {
            if (!$this->isNew()) {
                $this->addReferenceCache('author');
            }
            if (!$id = $this->getAuthor_reference_field()) {
                return null;
            }
            if (!$document = $this->getMongator()->getRepository('Model\Author')->findOneById($id)) {
                throw new \RuntimeException('The reference "author" does not exist.');
            }
            $this->data['referencesOne']['author'] = $document;
        }

        return $this->data['referencesOne']['author'];
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
     * @return \Model\TextareaFormElement The document (fluent interface).
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
     * @return \Model\TextareaFormElement The document (fluent interface).
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
        if (isset($this->data['embeddedsMany']['comments'])) {
            $group = $this->data['embeddedsMany']['comments'];
            foreach (array_merge($group->getAdd(), $group->getRemove()) as $document) {
                $document->resetGroups();
            }
            if ($group->isSavedInitialized()) {
                foreach ($group->getSaved() as $document) {
                    $document->resetGroups();
                }
            }
            $group->reset();
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
        if ('default' == $name) {
            return $this->setDefault($value);
        }
        if ('author_reference_field' == $name) {
            return $this->setAuthor_reference_field($value);
        }
        if ('categories_reference_field' == $name) {
            return $this->setCategories_reference_field($value);
        }
        if ('author' == $name) {
            return $this->setAuthor($value);
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
        if ('default' == $name) {
            return $this->getDefault();
        }
        if ('author_reference_field' == $name) {
            return $this->getAuthor_reference_field();
        }
        if ('categories_reference_field' == $name) {
            return $this->getCategories_reference_field();
        }
        if ('author' == $name) {
            return $this->getAuthor();
        }
        if ('categories' == $name) {
            return $this->getCategories();
        }
        if ('source' == $name) {
            return $this->getSource();
        }
        if ('comments' == $name) {
            return $this->getComments();
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
     * @return \Model\TextareaFormElement The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        parent::fromArray($array);
        if (isset($array['default'])) {
            $this->setDefault($array['default']);
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
        $array['default'] = $this->getDefault();

        return $array;
    }

    /**
     * INTERNAL. Invoke the "preInsert" event.
     */
    public function preInsertEvent()
    {
        parent::elementPreInsert();
        parent::formElementPreInsert();
        $this->textareaPreInsert();
    }

    /**
     * INTERNAL. Invoke the "postInsert" event.
     */
    public function postInsertEvent()
    {
        parent::elementPostInsert();
        parent::formElementPostInsert();
        $this->textareaPostInsert();
    }

    /**
     * INTERNAL. Invoke the "preUpdate" event.
     */
    public function preUpdateEvent()
    {
        parent::elementPreUpdate();
        parent::formElementPreUpdate();
        $this->textareaPreUpdate();
    }

    /**
     * INTERNAL. Invoke the "postUpdate" event.
     */
    public function postUpdateEvent()
    {
        parent::elementPostUpdate();
        parent::formElementPostUpdate();
        $this->textareaPostUpdate();
    }

    /**
     * INTERNAL. Invoke the "preDelete" event.
     */
    public function preDeleteEvent()
    {
        parent::elementPreDelete();
        parent::formElementPreDelete();
        $this->textareaPreDelete();
    }

    /**
     * INTERNAL. Invoke the "postDelete" event.
     */
    public function postDeleteEvent()
    {
        parent::elementPostDelete();
        parent::formElementPostDelete();
        $this->textareaPostDelete();
    }

    /**
     * Query for save.
     */
    public function queryForSave()
    {
        $isNew = $this->isNew();
        $query = parent::queryForSave();
        if ($isNew) {
            $query['type'] = 'textarea';
        }
        $reset = false;

        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                if (isset($this->data['fields']['default'])) {
                    $query['default'] = (string) $this->data['fields']['default'];
                }
            } else {
                if (isset($this->data['fields']['default']) || array_key_exists('default', $this->data['fields'])) {
                    $value = $this->data['fields']['default'];
                    $originalValue = $this->getOriginalFieldValue('default');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['default'] = (string) $this->data['fields']['default'];
                        } else {
                            $query['$unset']['default'] = 1;
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
        if (isset($this->data['embeddedsMany'])) {
            if ($isNew) {
            } else {
            }
        }


        return $query;
    }
}