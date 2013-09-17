<?php

namespace Rest\Resources\Base;

abstract class TextElementFormatter extends \Level3\Mongator\Formatter\Formatter
{

    public function toResponse(\Level3\Hal\ResourceBuilder $builder, \Mongator\Document\AbstractDocument $document)
    {
        $data = $document->toArray();

        $source = $document->getSource();
        if (!$source) {
            return null;
        }

        $data['source'] = $this->types->toResponseArray($source->toArray());


        $builder->withData($this->types->toResponseArray($data));


        foreach ($document->getCategories() as $relation) {
            $builder->withLinkToResource('categories',
                'category', new \Level3\Messages\Parameters(['id' => $relation->getId()]), (string) $relation->getId()
            );
        }


        return $builder->build();
    }

    public function fromRequest(Array $data)
    {
        return $data;
    }
}