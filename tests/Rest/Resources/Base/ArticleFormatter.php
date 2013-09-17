<?php

namespace Rest\Resources\Base;

abstract class ArticleFormatter extends \Level3\Mongator\Formatter\Formatter
{

    public function toResponse(\Level3\Hal\ResourceBuilder $builder, \Mongator\Document\AbstractDocument $document)
    {
        $data = $document->toArray();

        $source = $document->getSource();
        if (!$source) {
            return null;
        }

        $data['source'] = $this->types->toResponseArray($source->toArray());

        $simpleEmbedded = $document->getSimpleEmbedded();
        if (!$simpleEmbedded) {
            return null;
        }

        $data['simpleEmbedded'] = $this->types->toResponseArray($simpleEmbedded->toArray());


        $comments = [];
        foreach($document->getComments() as $elem) {
            $comments[] = $this->types->toResponseArray($elem->toArray());
        }

        $data['comments'] = $comments;

        $builder->withData($this->types->toResponseArray($data));

        $referenced = $document->getAuthor();
        if ($referenced) {
            $builder->withLinkToResource('author',
                'author', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
            );
        }
        $referenced = $document->getInformation();
        if ($referenced) {
            $builder->withLinkToResource('information',
                'articleinformation', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
            );
        }

        foreach ($document->getCategories() as $relation) {
            $builder->withLinkToResource('categories',
                'category', new \Level3\Messages\Parameters(['id' => $relation->getId()]), (string) $relation->getId()
            );
        }


        return $builder->build();
    }

    public function fromRequest(Array $data)
    {
        if (isset($data['date'])) {
            $data['date'] = $this->types->fromRequest('DateTime', $data['date']);
        }


        if (isset($data['author'])) {
            $data['author_reference_field'] = $this->types->fromRequest('MongoId', $data['author']);
            unset($data['author']);
        }
        if (isset($data['information'])) {
            $data['information_reference_field'] = $this->types->fromRequest('MongoId', $data['information']);
            unset($data['information']);
        }

        return $data;
    }
}