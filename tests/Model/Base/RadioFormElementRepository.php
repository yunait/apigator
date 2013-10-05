<?php

namespace Model\Base;

/**
 * Base class of repository of Model\RadioFormElement document.
 */
abstract class RadioFormElementRepository extends \Mongator\Repository
{

    /**
     * {@inheritdoc}
     */
    public function __construct(\Mongator\Mongator $mongator)
    {
        $this->documentClass = 'Model\RadioFormElement';
        $this->isFile = false;
        $this->collectionName = 'model_element';

        parent::__construct($mongator);
    }

    /**
     * {@inheritdoc}
     */
    public function idToMongo($id)
    {
        if (!$id instanceof \MongoId) {
            $id = new \MongoId($id);
        }

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function count(array $query = array())
    {
        $query = array_merge($query, array('type' => 'radio'));

        return parent::count($query);
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $query, array $newObject, array $options = array())
    {
        $query = array_merge($query, array('type' => 'radio'));
        
        return parent::update($query, $newObject, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(array $query = array(), array $options = array())
    {
        $query = array_merge($query, array('type' => 'radio'));
        
        return parent::remove($query, $options);
    }

    /**
     * Save documents.
     *
     * @param mixed $documents          A document or an array of documents.
     * @param array $batchInsertOptions The options for the batch insert operation (optional).
     * @param array $updateOptions      The options for the update operation (optional).
     */
    public function save($documents, array $batchInsertOptions = array(), array $updateOptions = array())
    {
        $repository = $this;

        if (!is_array($documents)) {
            $documents = array($documents);
        }

        $identityMap =& $this->getIdentityMap()->allByReference();
        $collection = $this->getCollection();

        $inserts = array();
        $updates = array();
        foreach ($documents as $document) {
            $document->saveReferences();
            $document->updateReferenceFields();
            if ($document->isNew()) {
                $inserts[spl_object_hash($document)] = $document;
            } else {
                $updates[] = $document;
            }
        }

        // insert
        if ($inserts) {
            foreach ($inserts as $oid => $document) {
                if (!$document->isModified()) {
                    continue;
                }
                $document->preInsertEvent();
                $document->oncePreInsertEvent();

                $data = $document->queryForSave();
                $data['_id'] = new \MongoId();

                $collection->insert($data);

                $document->setId($data['_id']);
                $document->setIsNew(false);
                $document->clearModified();
                $identityMap[(string) $data['_id']] = $document;

                $document->resetGroups();
                $document->postInsertEvent();
                $document->oncePostInsertEvent();

            }
        }

        // updates
        foreach ($updates as $document) {
            if ($document->isModified()) {
                $document->preUpdateEvent();
                $document->oncePreUpdateEvent();

                $query = $document->queryForSave();
                $collection->update(array('_id' => $this->idToMongo($document->getId())), $query, $updateOptions);
                $document->clearModified();
                $document->resetGroups();
                $document->postUpdateEvent();
                $document->oncePostUpdateEvent();
            }
        }
    }

    /**
     * Delete documents.
     *
     * @param mixed $documents A document or an array of documents.
     */
    public function delete($documents)
    {
        if (!is_array($documents)) {
            $documents = array($documents);
        }

        $ids = array();
        foreach ($documents as $document) {
            $document->preDeleteEvent();
            $ids[] = $id = $this->idToMongo($document->getId());
        }

        foreach ($documents as $document) {
            $document->processOnDelete();
        }

        $this->getCollection()->remove(array('_id' => array('$in' => $ids)));

        foreach ($documents as $document) {
            $document->postDeleteEvent();
        }

        $identityMap =& $this->getIdentityMap()->allByReference();
        foreach ($documents as $document) {
            unset($identityMap[(string) $document->getId()]);
            $document->setIsNew(true);
            $document->setId(null);
        }
    }

    /**
     * Fixes the missing references.
     */
    public function fixMissingReferences($documentsPerBatch = 1000)
    {
        $skip = 0;
        do {
            $cursor = $this->getCollection()->find(array('author' => array('$exists' => 1)), array('author' => 1))->limit($documentsPerBatch)->skip($skip);
            $ids = array_unique(array_values(array_map(function ($result) { return $result['author']; }, iterator_to_array($cursor))));
            if (count($ids)) {
                $collection = $this->getMongator()->getRepository('Model\Author')->getCollection();
                $referenceCursor = $collection->find(array('_id' => array('$in' => $ids)), array('_id' => 1));
                $referenceIds =  array_values(array_map(function ($result) { return $result['_id']; }, iterator_to_array($referenceCursor)));

                if ($idsDiff = array_diff($ids, $referenceIds)) {
                    $this->remove(array('author' => array('$in' => $idsDiff)), array('multiple' => 1));
                }
            }

            $skip += $documentsPerBatch;
        } while(count($ids));
        $skip = 0;
        do {
            $cursor = $this->getCollection()->find(array('authorLocal' => array('$exists' => 1)), array('authorLocal' => 1))->limit($documentsPerBatch)->skip($skip);
            $ids = array_unique(array_values(array_map(function ($result) { return $result['authorLocal']; }, iterator_to_array($cursor))));
            if (count($ids)) {
                $collection = $this->getMongator()->getRepository('Model\Author')->getCollection();
                $referenceCursor = $collection->find(array('_id' => array('$in' => $ids)), array('_id' => 1));
                $referenceIds =  array_values(array_map(function ($result) { return $result['_id']; }, iterator_to_array($referenceCursor)));

                if ($idsDiff = array_diff($ids, $referenceIds)) {
                    $this->remove(array('authorLocal' => array('$in' => $idsDiff)), array('multiple' => 1));
                }
            }

            $skip += $documentsPerBatch;
        } while(count($ids));

        $skip = 0;
        do {
            $cursor = $this->getCollection()->find(array('categories' => array('$exists' => 1)), array('categories' => 1))->limit($documentsPerBatch)->skip($skip);
            $ids = array_unique(array_reduce(
                array_values(array_map(function ($result) { return $result['categories']; }, iterator_to_array($cursor)))
            , 'array_merge', array()));
            if (count($ids)) {
                $collection = $this->getMongator()->getRepository('Model\Category')->getCollection();
                $referenceCursor = $collection->find(array('_id' => array('$in' => $ids)), array('_id' => 1));
                $referenceIds =  array_values(array_map(function ($result) { return $result['_id']; }, iterator_to_array($referenceCursor)));

                if ($idsDiff = array_diff($ids, $referenceIds)) {
                    $this->update(array(), array('$pull' => array('categories' => array('$in' => $idsDiff))), array('multiple' => 1));
                }
            }

            $skip += $documentsPerBatch;
        } while(count($ids));
        $skip = 0;
        do {
            $cursor = $this->getCollection()->find(array('categoriesLocal' => array('$exists' => 1)), array('categoriesLocal' => 1))->limit($documentsPerBatch)->skip($skip);
            $ids = array_unique(array_reduce(
                array_values(array_map(function ($result) { return $result['categoriesLocal']; }, iterator_to_array($cursor)))
            , 'array_merge', array()));
            if (count($ids)) {
                $collection = $this->getMongator()->getRepository('Model\Category')->getCollection();
                $referenceCursor = $collection->find(array('_id' => array('$in' => $ids)), array('_id' => 1));
                $referenceIds =  array_values(array_map(function ($result) { return $result['_id']; }, iterator_to_array($referenceCursor)));

                if ($idsDiff = array_diff($ids, $referenceIds)) {
                    $this->update(array(), array('$pull' => array('categoriesLocal' => array('$in' => $idsDiff))), array('multiple' => 1));
                }
            }

            $skip += $documentsPerBatch;
        } while(count($ids));
    }

    /**
     * Returns the parent repository.
     *
     * @return \Model\FormElement The parent repository.
     */
    public function getParentRepository()
    {
        return $this->getMongator()->getRepository('Model\FormElement');
    }

    /**
     * Returns the last parent repository.
     *
     * @return \Mongator\Repository The last parent repository.
     */
    public function getLastParentRepository()
    {
        $parentClass = 'Model\FormElement';
        do {
            $metadata = $this->getMongator()->getMetadata($parentClass);
            if (false !== $metadata['inheritance']) {
                $parentClass = $metadata['inheritance']['class'];
            }
        } while (false !== $metadata['inheritance']);

        return $this->getMongator()->getRepository($parentClass);
    }
}