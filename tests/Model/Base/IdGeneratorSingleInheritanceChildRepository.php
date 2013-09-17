<?php

namespace Model\Base;

/**
 * Base class of repository of Model\IdGeneratorSingleInheritanceChild document.
 */
abstract class IdGeneratorSingleInheritanceChildRepository extends \Mongator\Repository
{

    /**
     * {@inheritdoc}
     */
    public function __construct(\Mongator\Mongator $mongator)
    {
        $this->documentClass = 'Model\IdGeneratorSingleInheritanceChild';
        $this->isFile = false;
        $this->collectionName = 'model_idgeneratorsingleinheritancegrandparent';

        parent::__construct($mongator);
    }

    /**
     * {@inheritdoc}
     */
    public function idToMongo($id)
    {
        $id = (int) $id;

        return $id;
    }

    /**
     * {@inheritdoc}
     */
    public function count(array $query = array())
    {
        $query = array_merge($query, array('type' => 'child'));

        return parent::count($query);
    }

    /**
     * {@inheritdoc}
     */
    public function update(array $query, array $newObject, array $options = array())
    {
        $query = array_merge($query, array('type' => 'child'));
        
        return parent::update($query, $newObject, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(array $query = array(), array $options = array())
    {
        $query = array_merge($query, array('type' => 'child'));
        
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
            if ($document->isNew()) {
                $inserts[spl_object_hash($document)] = $document;
            } else {
                $updates[] = $document;
            }
        }

        // insert
        if ($inserts) {
            foreach ($inserts as $oid => $document) {
                $document->oncePreInsertEvent();

                $data = $document->queryForSave();
                $serverInfo = $repository->getConnection()->getMongo()->selectDB('admin')->command(array('buildinfo' => true));
                $mongoVersion = $serverInfo['version'];
                
                $commandResult = $repository->getConnection()->getMongoDB()->command(array(
                    'findandmodify' => 'Mongator_sequence_id_generator',
                    'query'         => array('_id' => $repository->getCollectionName()),
                    'update'        => array('$inc' => array('sequence' => 1)),
                    'new'           => true,
                ));
                if (
                    (version_compare($mongoVersion, '2.0', '<') && $commandResult['ok'])
                    ||
                    (version_compare($mongoVersion, '2.0', '>=') && null !== $commandResult['value'])
                ) {
                    $data['_id'] = $commandResult['value']['sequence'];
                } else {
                    $repository
                        ->getConnection()
                        ->getMongoDB()
                        ->selectCollection('Mongator_sequence_id_generator')
                        ->insert(array('_id' => $repository->getCollectionName(), 'sequence' => 1)
                    );
                    $data['_id'] = 1;
                }

                $collection->insert($data);

                $document->setId($data['_id']);
                $document->setIsNew(false);
                $document->clearModified();
                $identityMap[(string) $data['_id']] = $document;

                $document->oncePostInsertEvent();

            }
        }

        // updates
        foreach ($updates as $document) {
            if ($document->isModified()) {
                $document->oncePreUpdateEvent();

                $query = $document->queryForSave();
                $collection->update(array('_id' => $this->idToMongo($document->getId())), $query, $updateOptions);
                $document->clearModified();
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
            $ids[] = $id = $this->idToMongo($document->getId());
        }

        foreach ($documents as $document) {
            $document->processOnDelete();
        }

        $this->getCollection()->remove(array('_id' => array('$in' => $ids)));


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
    }

    /**
     * Returns the parent repository.
     *
     * @return \Model\IdGeneratorSingleInheritanceParent The parent repository.
     */
    public function getParentRepository()
    {
        return $this->getMongator()->getRepository('Model\IdGeneratorSingleInheritanceParent');
    }

    /**
     * Returns the last parent repository.
     *
     * @return \Mongator\Repository The last parent repository.
     */
    public function getLastParentRepository()
    {
        $parentClass = 'Model\IdGeneratorSingleInheritanceParent';
        do {
            $metadata = $this->getMongator()->getMetadata($parentClass);
            if (false !== $metadata['inheritance']) {
                $parentClass = $metadata['inheritance']['class'];
            }
        } while (false !== $metadata['inheritance']);

        return $this->getMongator()->getRepository($parentClass);
    }
}