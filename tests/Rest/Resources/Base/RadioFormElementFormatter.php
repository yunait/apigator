<?php

namespace Rest\Resources\Base;

abstract class RadioFormElementFormatter extends \Level3\Mongator\Formatter\Formatter
{

    public function toResponse(\Level3\Hal\ResourceBuilder $builder, \Mongator\Document\AbstractDocument $document)
    {
        $data = $document->toArray();

        $source = $document->getSource();
        if (!$source) {
            return null;
        }

        $data['source'] = $this->types->toResponseArray($source->toArray());

        $sourceLocal = $document->getSourceLocal();
        if (!$sourceLocal) {
            return null;
        }

        $data['sourceLocal'] = $this->types->toResponseArray($sourceLocal->toArray());


        $comments = [];
        foreach($document->getComments() as $elem) {
            $comments[] = $this->types->toResponseArray($elem->toArray());
        }

        $data['comments'] = $comments;

        $commentsLocal = [];
        foreach($document->getCommentsLocal() as $elem) {
            $commentsLocal[] = $this->types->toResponseArray($elem->toArray());
        }

        $data['commentsLocal'] = $commentsLocal;

        $builder->withData($this->types->toResponseArray($data));

        $referenced = $document->getAuthor();
        if ($referenced) {
            $builder->withLinkToResource('author',
                'author', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
            );
        }
        $referenced = $document->getAuthorLocal();
        if ($referenced) {
            $builder->withLinkToResource('authorLocal',
                'author', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
            );
        }

        foreach ($document->getCategories() as $relation) {
            $builder->withLinkToResource('categories',
                'category', new \Level3\Messages\Parameters(['id' => $relation->getId()]), (string) $relation->getId()
            );
        }

        foreach ($document->getCategoriesLocal() as $relation) {
            $builder->withLinkToResource('categoriesLocal',
                'category', new \Level3\Messages\Parameters(['id' => $relation->getId()]), (string) $relation->getId()
            );
        }


        return $builder->build();
    }

    public function fromRequest(Array $data)
    {
        if (isset($data['author'])) {
            $data['author_reference_field'] = $this->types->fromRequest('MongoId', $data['author']);
            unset($data['author']);
        }
        if (isset($data['authorLocal'])) {
            $data['authorLocal_reference_field'] = $this->types->fromRequest('MongoId', $data['authorLocal']);
            unset($data['authorLocal']);
        }

        return $data;
    }
}