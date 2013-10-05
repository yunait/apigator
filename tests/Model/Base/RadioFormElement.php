<?php

namespace Model\Base;

/**
 * Base class of Model\RadioFormElement document.
 */
abstract class RadioFormElement extends \Model\FormElement
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
     * @return \Model\RadioFormElement The document (fluent interface).
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
            $this->data['fields']['default'] = $data['default'];
        }
        if (isset($data['options'])) {
            $this->data['fields']['options'] = unserialize($data['options']);
        }
        if (isset($data['author'])) {
            $this->data['fields']['author_reference_field'] = $data['author'];
        }
        if (isset($data['authorLocal'])) {
            $this->data['fields']['authorLocal_reference_field'] = $data['authorLocal'];
        }
        if (isset($data['categories'])) {
            $this->data['fields']['categories_reference_field'] = $data['categories'];
        }
        if (isset($data['categoriesLocal'])) {
            $this->data['fields']['categoriesLocal_reference_field'] = $data['categoriesLocal'];
        }
        if (isset($data['sourceLocal'])) {
            $embedded = $this->getMongator()->create('Model\Source');
            $embedded->setRootAndPath($this, 'sourceLocal');
            $embedded->setDocumentData($data['sourceLocal']);
            $this->data['embeddedsOne']['sourceLocal'] = $embedded;
        }
        if (isset($data['commentsLocal'])) {
            $embedded = new \Mongator\Group\EmbeddedGroup('Model\Comment');
            $embedded->setRootAndPath($this, 'commentsLocal');
            $embedded->setSavedData($data['commentsLocal']);
            $this->data['embeddedsMany']['commentsLocal'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "label" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
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
     * @return \Model\RadioFormElement The document (fluent interface).
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
     * Set the "options" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function setOptions($value)
    {
        if (!isset($this->data['fields']['options'])) {
            if (!$this->isNew()) {
                $this->getOptions();
                if (
                    ( is_object($value) && $value == $this->data['fields']['options'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['options'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['options'] = null;
                $this->data['fields']['options'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['options'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['options'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['options']) && !array_key_exists('options', $this->fieldsModified)) {
            $this->fieldsModified['options'] = $this->data['fields']['options'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['options'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['options'] )
        ) {
            unset($this->fieldsModified['options']);
        }

        $this->data['fields']['options'] = $value;

        return $this;
    }

    /**
     * Returns the "options" field.
     *
     * @return mixed The $name field.
     */
    public function getOptions()
    {
        $this->addFieldCache('options');

        if (!isset($this->data['fields']['options']) &&
            !$this->isFieldInQuery('options'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['options'])) {
            $this->data['fields']['options'] = null;
        }

        return $this->data['fields']['options'];
    }

    /**
     * Set the "author_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
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
     * Set the "authorLocal_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function setAuthorLocal_reference_field($value)
    {
        if (!isset($this->data['fields']['authorLocal_reference_field'])) {
            if (!$this->isNew()) {
                $this->getAuthorLocal_reference_field();
                if (
                    ( is_object($value) && $value == $this->data['fields']['authorLocal_reference_field'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['authorLocal_reference_field'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['authorLocal_reference_field'] = null;
                $this->data['fields']['authorLocal_reference_field'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['authorLocal_reference_field'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['authorLocal_reference_field'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['authorLocal_reference_field']) && !array_key_exists('authorLocal_reference_field', $this->fieldsModified)) {
            $this->fieldsModified['authorLocal_reference_field'] = $this->data['fields']['authorLocal_reference_field'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['authorLocal_reference_field'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['authorLocal_reference_field'] )
        ) {
            unset($this->fieldsModified['authorLocal_reference_field']);
        }

        $this->data['fields']['authorLocal_reference_field'] = $value;

        return $this;
    }

    /**
     * Returns the "authorLocal_reference_field" field.
     *
     * @return mixed The $name field.
     */
    public function getAuthorLocal_reference_field()
    {
        $this->addFieldCache('authorLocal');

        if (!isset($this->data['fields']['authorLocal_reference_field']) &&
            !$this->isFieldInQuery('authorLocal_reference_field'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['authorLocal_reference_field'])) {
            $this->data['fields']['authorLocal_reference_field'] = null;
        }

        return $this->data['fields']['authorLocal_reference_field'];
    }

    /**
     * Set the "categories_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
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
     * Set the "categoriesLocal_reference_field" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function setCategoriesLocal_reference_field($value)
    {
        if (!isset($this->data['fields']['categoriesLocal_reference_field'])) {
            if (!$this->isNew()) {
                $this->getCategoriesLocal_reference_field();
                if (
                    ( is_object($value) && $value == $this->data['fields']['categoriesLocal_reference_field'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['categoriesLocal_reference_field'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['categoriesLocal_reference_field'] = null;
                $this->data['fields']['categoriesLocal_reference_field'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['categoriesLocal_reference_field'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['categoriesLocal_reference_field'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['categoriesLocal_reference_field']) && !array_key_exists('categoriesLocal_reference_field', $this->fieldsModified)) {
            $this->fieldsModified['categoriesLocal_reference_field'] = $this->data['fields']['categoriesLocal_reference_field'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['categoriesLocal_reference_field'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['categoriesLocal_reference_field'] )
        ) {
            unset($this->fieldsModified['categoriesLocal_reference_field']);
        }

        $this->data['fields']['categoriesLocal_reference_field'] = $value;

        return $this;
    }

    /**
     * Returns the "categoriesLocal_reference_field" field.
     *
     * @return mixed The $name field.
     */
    public function getCategoriesLocal_reference_field()
    {
        $this->addFieldCache('categoriesLocal');

        if (!isset($this->data['fields']['categoriesLocal_reference_field']) &&
            !$this->isFieldInQuery('categoriesLocal_reference_field'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['categoriesLocal_reference_field'])) {
            $this->data['fields']['categoriesLocal_reference_field'] = null;
        }

        return $this->data['fields']['categoriesLocal_reference_field'];
    }

    /**
     * Set the "author" reference.
     *
     * @param \Model\Author|null $value The reference, or null.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
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
     * Set the "authorLocal" reference.
     *
     * @param \Model\Author|null $value The reference, or null.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the class is not an instance of Model\Author.
     */
    public function setAuthorLocal($value)
    {
        if (null !== $value && !$value instanceof \Model\Author) {
            throw new \InvalidArgumentException('The "authorLocal" reference is not an instance of Model\Author.');
        }

        $this->setAuthorLocal_reference_field((null === $value || $value->isNew()) ? null : $value->getId());

        $this->data['referencesOne']['authorLocal'] = $value;

        return $this;
    }

    /**
     * Returns the "authorLocal" reference.
     *
     * @return \Model\Author|null The reference or null if it does not exist.
     */
    public function getAuthorLocal()
    {
        if (!isset($this->data['referencesOne']['authorLocal'])) {
            if (!$this->isNew()) {
                $this->addReferenceCache('authorLocal');
            }
            if (!$id = $this->getAuthorLocal_reference_field()) {
                return null;
            }
            if (!$document = $this->getMongator()->getRepository('Model\Author')->findOneById($id)) {
                throw new \RuntimeException('The reference "authorLocal" does not exist.');
            }
            $this->data['referencesOne']['authorLocal'] = $document;
        }

        return $this->data['referencesOne']['authorLocal'];
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
     * @return \Model\RadioFormElement The document (fluent interface).
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
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function removeCategories($documents)
    {
        $this->getCategories()->remove($documents);

        return $this;
    }

    /**
     * Returns the "categoriesLocal" reference.
     *
     * @return \Mongator\Group\ReferenceGroup The reference.
     */
    public function getCategoriesLocal()
    {
        if (!isset($this->data['referencesMany']['categoriesLocal'])) {
            if (!$this->isNew()) {
                $this->addReferenceCache('categoriesLocal');
            }
            $this->data['referencesMany']['categoriesLocal'] = new \Mongator\Group\ReferenceGroup('Model\Category', $this, 'categoriesLocal_reference_field');
        }

        return $this->data['referencesMany']['categoriesLocal'];
    }

    /**
     * Adds documents to the "categoriesLocal" reference many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function addCategoriesLocal($documents)
    {
        $this->getCategoriesLocal()->add($documents);

        return $this;
    }

    /**
     * Removes documents to the "categoriesLocal" reference many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function removeCategoriesLocal($documents)
    {
        $this->getCategoriesLocal()->remove($documents);

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

        if (isset($this->data['referencesOne']['authorLocal']) && !isset($this->data['fields']['authorLocal_reference_field'])) {
            $this->setAuthorLocal_reference_field($this->data['referencesOne']['authorLocal']->getId());
        }
        if (isset($this->data['referencesMany']['categoriesLocal'])) {
            $group = $this->data['referencesMany']['categoriesLocal'];
            $add = $group->getAdd();
            $remove = $group->getRemove();
            if ($add || $remove) {
                $ids = array();
                foreach ($group->all() as $document) {
                    $ids[] = $document->getId();
                }
                $this->setCategoriesLocal_reference_field($ids ? array_values($ids) : null);
            }
        }
        if (isset($this->data['embeddedsOne']['sourceLocal'])) {
            $this->data['embeddedsOne']['sourceLocal']->updateReferenceFields();
        }
        if (isset($this->data['embeddedsMany']['commentsLocal'])) {
            $group = $this->data['embeddedsMany']['commentsLocal'];
            foreach ($group->getSaved() as $document) {
                $document->updateReferenceFields();
            }
        }
    }

    /**
     * Save the references.
     */
    public function saveReferences()
    {
        if (isset($this->data['referencesOne']['authorLocal'])) {
            $this->data['referencesOne']['authorLocal']->save();
        }
        if (isset($this->data['referencesMany']['categoriesLocal'])) {
            $group = $this->data['referencesMany']['categoriesLocal'];
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
        if (isset($this->data['embeddedsOne']['sourceLocal'])) {
            $this->data['embeddedsOne']['sourceLocal']->saveReferences();
        }
    }

    /**
     * Set the "sourceLocal" embedded one.
     *
     * @param \Model\Source|null $value The "sourceLocal" embedded one.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the value is not an instance of Model\Source or null.
     */
    public function setSourceLocal($value)
    {
        if (null !== $value && !$value instanceof \Model\Source) {
            throw new \InvalidArgumentException('The "sourceLocal" embedded one is not an instance of Model\Source.');
        }
        if (null !== $value) {
            if ($this instanceof \Mongator\Document\Document) {
                $value->setRootAndPath($this, 'sourceLocal');
            } elseif ($rap = $this->getRootAndPath()) {
                $value->setRootAndPath($rap['root'], $rap['path'].'.sourceLocal');
            }
        }

        if (!$this->getArchive()->has('embedded_one.sourceLocal')) {
            $originalValue = isset($this->data['embeddedsOne']['sourceLocal']) ? $this->data['embeddedsOne']['sourceLocal'] : null;
            $this->getArchive()->set('embedded_one.sourceLocal', $originalValue);
        } elseif ($this->getArchive()->get('embedded_one.sourceLocal') === $value) {
            $this->getArchive()->remove('embedded_one.sourceLocal');
        }

        $this->data['embeddedsOne']['sourceLocal'] = $value;

        return $this;
    }

    /**
     * Returns the "sourceLocal" embedded one.
     *
     * @return \Model\Source|null The "sourceLocal" embedded one.
     */
    public function getSourceLocal()
    {
        if (!isset($this->data['embeddedsOne']['sourceLocal'])) {
            if ($this->isNew()) {
                $this->data['embeddedsOne']['sourceLocal'] = null;
            } elseif (
                !isset($this->data['embeddedsOne']) ||
                !array_key_exists('sourceLocal', $this->data['embeddedsOne']))
            {
                if (!$this->isFieldInQuery('sourceLocal')) {
                    $this->loadFull();
                }

                if (!isset($this->data['embeddedsOne']['sourceLocal'])) {
                    $this->data['embeddedsOne']['sourceLocal'] = null;
                }
            }
        }

        return $this->data['embeddedsOne']['sourceLocal'];
    }

    /**
     * Returns the "commentsLocal" embedded many.
     *
     * @return \Mongator\Group\EmbeddedGroup The "commentsLocal" embedded many.
     */
    public function getCommentsLocal()
    {
        if (!isset($this->data['embeddedsMany']['commentsLocal'])) {
            $this->data['embeddedsMany']['commentsLocal'] = $embedded = new \Mongator\Group\EmbeddedGroup('Model\Comment');
            $embedded->setRootAndPath($this, 'commentsLocal');
        }

        return $this->data['embeddedsMany']['commentsLocal'];
    }

    /**
     * Adds documents to the "commentsLocal" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function addCommentsLocal($documents)
    {
        $this->getCommentsLocal()->add($documents);

        return $this;
    }

    /**
     * Removes documents to the "commentsLocal" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function removeCommentsLocal($documents)
    {
        $this->getCommentsLocal()->remove($documents);

        return $this;
    }

    /**
     * Resets the groups of the document.
     */
    public function resetGroups()
    {
        if (isset($this->data['referencesMany']['categories'])) {
            $this->data['referencesMany']['categories']->reset();
        }
        if (isset($this->data['referencesMany']['categoriesLocal'])) {
            $this->data['referencesMany']['categoriesLocal']->reset();
        }
        if (isset($this->data['embeddedsOne']['source'])) {
            $this->data['embeddedsOne']['source']->resetGroups();
        }
        if (isset($this->data['embeddedsOne']['sourceLocal'])) {
            $this->data['embeddedsOne']['sourceLocal']->resetGroups();
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
        if (isset($this->data['embeddedsMany']['commentsLocal'])) {
            $group = $this->data['embeddedsMany']['commentsLocal'];
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
        if ('options' == $name) {
            return $this->setOptions($value);
        }
        if ('author_reference_field' == $name) {
            return $this->setAuthor_reference_field($value);
        }
        if ('authorLocal_reference_field' == $name) {
            return $this->setAuthorLocal_reference_field($value);
        }
        if ('categories_reference_field' == $name) {
            return $this->setCategories_reference_field($value);
        }
        if ('categoriesLocal_reference_field' == $name) {
            return $this->setCategoriesLocal_reference_field($value);
        }
        if ('author' == $name) {
            return $this->setAuthor($value);
        }
        if ('authorLocal' == $name) {
            return $this->setAuthorLocal($value);
        }
        if ('source' == $name) {
            return $this->setSource($value);
        }
        if ('sourceLocal' == $name) {
            return $this->setSourceLocal($value);
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
        if ('options' == $name) {
            return $this->getOptions();
        }
        if ('author_reference_field' == $name) {
            return $this->getAuthor_reference_field();
        }
        if ('authorLocal_reference_field' == $name) {
            return $this->getAuthorLocal_reference_field();
        }
        if ('categories_reference_field' == $name) {
            return $this->getCategories_reference_field();
        }
        if ('categoriesLocal_reference_field' == $name) {
            return $this->getCategoriesLocal_reference_field();
        }
        if ('author' == $name) {
            return $this->getAuthor();
        }
        if ('authorLocal' == $name) {
            return $this->getAuthorLocal();
        }
        if ('categories' == $name) {
            return $this->getCategories();
        }
        if ('categoriesLocal' == $name) {
            return $this->getCategoriesLocal();
        }
        if ('source' == $name) {
            return $this->getSource();
        }
        if ('sourceLocal' == $name) {
            return $this->getSourceLocal();
        }
        if ('comments' == $name) {
            return $this->getComments();
        }
        if ('commentsLocal' == $name) {
            return $this->getCommentsLocal();
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
     * @return \Model\RadioFormElement The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        parent::fromArray($array);
        if (isset($array['options'])) {
            $this->setOptions($array['options']);
        }
        if (isset($array['authorLocal_reference_field'])) {
            $this->setAuthorLocal_reference_field($array['authorLocal_reference_field']);
        }
        if (isset($array['categoriesLocal_reference_field'])) {
            $this->setCategoriesLocal_reference_field($array['categoriesLocal_reference_field']);
        }
        if (isset($array['authorLocal'])) {
            $this->setAuthorLocal($array['authorLocal']);
        }
        if (isset($array['categoriesLocal'])) {
            $this->removeCategoriesLocal($this->getCategoriesLocal()->all());
            $this->addCategoriesLocal($array['categoriesLocal']);
        }
        if (isset($array['sourceLocal'])) {
            $embedded = new \Model\Source($this->getMongator());
            $embedded->fromArray($array['sourceLocal']);
            $this->setSourceLocal($embedded);
        }
        if (isset($array['commentsLocal'])) {
            $embeddeds = array();
            foreach ($array['commentsLocal'] as $documentData) {
                $embeddeds[] = $embedded = new \Model\Comment($this->getMongator());
                $embedded->setDocumentData($documentData);
            }
            $this->getCommentsLocal()->replace($embeddeds);
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
        $array['options'] = $this->getOptions();
        if ($withReferenceFields) {
            $array['authorLocal_reference_field'] = $this->getAuthorLocal_reference_field();
        }
        if ($withReferenceFields) {
            $array['categoriesLocal_reference_field'] = $this->getCategoriesLocal_reference_field();
        }

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
            $query['type'] = 'radio';
        }
        $reset = false;

        if (isset($this->data['fields'])) {
            if ($isNew || $reset) {
                if (isset($this->data['fields']['options'])) {
                    $query['options'] = serialize($this->data['fields']['options']);
                }
                if (isset($this->data['fields']['authorLocal_reference_field'])) {
                    $query['authorLocal'] = $this->data['fields']['authorLocal_reference_field'];
                }
                if (isset($this->data['fields']['categoriesLocal_reference_field'])) {
                    $query['categoriesLocal'] = $this->data['fields']['categoriesLocal_reference_field'];
                }
            } else {
                if (isset($this->data['fields']['options']) || array_key_exists('options', $this->data['fields'])) {
                    $value = $this->data['fields']['options'];
                    $originalValue = $this->getOriginalFieldValue('options');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['options'] = serialize($this->data['fields']['options']);
                        } else {
                            $query['$unset']['options'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['authorLocal_reference_field']) || array_key_exists('authorLocal_reference_field', $this->data['fields'])) {
                    $value = $this->data['fields']['authorLocal_reference_field'];
                    $originalValue = $this->getOriginalFieldValue('authorLocal_reference_field');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['authorLocal'] = $this->data['fields']['authorLocal_reference_field'];
                        } else {
                            $query['$unset']['authorLocal'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['categoriesLocal_reference_field']) || array_key_exists('categoriesLocal_reference_field', $this->data['fields'])) {
                    $value = $this->data['fields']['categoriesLocal_reference_field'];
                    $originalValue = $this->getOriginalFieldValue('categoriesLocal_reference_field');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['categoriesLocal'] = $this->data['fields']['categoriesLocal_reference_field'];
                        } else {
                            $query['$unset']['categoriesLocal'] = 1;
                        }
                    }
                }
            }
        }
        if (true === $reset) {
            $reset = 'deep';
        }
        if (isset($this->data['embeddedsOne'])) {
            $originalValue = $this->getOriginalEmbeddedOneValue('sourceLocal');
            if (isset($this->data['embeddedsOne']['sourceLocal'])) {
                $resetValue = $reset ? $reset : (!$isNew && $this->data['embeddedsOne']['sourceLocal'] !== $originalValue);
                $query = $this->data['embeddedsOne']['sourceLocal']->queryForSave($query, $isNew, $resetValue);
            } elseif (array_key_exists('sourceLocal', $this->data['embeddedsOne'])) {
                if ($originalValue) {
                    $rap = $originalValue->getRootAndPath();
                    $query['$unset'][$rap['path']] = 1;
                }
            }
        }
        if (isset($this->data['embeddedsMany'])) {
            if ($isNew) {
                if (isset($this->data['embeddedsMany']['commentsLocal'])) {
                    foreach ($this->data['embeddedsMany']['commentsLocal']->getAdd() as $document) {
                        $query = $document->queryForSave($query, $isNew);
                    }
                }
            } else {
                if (isset($this->data['embeddedsMany']['commentsLocal'])) {
                    $group = $this->data['embeddedsMany']['commentsLocal'];
                    $saved = $group->getSaved();
                    foreach ($saved as $document) {
                        $query = $document->queryForSave($query, $isNew);
                    }
                    $groupRap = $group->getRootAndPath();
                    foreach ($group->getAdd() as $document) {
                        $q = $document->queryForSave(array(), true);
                        $rap = $document->getRootAndPath();
                        foreach (explode('.', $rap['path']) as $name) {
                            if (0 === strpos($name, '_add')) {
                                $name = substr($name, 4);
                            }
                            $q = $q[$name];
                        }
                        $op = ($saved) ? '$pushAll' : '$set';
                        $query[$op][$groupRap['path']][] = $q;
                    }
                    foreach ($group->getRemove() as $document) {
                        $rap = $document->getRootAndPath();
                        $query['$unset'][$rap['path']] = 1;
                    }
                }
            }
        }


        return $query;
    }
}