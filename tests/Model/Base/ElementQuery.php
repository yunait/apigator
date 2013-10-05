<?php

namespace Model\Base;

/**
 * Base class of query of Model\Element document.
 */
abstract class ElementQuery extends \Mongator\Query\Query
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
        $identityMaps = array();
        $mongator = $this->getRepository()->getMongator();
        $isFile = $this->getRepository()->isFile();

        if ($fields = $this->getFields()) {
            $fields['type'] = 1;
            $this->fields($fields);
        }

        $documents = array();
        foreach ($this->execute() as $data) {
            $documentClass = null;
            $identityMap = null;
            if (isset($data['type'])) {
                if ('textelement' == $data['type']) {
                    if (!isset($identityMaps['textelement'])) {
                        $identityMaps['textelement'] = $mongator->getRepository('Model\TextElement')->getIdentityMap()->allByReference();
                    }
                    $documentClass = 'Model\TextElement';
                    $identityMap = $identityMaps['textelement'];
                }
                if ('texttextelement' == $data['type']) {
                    if (!isset($identityMaps['texttextelement'])) {
                        $identityMaps['texttextelement'] = $mongator->getRepository('Model\TextTextElement')->getIdentityMap()->allByReference();
                    }
                    $documentClass = 'Model\TextTextElement';
                    $identityMap = $identityMaps['texttextelement'];
                }
                if ('formelement' == $data['type']) {
                    if (!isset($identityMaps['formelement'])) {
                        $identityMaps['formelement'] = $mongator->getRepository('Model\FormElement')->getIdentityMap()->allByReference();
                    }
                    $documentClass = 'Model\FormElement';
                    $identityMap = $identityMaps['formelement'];
                }
                if ('textarea' == $data['type']) {
                    if (!isset($identityMaps['textarea'])) {
                        $identityMaps['textarea'] = $mongator->getRepository('Model\TextareaFormElement')->getIdentityMap()->allByReference();
                    }
                    $documentClass = 'Model\TextareaFormElement';
                    $identityMap = $identityMaps['textarea'];
                }
                if ('radio' == $data['type']) {
                    if (!isset($identityMaps['radio'])) {
                        $identityMaps['radio'] = $mongator->getRepository('Model\RadioFormElement')->getIdentityMap()->allByReference();
                    }
                    $documentClass = 'Model\RadioFormElement';
                    $identityMap = $identityMaps['radio'];
                }
            }
            if (null === $documentClass) {
                if (!isset($identityMaps['_root'])) {
                    $identityMaps['_root'] = $this->getRepository()->getIdentityMap()->allByReference();
                }
                $documentClass = 'Model\Element';
                $identityMap = $identityMaps['_root'];
            }
            
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
     * Find by "label" field.
     *
     * @param mixed $value The value.
     *
     * @return Model\ElementQuery The query with added criteria (fluent interface).
     */
    public function findByLabel($value)
    {
        $castValue = (string) $value;
        if ($castValue !== $value) throw new \Exception('Bad value: type string expected');
        
        return $this->mergeCriteria(array('label' => $castValue ));
    }

    /**
     * Find by "categories_reference_field" reference.
     *
     * @param MongoId|Document $value
     *
     * @return Model\ElementQuery The query with added criteria (fluent interface).
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

    public function findByCategories($value)
    {
        return $this->findByCategories_reference_field($value);
    }

    public function findByCategoriesIds(array $ids)
    {
        return $this->findByCategories_reference_fieldIds($ids);
    }
}