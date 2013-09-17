<?php

namespace Rest\Resources\Base;

abstract class ArticleVoteFormatter extends \Level3\Mongator\Formatter\Formatter
{

    public function toResponse(\Level3\Hal\ResourceBuilder $builder, \Mongator\Document\AbstractDocument $document)
    {
        $data = $document->toArray();


        $builder->withData($this->types->toResponseArray($data));

        $referenced = $document->getArticle();
        if ($referenced) {
            $builder->withLinkToResource('article',
                'article', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
            );
        }
        $referenced = $document->getUser();
        if ($referenced) {
            $builder->withLinkToResource('user',
                'user', new \Level3\Messages\Parameters(['id' => $referenced->getId()]), (string) $referenced->getId()
            );
        }


        return $builder->build();
    }

    public function fromRequest(Array $data)
    {
        if (isset($data['article'])) {
            $data['article_reference_field'] = $this->types->fromRequest('MongoId', $data['article']);
            unset($data['article']);
        }
        if (isset($data['user'])) {
            $data['user_reference_field'] = $this->types->fromRequest('MongoId', $data['user']);
            unset($data['user']);
        }

        return $data;
    }
}