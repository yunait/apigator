<?php

namespace Rest\Resources\Base;

abstract class InitializeArgsFormatter extends \Level3\Mongator\Formatter\Formatter
{

    public function toResponse(\Level3\Hal\ResourceBuilder $builder, \Mongator\Document\AbstractDocument $document)
    {
        $data = $document->toArray();


        $builder->withData($this->types->toResponseArray($data));

        $referenced = $document->getAuthor();
        if ($referenced) {
            $builder->withLinkToResource('author',
                'author', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
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

        return $data;
    }
}