<?php

namespace Model\Base;

/**
 * Base class of query of Model\RadioFormElement document.
 */
abstract class RadioFormElementQuery extends \Mongator\Query\Query
{

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $repository = $this->getRepository();
        $mongator = $repository->getMongator();
        $documentClass = $repository->getDocumentClass();
        $identityMap =& $repository->getIdentityMap()->allByReference();
        $isFile = $repository->isFile();

        $documents = array();
        foreach ($this->execute() as $data) {
            
            $id = (string) $data['_id'];
            if (isset($identityMap[$id])) {
                $document = $identityMap[$id];
                $document->addQueryHash($this->getHash());
            } else {
                if ($isFile) {
                    $file = $data;
                    $data = $file->file;
                    $data['file'] = $file;
                }
                $data['_query_hash'] = $this->getHash();
                $data['_query_fields'] = $this->getFields();

                $document = new $documentClass($mongator);
                $document->setDocumentData($data);

                $identityMap[$id] = $document;
            }
            $documents[$id] = $document;
        }

        if ($references = $this->getReferences()) {
            $mongator = $this->getRepository()->getMongator();
            $metadata = $mongator->getMetadataFactory()->getClass($this->getRepository()->getDocumentClass());
            foreach ($references as $referenceName) {
                // one
                if (isset($metadata['referencesOne'][$referenceName])) {
                    $reference = $metadata['referencesOne'][$referenceName];
                    $field = $reference['field'];

                    $ids = array();
                    foreach ($documents as $document) {
                        if ($id = $document->get($field)) {
                            $ids[] = $id;
                        }
                    }
                    if ($ids) {
                        $mongator->getRepository($reference['class'])->findById(array_unique($ids));
                    }

                    continue;
                }

                // many
                if (isset($metadata['referencesMany'][$referenceName])) {
                    $reference = $metadata['referencesMany'][$referenceName];
                    $field = $reference['field'];

                    $ids = array();
                    foreach ($documents as $document) {
                        if ($id = $document->get($field)) {
                            foreach ($id as $i) {
                                $ids[] = $i;
                            }
                        }
                    }
                    if ($ids) {
                        $mongator->getRepository($reference['class'])->findById(array_unique($ids));
                    }

                    continue;
                }

                // invalid
                throw new \RuntimeException(sprintf('The reference "%s" does not exist in the class "%s".', $referenceName, $documentClass));
            }
        }

        return $documents;
    }

    /**
     * {@inheritdoc}
     */
    public function createCursor()
    {
        $criteria = $savedCriteria = $this->getCriteria();
        $criteria = array_merge($criteria, array('type' => 'radio'));
        $this->criteria($criteria);

        $cursor = parent::createCursor();

        $this->criteria($savedCriteria);

        return $cursor;
    }

    /**
     * Find by "label" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\RadioFormElementQuery The query with added criteria (fluent interface).
     */
    public function findByLabel($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('label' => $castValue ));
    }

    /**
     * Find by "author_reference_field" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\RadioFormElementQuery The query with added criteria (fluent interface).
     */
    private function findByAuthor_reference_field($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('author' => $id));
    }

    private function findByAuthor_reference_fieldIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('author' => array('$in' => $ids)));
    }

    /**
     * Find by "authorLocal_reference_field" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\RadioFormElementQuery The query with added criteria (fluent interface).
     */
    private function findByAuthorLocal_reference_field($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('authorLocal' => $id));
    }

    private function findByAuthorLocal_reference_fieldIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('authorLocal' => array('$in' => $ids)));
    }

    /**
     * Find by "categories_reference_field" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\RadioFormElementQuery The query with added criteria (fluent interface).
     */
    private function findByCategories_reference_field($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('categories' => $id));
    }

    private function findByCategories_reference_fieldIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('categories' => array('$in' => $ids)));
    }

    /**
     * Find by "categoriesLocal_reference_field" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\RadioFormElementQuery The query with added criteria (fluent interface).
     */
    private function findByCategoriesLocal_reference_field($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('categoriesLocal' => $id));
    }

    private function findByCategoriesLocal_reference_fieldIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('categoriesLocal' => array('$in' => $ids)));
    }

    public function findByAuthor($value)
    {
        return $this->findByAuthor_reference_field($value);
    }

    public function findByAuthorIds(array $ids)
    {
        return $this->findByAuthor_reference_fieldIds($ids);
    }

    public function findByAuthorLocal($value)
    {
        return $this->findByAuthorLocal_reference_field($value);
    }

    public function findByAuthorLocalIds(array $ids)
    {
        return $this->findByAuthorLocal_reference_fieldIds($ids);
    }

    public function findByCategories($value)
    {
        return $this->findByCategories_reference_field($value);
    }

    public function findByCategoriesIds(array $ids)
    {
        return $this->findByCategories_reference_fieldIds($ids);
    }

    public function findByCategoriesLocal($value)
    {
        return $this->findByCategoriesLocal_reference_field($value);
    }

    public function findByCategoriesLocalIds(array $ids)
    {
        return $this->findByCategoriesLocal_reference_fieldIds($ids);
    }
}