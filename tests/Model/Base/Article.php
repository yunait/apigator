<?php

namespace Model\Base;

/**
 * Base class of Model\Article document.
 */
abstract class Article extends \Mongator\Document\Document
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
     * @return \Model\Article The document (fluent interface).
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
        if (isset($data['title'])) {
            $this->data['fields']['title'] = (string) $data['title'];
        }
        if (isset($data['content'])) {
            $this->data['fields']['content'] = (string) $data['content'];
        }
        if (isset($data['note'])) {
            $this->data['fields']['note'] = (string) $data['note'];
        }
        if (isset($data['line'])) {
            $this->data['fields']['line'] = (string) $data['line'];
        }
        if (isset($data['text'])) {
            $this->data['fields']['text'] = (string) $data['text'];
        }
        if (isset($data['isActive'])) {
            $this->data['fields']['isActive'] = (bool) $data['isActive'];
        }
        if (isset($data['date'])) {
            $this->data['fields']['date'] = new \DateTime(); $this->data['fields']['date']->setTimestamp($data['date']->sec);
        }
        if (isset($data['basatos'])) {
            $this->data['fields']['database'] = (string) $data['basatos'];
        }
        if (isset($data['author'])) {
            $this->data['fields']['authorId'] = $data['author'];
        }
        if (isset($data['information'])) {
            $this->data['fields']['informationId'] = $data['information'];
        }
        if (isset($data['categories'])) {
            $this->data['fields']['categoryIds'] = $data['categories'];
        }
        if (isset($data['source'])) {
            $embedded = $this->getMongator()->create('Model\Source');
            $embedded->setRootAndPath($this, 'source');
            $embedded->setDocumentData($data['source']);
            $this->data['embeddedsOne']['source'] = $embedded;
        }
        if (isset($data['simpleEmbedded'])) {
            $embedded = $this->getMongator()->create('Model\SimpleEmbedded');
            $embedded->setRootAndPath($this, 'simpleEmbedded');
            $embedded->setDocumentData($data['simpleEmbedded']);
            $this->data['embeddedsOne']['simpleEmbedded'] = $embedded;
        }
        if (isset($data['comments'])) {
            $embedded = new \Mongator\Group\EmbeddedGroup('Model\Comment');
            $embedded->setRootAndPath($this, 'comments');
            $embedded->setSavedData($data['comments']);
            $this->data['embeddedsMany']['comments'] = $embedded;
        }

        return $this;
    }

    /**
     * Set the "title" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
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
     * Set the "content" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setContent($value)
    {
        if (!isset($this->data['fields']['content'])) {
            if (!$this->isNew()) {
                $this->getContent();
                if (
                    ( is_object($value) && $value == $this->data['fields']['content'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['content'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['content'] = null;
                $this->data['fields']['content'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['content'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['content'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['content']) && !array_key_exists('content', $this->fieldsModified)) {
            $this->fieldsModified['content'] = $this->data['fields']['content'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['content'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['content'] )
        ) {
            unset($this->fieldsModified['content']);
        }

        $this->data['fields']['content'] = $value;

        return $this;
    }

    /**
     * Returns the "content" field.
     *
     * @return mixed The $name field.
     */
    public function getContent()
    {
        $this->addFieldCache('content');

        if (!isset($this->data['fields']['content']) &&
            !$this->isFieldInQuery('content'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['content'])) {
            $this->data['fields']['content'] = null;
        }

        return $this->data['fields']['content'];
    }

    /**
     * Set the "note" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setNote($value)
    {
        if (!isset($this->data['fields']['note'])) {
            if (!$this->isNew()) {
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
        $this->addFieldCache('note');

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
     * @return \Model\Article The document (fluent interface).
     */
    public function setLine($value)
    {
        if (!isset($this->data['fields']['line'])) {
            if (!$this->isNew()) {
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
        $this->addFieldCache('line');

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
     * Set the "text" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
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
     * Set the "isActive" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setIsActive($value)
    {
        if (!isset($this->data['fields']['isActive'])) {
            if (!$this->isNew()) {
                $this->getIsActive();
                if (
                    ( is_object($value) && $value == $this->data['fields']['isActive'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['isActive'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['isActive'] = null;
                $this->data['fields']['isActive'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['isActive'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['isActive'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['isActive']) && !array_key_exists('isActive', $this->fieldsModified)) {
            $this->fieldsModified['isActive'] = $this->data['fields']['isActive'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['isActive'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['isActive'] )
        ) {
            unset($this->fieldsModified['isActive']);
        }

        $this->data['fields']['isActive'] = $value;

        return $this;
    }

    /**
     * Returns the "isActive" field.
     *
     * @return mixed The $name field.
     */
    public function getIsActive()
    {
        $this->addFieldCache('isActive');

        if (!isset($this->data['fields']['isActive']) &&
            !$this->isFieldInQuery('isActive'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['isActive'])) {
            $this->data['fields']['isActive'] = null;
        }

        return $this->data['fields']['isActive'];
    }

    /**
     * Set the "date" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setDate($value)
    {
        if (!isset($this->data['fields']['date'])) {
            if (!$this->isNew()) {
                $this->getDate();
                if (
                    ( is_object($value) && $value == $this->data['fields']['date'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['date'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['date'] = null;
                $this->data['fields']['date'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['date'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['date'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['date']) && !array_key_exists('date', $this->fieldsModified)) {
            $this->fieldsModified['date'] = $this->data['fields']['date'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['date'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['date'] )
        ) {
            unset($this->fieldsModified['date']);
        }

        $this->data['fields']['date'] = $value;

        return $this;
    }

    /**
     * Returns the "date" field.
     *
     * @return mixed The $name field.
     */
    public function getDate()
    {
        $this->addFieldCache('date');

        if (!isset($this->data['fields']['date']) &&
            !$this->isFieldInQuery('date'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['date'])) {
            $this->data['fields']['date'] = null;
        }

        return $this->data['fields']['date'];
    }

    /**
     * Set the "database" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setDatabase($value)
    {
        if (!isset($this->data['fields']['database'])) {
            if (!$this->isNew()) {
                $this->getDatabase();
                if (
                    ( is_object($value) && $value == $this->data['fields']['database'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['database'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['database'] = null;
                $this->data['fields']['database'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['database'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['database'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['database']) && !array_key_exists('database', $this->fieldsModified)) {
            $this->fieldsModified['database'] = $this->data['fields']['database'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['database'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['database'] )
        ) {
            unset($this->fieldsModified['database']);
        }

        $this->data['fields']['database'] = $value;

        return $this;
    }

    /**
     * Returns the "database" field.
     *
     * @return mixed The $name field.
     */
    public function getDatabase()
    {
        $this->addFieldCache('basatos');

        if (!isset($this->data['fields']['database']) &&
            !$this->isFieldInQuery('database'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['database'])) {
            $this->data['fields']['database'] = null;
        }

        return $this->data['fields']['database'];
    }

    /**
     * Set the "authorId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setAuthorId($value)
    {
        if (!isset($this->data['fields']['authorId'])) {
            if (!$this->isNew()) {
                $this->getAuthorId();
                if (
                    ( is_object($value) && $value == $this->data['fields']['authorId'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['authorId'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['authorId'] = null;
                $this->data['fields']['authorId'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['authorId'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['authorId'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['authorId']) && !array_key_exists('authorId', $this->fieldsModified)) {
            $this->fieldsModified['authorId'] = $this->data['fields']['authorId'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['authorId'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['authorId'] )
        ) {
            unset($this->fieldsModified['authorId']);
        }

        $this->data['fields']['authorId'] = $value;

        return $this;
    }

    /**
     * Returns the "authorId" field.
     *
     * @return mixed The $name field.
     */
    public function getAuthorId()
    {
        $this->addFieldCache('author');

        if (!isset($this->data['fields']['authorId']) &&
            !$this->isFieldInQuery('authorId'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['authorId'])) {
            $this->data['fields']['authorId'] = null;
        }

        return $this->data['fields']['authorId'];
    }

    /**
     * Set the "informationId" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setInformationId($value)
    {
        if (!isset($this->data['fields']['informationId'])) {
            if (!$this->isNew()) {
                $this->getInformationId();
                if (
                    ( is_object($value) && $value == $this->data['fields']['informationId'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['informationId'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['informationId'] = null;
                $this->data['fields']['informationId'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['informationId'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['informationId'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['informationId']) && !array_key_exists('informationId', $this->fieldsModified)) {
            $this->fieldsModified['informationId'] = $this->data['fields']['informationId'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['informationId'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['informationId'] )
        ) {
            unset($this->fieldsModified['informationId']);
        }

        $this->data['fields']['informationId'] = $value;

        return $this;
    }

    /**
     * Returns the "informationId" field.
     *
     * @return mixed The $name field.
     */
    public function getInformationId()
    {
        $this->addFieldCache('information');

        if (!isset($this->data['fields']['informationId']) &&
            !$this->isFieldInQuery('informationId'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['informationId'])) {
            $this->data['fields']['informationId'] = null;
        }

        return $this->data['fields']['informationId'];
    }

    /**
     * Set the "categoryIds" field.
     *
     * @param mixed $value The value.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function setCategoryIds($value)
    {
        if (!isset($this->data['fields']['categoryIds'])) {
            if (!$this->isNew()) {
                $this->getCategoryIds();
                if (
                    ( is_object($value) && $value == $this->data['fields']['categoryIds'] ) ||
                    ( !is_object($value) && $value === $this->data['fields']['categoryIds'] )
                ) {
                    return $this;
                }
            } else {
                if (null === $value) {
                    return $this;
                }
                $this->fieldsModified['categoryIds'] = null;
                $this->data['fields']['categoryIds'] = $value;
                return $this;
            }
        } elseif (
            ( is_object($value) && $value == $this->data['fields']['categoryIds'] ) ||
            ( !is_object($value) && $value === $this->data['fields']['categoryIds'] )
        ) {
            return $this;
        }

        if (!isset($this->fieldsModified['categoryIds']) && !array_key_exists('categoryIds', $this->fieldsModified)) {
            $this->fieldsModified['categoryIds'] = $this->data['fields']['categoryIds'];
        } elseif (
            ( is_object($value) && $value == $this->fieldsModified['categoryIds'] ) ||
            ( !is_object($value) && $value === $this->fieldsModified['categoryIds'] )
        ) {
            unset($this->fieldsModified['categoryIds']);
        }

        $this->data['fields']['categoryIds'] = $value;

        return $this;
    }

    /**
     * Returns the "categoryIds" field.
     *
     * @return mixed The $name field.
     */
    public function getCategoryIds()
    {
        $this->addFieldCache('categories');

        if (!isset($this->data['fields']['categoryIds']) &&
            !$this->isFieldInQuery('categoryIds'))
        {
            $this->loadFull();
        }
        // Still not set? It can only be null
        if (!isset($this->data['fields']['categoryIds'])) {
            $this->data['fields']['categoryIds'] = null;
        }

        return $this->data['fields']['categoryIds'];
    }

    /**
     * Set the "author" reference.
     *
     * @param \Model\Author|null $value The reference, or null.
     *
     * @return \Model\Article The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the class is not an instance of Model\Author.
     */
    public function setAuthor($value)
    {
        if (null !== $value && !$value instanceof \Model\Author) {
            throw new \InvalidArgumentException('The "author" reference is not an instance of Model\Author.');
        }

        $this->setAuthorId((null === $value || $value->isNew()) ? null : $value->getId());

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
            if (!$id = $this->getAuthorId()) {
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
     * Set the "information" reference.
     *
     * @param \Model\ArticleInformation|null $value The reference, or null.
     *
     * @return \Model\Article The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the class is not an instance of Model\ArticleInformation.
     */
    public function setInformation($value)
    {
        if (null !== $value && !$value instanceof \Model\ArticleInformation) {
            throw new \InvalidArgumentException('The "information" reference is not an instance of Model\ArticleInformation.');
        }

        $this->setInformationId((null === $value || $value->isNew()) ? null : $value->getId());

        $this->data['referencesOne']['information'] = $value;

        return $this;
    }

    /**
     * Returns the "information" reference.
     *
     * @return \Model\ArticleInformation|null The reference or null if it does not exist.
     */
    public function getInformation()
    {
        if (!isset($this->data['referencesOne']['information'])) {
            if (!$this->isNew()) {
                $this->addReferenceCache('information');
            }
            if (!$id = $this->getInformationId()) {
                return null;
            }
            if (!$document = $this->getMongator()->getRepository('Model\ArticleInformation')->findOneById($id)) {
                throw new \RuntimeException('The reference "information" does not exist.');
            }
            $this->data['referencesOne']['information'] = $document;
        }

        return $this->data['referencesOne']['information'];
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
            $this->data['referencesMany']['categories'] = new \Mongator\Group\ReferenceGroup('Model\Category', $this, 'categoryIds');
        }

        return $this->data['referencesMany']['categories'];
    }

    /**
     * Adds documents to the "categories" reference many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\Article The document (fluent interface).
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
     * @return \Model\Article The document (fluent interface).
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
        if (isset($this->data['referencesOne']['author']) && !isset($this->data['fields']['authorId'])) {
            $this->setAuthorId($this->data['referencesOne']['author']->getId());
        }
        if (isset($this->data['referencesOne']['information']) && !isset($this->data['fields']['informationId'])) {
            $this->setInformationId($this->data['referencesOne']['information']->getId());
        }
        if (isset($this->data['referencesMany']['categories'])) {
            $group = $this->data['referencesMany']['categories'];
            $add = $group->getAdd();
            $remove = $group->getRemove();
            if ($add || $remove) {
                $ids = array();
                foreach ($group->all() as $document) {
                    $ids[] = $document->getId();
                }
                $this->setCategoryIds($ids ? array_values($ids) : null);
            }
        }
        if (isset($this->data['embeddedsOne']['source'])) {
            $this->data['embeddedsOne']['source']->updateReferenceFields();
        }
        if (isset($this->data['embeddedsMany']['comments'])) {
            $group = $this->data['embeddedsMany']['comments'];
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
        if (isset($this->data['referencesOne']['author'])) {
            $this->data['referencesOne']['author']->save();
        }
        if (isset($this->data['referencesOne']['information'])) {
            $this->data['referencesOne']['information']->save();
        }
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
     * @return \Model\Article The document (fluent interface).
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
     * Set the "simpleEmbedded" embedded one.
     *
     * @param \Model\SimpleEmbedded|null $value The "simpleEmbedded" embedded one.
     *
     * @return \Model\Article The document (fluent interface).
     *
     * @throws \InvalidArgumentException If the value is not an instance of Model\SimpleEmbedded or null.
     */
    public function setSimpleEmbedded($value)
    {
        if (null !== $value && !$value instanceof \Model\SimpleEmbedded) {
            throw new \InvalidArgumentException('The "simpleEmbedded" embedded one is not an instance of Model\SimpleEmbedded.');
        }
        if (null !== $value) {
            if ($this instanceof \Mongator\Document\Document) {
                $value->setRootAndPath($this, 'simpleEmbedded');
            } elseif ($rap = $this->getRootAndPath()) {
                $value->setRootAndPath($rap['root'], $rap['path'].'.simpleEmbedded');
            }
        }

        if (!$this->getArchive()->has('embedded_one.simpleEmbedded')) {
            $originalValue = isset($this->data['embeddedsOne']['simpleEmbedded']) ? $this->data['embeddedsOne']['simpleEmbedded'] : null;
            $this->getArchive()->set('embedded_one.simpleEmbedded', $originalValue);
        } elseif ($this->getArchive()->get('embedded_one.simpleEmbedded') === $value) {
            $this->getArchive()->remove('embedded_one.simpleEmbedded');
        }

        $this->data['embeddedsOne']['simpleEmbedded'] = $value;

        return $this;
    }

    /**
     * Returns the "simpleEmbedded" embedded one.
     *
     * @return \Model\SimpleEmbedded|null The "simpleEmbedded" embedded one.
     */
    public function getSimpleEmbedded()
    {
        if (!isset($this->data['embeddedsOne']['simpleEmbedded'])) {
            if ($this->isNew()) {
                $this->data['embeddedsOne']['simpleEmbedded'] = null;
            } elseif (
                !isset($this->data['embeddedsOne']) ||
                !array_key_exists('simpleEmbedded', $this->data['embeddedsOne']))
            {
                if (!$this->isFieldInQuery('simpleEmbedded')) {
                    $this->loadFull();
                }

                if (!isset($this->data['embeddedsOne']['simpleEmbedded'])) {
                    $this->data['embeddedsOne']['simpleEmbedded'] = null;
                }
            }
        }

        return $this->data['embeddedsOne']['simpleEmbedded'];
    }

    /**
     * Returns the "comments" embedded many.
     *
     * @return \Mongator\Group\EmbeddedGroup The "comments" embedded many.
     */
    public function getComments()
    {
        if (!isset($this->data['embeddedsMany']['comments'])) {
            $this->data['embeddedsMany']['comments'] = $embedded = new \Mongator\Group\EmbeddedGroup('Model\Comment');
            $embedded->setRootAndPath($this, 'comments');
        }

        return $this->data['embeddedsMany']['comments'];
    }

    /**
     * Adds documents to the "comments" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function addComments($documents)
    {
        $this->getComments()->add($documents);

        return $this;
    }

    /**
     * Removes documents to the "comments" embeddeds many.
     *
     * @param mixed $documents A document or an array or documents.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function removeComments($documents)
    {
        $this->getComments()->remove($documents);

        return $this;
    }

    /**
     * Returns the "votesUsers" relation many-through.
     *
     * @return \Mongator\Query\Query The "votesUsers" relation many-through.
     */
    public function getVotesUsers()
    {
        $ids = array();
        foreach ($this->getMongator()->getRepository('Model\ArticleVote')->getCollection()
            ->find(array('article' => $this->getId()), array('user' => 1))
        as $value) {
            $ids[] = $value['user'];
        }

        return $this->getMongator()->getRepository('Model\User')->createQuery(array('_id' => array('$in' => $ids)));
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
        if ('title' == $name) {
            return $this->setTitle($value);
        }
        if ('content' == $name) {
            return $this->setContent($value);
        }
        if ('note' == $name) {
            return $this->setNote($value);
        }
        if ('line' == $name) {
            return $this->setLine($value);
        }
        if ('text' == $name) {
            return $this->setText($value);
        }
        if ('isActive' == $name) {
            return $this->setIsActive($value);
        }
        if ('date' == $name) {
            return $this->setDate($value);
        }
        if ('database' == $name) {
            return $this->setDatabase($value);
        }
        if ('authorId' == $name) {
            return $this->setAuthorId($value);
        }
        if ('informationId' == $name) {
            return $this->setInformationId($value);
        }
        if ('categoryIds' == $name) {
            return $this->setCategoryIds($value);
        }
        if ('author' == $name) {
            return $this->setAuthor($value);
        }
        if ('information' == $name) {
            return $this->setInformation($value);
        }
        if ('source' == $name) {
            return $this->setSource($value);
        }
        if ('simpleEmbedded' == $name) {
            return $this->setSimpleEmbedded($value);
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
        if ('content' == $name) {
            return $this->getContent();
        }
        if ('note' == $name) {
            return $this->getNote();
        }
        if ('line' == $name) {
            return $this->getLine();
        }
        if ('text' == $name) {
            return $this->getText();
        }
        if ('isActive' == $name) {
            return $this->getIsActive();
        }
        if ('date' == $name) {
            return $this->getDate();
        }
        if ('database' == $name) {
            return $this->getDatabase();
        }
        if ('authorId' == $name) {
            return $this->getAuthorId();
        }
        if ('informationId' == $name) {
            return $this->getInformationId();
        }
        if ('categoryIds' == $name) {
            return $this->getCategoryIds();
        }
        if ('votesUsers' == $name) {
            return $this->getVotesUsers();
        }
        if ('author' == $name) {
            return $this->getAuthor();
        }
        if ('information' == $name) {
            return $this->getInformation();
        }
        if ('categories' == $name) {
            return $this->getCategories();
        }
        if ('source' == $name) {
            return $this->getSource();
        }
        if ('simpleEmbedded' == $name) {
            return $this->getSimpleEmbedded();
        }
        if ('comments' == $name) {
            return $this->getComments();
        }

        throw new \InvalidArgumentException(sprintf('The document data "%s" is not valid.', $name));
    }

    /**
     * Imports data from an array.
     *
     * @param array $array An array.
     *
     * @return \Model\Article The document (fluent interface).
     */
    public function fromArray(array $array)
    {
        if (isset($array['id'])) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['content'])) {
            $this->setContent($array['content']);
        }
        if (isset($array['note'])) {
            $this->setNote($array['note']);
        }
        if (isset($array['line'])) {
            $this->setLine($array['line']);
        }
        if (isset($array['text'])) {
            $this->setText($array['text']);
        }
        if (isset($array['isActive'])) {
            $this->setIsActive($array['isActive']);
        }
        if (isset($array['date'])) {
            $this->setDate($array['date']);
        }
        if (isset($array['database'])) {
            $this->setDatabase($array['database']);
        }
        if (isset($array['authorId'])) {
            $this->setAuthorId($array['authorId']);
        }
        if (isset($array['informationId'])) {
            $this->setInformationId($array['informationId']);
        }
        if (isset($array['categoryIds'])) {
            $this->setCategoryIds($array['categoryIds']);
        }
        if (isset($array['author'])) {
            $this->setAuthor($array['author']);
        }
        if (isset($array['information'])) {
            $this->setInformation($array['information']);
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
        if (isset($array['simpleEmbedded'])) {
            $embedded = new \Model\SimpleEmbedded($this->getMongator());
            $embedded->fromArray($array['simpleEmbedded']);
            $this->setSimpleEmbedded($embedded);
        }
        if (isset($array['comments'])) {
            $embeddeds = array();
            foreach ($array['comments'] as $documentData) {
                $embeddeds[] = $embedded = new \Model\Comment($this->getMongator());
                $embedded->setDocumentData($documentData);
            }
            $this->getComments()->replace($embeddeds);
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
        $array['content'] = $this->getContent();
        $array['note'] = $this->getNote();
        $array['line'] = $this->getLine();
        $array['text'] = $this->getText();
        $array['isActive'] = $this->getIsActive();
        $array['date'] = $this->getDate();
        $array['database'] = $this->getDatabase();
        if ($withReferenceFields) {
            $array['authorId'] = $this->getAuthorId();
        }
        if ($withReferenceFields) {
            $array['informationId'] = $this->getInformationId();
        }
        if ($withReferenceFields) {
            $array['categoryIds'] = $this->getCategoryIds();
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
                if (isset($this->data['fields']['title'])) {
                    $query['title'] = (string) $this->data['fields']['title'];
                }
                if (isset($this->data['fields']['content'])) {
                    $query['content'] = (string) $this->data['fields']['content'];
                }
                if (isset($this->data['fields']['note'])) {
                    $query['note'] = (string) $this->data['fields']['note'];
                }
                if (isset($this->data['fields']['line'])) {
                    $query['line'] = (string) $this->data['fields']['line'];
                }
                if (isset($this->data['fields']['text'])) {
                    $query['text'] = (string) $this->data['fields']['text'];
                }
                if (isset($this->data['fields']['isActive'])) {
                    $query['isActive'] = (bool) $this->data['fields']['isActive'];
                }
                if (isset($this->data['fields']['date'])) {
                    $query['date'] = $this->data['fields']['date']; if ($query['date'] instanceof \DateTime) { $query['date'] = $this->data['fields']['date']->getTimestamp(); } elseif (is_string($query['date'])) { $query['date'] = strtotime($this->data['fields']['date']); } $query['date'] = new \MongoDate($query['date']);
                }
                if (isset($this->data['fields']['database'])) {
                    $query['basatos'] = (string) $this->data['fields']['database'];
                }
                if (isset($this->data['fields']['authorId'])) {
                    $query['author'] = $this->data['fields']['authorId'];
                }
                if (isset($this->data['fields']['informationId'])) {
                    $query['information'] = $this->data['fields']['informationId'];
                }
                if (isset($this->data['fields']['categoryIds'])) {
                    $query['categories'] = $this->data['fields']['categoryIds'];
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
                if (isset($this->data['fields']['content']) || array_key_exists('content', $this->data['fields'])) {
                    $value = $this->data['fields']['content'];
                    $originalValue = $this->getOriginalFieldValue('content');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['content'] = (string) $this->data['fields']['content'];
                        } else {
                            $query['$unset']['content'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['note']) || array_key_exists('note', $this->data['fields'])) {
                    $value = $this->data['fields']['note'];
                    $originalValue = $this->getOriginalFieldValue('note');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['note'] = (string) $this->data['fields']['note'];
                        } else {
                            $query['$unset']['note'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['line']) || array_key_exists('line', $this->data['fields'])) {
                    $value = $this->data['fields']['line'];
                    $originalValue = $this->getOriginalFieldValue('line');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['line'] = (string) $this->data['fields']['line'];
                        } else {
                            $query['$unset']['line'] = 1;
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
                if (isset($this->data['fields']['isActive']) || array_key_exists('isActive', $this->data['fields'])) {
                    $value = $this->data['fields']['isActive'];
                    $originalValue = $this->getOriginalFieldValue('isActive');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['isActive'] = (bool) $this->data['fields']['isActive'];
                        } else {
                            $query['$unset']['isActive'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['date']) || array_key_exists('date', $this->data['fields'])) {
                    $value = $this->data['fields']['date'];
                    $originalValue = $this->getOriginalFieldValue('date');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['date'] = $this->data['fields']['date']; if ($query['$set']['date'] instanceof \DateTime) { $query['$set']['date'] = $this->data['fields']['date']->getTimestamp(); } elseif (is_string($query['$set']['date'])) { $query['$set']['date'] = strtotime($this->data['fields']['date']); } $query['$set']['date'] = new \MongoDate($query['$set']['date']);
                        } else {
                            $query['$unset']['date'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['database']) || array_key_exists('database', $this->data['fields'])) {
                    $value = $this->data['fields']['database'];
                    $originalValue = $this->getOriginalFieldValue('database');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['basatos'] = (string) $this->data['fields']['database'];
                        } else {
                            $query['$unset']['basatos'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['authorId']) || array_key_exists('authorId', $this->data['fields'])) {
                    $value = $this->data['fields']['authorId'];
                    $originalValue = $this->getOriginalFieldValue('authorId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['author'] = $this->data['fields']['authorId'];
                        } else {
                            $query['$unset']['author'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['informationId']) || array_key_exists('informationId', $this->data['fields'])) {
                    $value = $this->data['fields']['informationId'];
                    $originalValue = $this->getOriginalFieldValue('informationId');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['information'] = $this->data['fields']['informationId'];
                        } else {
                            $query['$unset']['information'] = 1;
                        }
                    }
                }
                if (isset($this->data['fields']['categoryIds']) || array_key_exists('categoryIds', $this->data['fields'])) {
                    $value = $this->data['fields']['categoryIds'];
                    $originalValue = $this->getOriginalFieldValue('categoryIds');
                    if ($value !== $originalValue) {
                        if (null !== $value) {
                            $query['$set']['categories'] = $this->data['fields']['categoryIds'];
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
            $originalValue = $this->getOriginalEmbeddedOneValue('simpleEmbedded');
            if (isset($this->data['embeddedsOne']['simpleEmbedded'])) {
                $resetValue = $reset ? $reset : (!$isNew && $this->data['embeddedsOne']['simpleEmbedded'] !== $originalValue);
                $query = $this->data['embeddedsOne']['simpleEmbedded']->queryForSave($query, $isNew, $resetValue);
            } elseif (array_key_exists('simpleEmbedded', $this->data['embeddedsOne'])) {
                if ($originalValue) {
                    $rap = $originalValue->getRootAndPath();
                    $query['$unset'][$rap['path']] = 1;
                }
            }
        }
        if (isset($this->data['embeddedsMany'])) {
            if ($isNew) {
                if (isset($this->data['embeddedsMany']['comments'])) {
                    foreach ($this->data['embeddedsMany']['comments']->getAdd() as $document) {
                        $query = $document->queryForSave($query, $isNew);
                    }
                }
            } else {
                if (isset($this->data['embeddedsMany']['comments'])) {
                    $group = $this->data['embeddedsMany']['comments'];
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