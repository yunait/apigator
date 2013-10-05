<?php

namespace Model\Base;

/**
 * Base class of query of Model\ArticleVote document.
 */
abstract class ArticleVoteQuery extends \Mongator\Query\Query
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
     * Find by "articleId" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\ArticleVoteQuery The query with added criteria (fluent interface).
     */
    private function findByArticleId($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('article' => $id));
    }

    private function findByArticleIdIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('article' => array('$in' => $ids)));
    }

    /**
     * Find by "userId" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\ArticleVoteQuery The query with added criteria (fluent interface).
     */
    private function findByUserId($value)
    {
        $id = $this->valueToMongoId($value);
        return $this->mergeCriteria(array('user' => $id));
    }

    private function findByUserIdIds(array $ids)
    {
        $ids = $this->getRepository()->idsToMongo($ids);
        return $this->mergeCriteria(array('user' => array('$in' => $ids)));
    }

    public function findByArticle($value)
    {
        return $this->findByArticleId($value);
    }

    public function findByArticleIds(array $ids)
    {
        return $this->findByArticleIdIds($ids);
    }

    public function findByUser($value)
    {
        return $this->findByUserId($value);
    }

    public function findByUserIds(array $ids)
    {
        return $this->findByUserIdIds($ids);
    }
}