<?php

namespace Model\Base;

/**
 * Base class of repository of Model\IdGeneratorSingleInheritanceGrandParent document.
 */
abstract class IdGeneratorSingleInheritanceGrandParentRepository extends \Mongator\Repository
{

    private $inheritableValues;

    /**
     * {@inheritdoc}
     */
    public function __construct(\Mongator\Mongator $mongator)
    {
        $this->documentClass = 'Model\IdGeneratorSingleInheritanceGrandParent';
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
     * Returns the inheritable classes.
     *
     * @return array The inheritable classes.
     */
    public function getInheritableClasses()
    {
        $this->initInheritableValues();

        return $this->inheritableValues;
    }

    /**
     * Returns a inheritable class by type.
     *
     * @param string $type The type.
     *
     * return array the inheritable class.
     *
     * @throws \InvalidArgumentException If the type does not exist.
     */
    public function getInheritableClass($type)
    {
        $this->initInheritableValues();

        if (!$this->hasInheritableType($type)) {
            throw new \InvalidArgumentException(sprintf('The inheritable type "%s" does not exist.', $type));
        }

        return $this->inheritableValues[$type];
    }

    /**
     * Returns the inheritable type for a class.
     *
     * @param string $class The class.
     *
     * @return string The inheritable type for the class.
     *
     * @throws \InvalidArgumentException If the class is not a type class.
     */
    public function getInheritableTypeForClass($class)
    {
        $this->initInheritableValues();

        if (false === $type = array_search($class, $this->inheritableValues)) {
            throw new \InvalidArgumentException(sprintf('The class "%s" is not a type class.', $class));
        }

        return $type;
    }

    /**
     * Returns the inheritable types.
     *
     * @return array The inheritable types.
     */
    public function getInheritableTypes()
    {
        $this->initInheritableValues();

        return array_keys($this->inheritableValues);
    }

    /**
     * Returns whether there is or not an inheritable type.
     *
     * @return Boolean Whether there is or not an inheritable type.
     */
    public function hasInheritableType($type)
    {
        $this->initInheritableValues();

        return isset($this->inheritableValues[$type]);
    }

    private function initInheritableValues()
    {
        if (null === $this->inheritableValues) {
            $this->inheritableValues = array (
  'parent' => 'Model\\IdGeneratorSingleInheritanceParent',
  'child' => 'Model\\IdGeneratorSingleInheritanceChild',
);
        }
    }
}