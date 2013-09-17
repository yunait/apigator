<?php

namespace Rest\Resources\Base;

abstract class EventsEmbeddedManyFormatter extends \Level3\Mongator\Formatter\Formatter
{

    public function toResponse(\Level3\Hal\ResourceBuilder $builder, \Mongator\Document\AbstractDocument $document)
    {
        $data = $document->toArray();


        $embedded = [];
        foreach($document->getEmbedded() as $elem) {
            $embedded[] = $this->types->toResponseArray($elem->toArray());
        }

        $data['embedded'] = $embedded;

        $builder->withData($this->types->toResponseArray($data));



        return $builder->build();
    }

    public function fromRequest(Array $data)
    {
        return $data;
    }
}