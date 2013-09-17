<?php

namespace Rest\Resources\Base;

abstract class MessageFormatter extends \Level3\Mongator\Formatter\Formatter
{

    public function toResponse(\Level3\Hal\ResourceBuilder $builder, \Mongator\Document\AbstractDocument $document)
    {
        $data = $document->toArray();


        $builder->withData($this->types->toResponseArray($data));

        $referenced = $document->getReplyTo();
        if ($referenced) {
            $builder->withLinkToResource('replyTo',
                'message', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
            );
        }


        return $builder->build();
    }

    public function fromRequest(Array $data)
    {
        if (isset($data['replyTo'])) {
            $data['replyTo_reference_field'] = $this->types->fromRequest('MongoId', $data['replyTo']);
            unset($data['replyTo']);
        }

        return $data;
    }
}