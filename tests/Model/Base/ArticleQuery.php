<?php

namespace Model\Base;

/**
 * Base class of query of Model\Article document.
 */
abstract class ArticleQuery extends \Mongator\Query\Query
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
     * Find by "title" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByTitle($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('title' => $castValue ));
    }

    /**
     * Find by "content" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByContent($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('content' => $castValue ));
    }

    /**
     * Find by "note" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByNote($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('note' => $castValue ));
    }

    /**
     * Find by "line" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByLine($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('line' => $castValue ));
    }

    /**
     * Find by "text" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByText($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('text' => $castValue ));
    }

    /**
     * Find by "isActive" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByIsActive($value)
    {
        $castValue = (boolean) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type boolean expected');
        
        return $this->mergeCriteria(array('isActive' => $castValue ));
    }

    /**
     * Find by "date" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByDate($value)
    {
        $castValue = null;
        if (($value instanceOf \DateTime)) {
            $castValue = new \MongoDate($value->getTimestamp());
        } else if ($value instanceof \MongoDate) {
            $castValue = $value;
        } else if (is_int($value)) {
            $castValue = new \MongoDate($value);
        }

        if (!$castValue) throw new \Exception('Bad value: could not convert to MongoDate');
        
        return $this->mergeCriteria(array('date' => $castValue ));
    }

    /**
     * Find by "database" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    public function findByDatabase($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('basatos' => $castValue ));
    }

    /**
     * Find by "authorId" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    private function findByAuthorId($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('author' => $id));
    }

    private function findByAuthorIdIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('author' => array('$in' => $ids)));
    }

    /**
     * Find by "informationId" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    private function findByInformationId($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('information' => $id));
    }

    private function findByInformationIdIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('information' => array('$in' => $ids)));
    }

    /**
     * Find by "categoryIds" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\ArticleQuery The query with added criteria (fluent interface).
     */
    private function findByCategoryIds($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('categories' => $id));
    }

    private function findByCategoryIdsIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('categories' => array('$in' => $ids)));
    }

    public function findByAuthor($value)
    {
        return $this->findByAuthorId($value);
    }

    public function findByAuthorIds(array $ids)
    {
        return $this->findByAuthorIdIds($ids);
    }

    public function findByInformation($value)
    {
        return $this->findByInformationId($value);
    }

    public function findByInformationIds(array $ids)
    {
        return $this->findByInformationIdIds($ids);
    }

    public function findByCategories($value)
    {
        return $this->findByCategoryIds($value);
    }

    public function findByCategoriesIds(array $ids)
    {
        return $this->findByCategoryIdsIds($ids);
    }
}