<?php

namespace Model\Mapping;

class MetadataFactoryInfo
{

    public function getModelArticleClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'articles',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'title' => array(
                    'type' => 'string',
                    'dbName' => 'title',
                ),
                'content' => array(
                    'type' => 'string',
                    'dbName' => 'content',
                ),
                'note' => array(
                    'type' => 'string',
                    'dbName' => 'note',
                ),
                'line' => array(
                    'type' => 'string',
                    'dbName' => 'line',
                ),
                'text' => array(
                    'type' => 'string',
                    'dbName' => 'text',
                ),
                'isActive' => array(
                    'type' => 'boolean',
                    'dbName' => 'isActive',
                ),
                'date' => array(
                    'type' => 'date',
                    'dbName' => 'date',
                ),
                'database' => array(
                    'dbName' => 'basatos',
                    'type' => 'string',
                ),
                'authorId' => array(
                    'type' => 'raw',
                    'dbName' => 'author',
                    'referenceField' => true,
                ),
                'informationId' => array(
                    'type' => 'raw',
                    'dbName' => 'information',
                    'referenceField' => true,
                ),
                'categoryIds' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'author' => array(
                    'class' => 'Model\\Author',
                    'field' => 'authorId',
                    'onDelete' => 'cascade',
                ),
                'information' => array(
                    'class' => 'Model\\ArticleInformation',
                    'field' => 'informationId',
                    'onDelete' => 'unset',
                ),
            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'field' => 'categoryIds',
                    'onDelete' => 'unset',
                ),
            ),
            'embeddedsOne' => array(
                'source' => array(
                    'class' => 'Model\\Source',
                ),
                'simpleEmbedded' => array(
                    'class' => 'Model\\SimpleEmbedded',
                ),
            ),
            'embeddedsMany' => array(
                'comments' => array(
                    'class' => 'Model\\Comment',
                ),
            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(
                'votesUsers' => array(
                    'class' => 'Model\\User',
                    'through' => 'Model\\ArticleVote',
                    'local' => 'article',
                    'foreign' => 'user',
                ),
            ),
            'indexes' => array(
                0 => array(
                    'keys' => array(
                        'slug' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'authorId' => 1,
                        'isActive' => 1,
                    ),
                ),
            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'slug' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'authorId' => 1,
                        'isActive' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'source.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'source.authorId' => 1,
                        'source.line' => 1,
                    ),
                ),
                4 => array(
                    'keys' => array(
                        'source.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                5 => array(
                    'keys' => array(
                        'source.info.name' => 1,
                        'source.info.line' => 1,
                    ),
                ),
                6 => array(
                    'keys' => array(
                        'comments.line' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                7 => array(
                    'keys' => array(
                        'comments.authorId' => 1,
                        'comments.note' => 1,
                    ),
                ),
                8 => array(
                    'keys' => array(
                        'comments.infos.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                9 => array(
                    'keys' => array(
                        'comments.infos.name' => 1,
                        'comments.infos.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelArticleInformationClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_articleinformation',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(
                'article' => array(
                    'class' => 'Model\\Article',
                    'reference' => 'information',
                ),
            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelArticleVoteClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_articlevote',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'articleId' => array(
                    'type' => 'raw',
                    'dbName' => 'article',
                    'referenceField' => true,
                ),
                'userId' => array(
                    'type' => 'raw',
                    'dbName' => 'user',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'article' => array(
                    'class' => 'Model\\Article',
                    'field' => 'articleId',
                ),
                'user' => array(
                    'class' => 'Model\\User',
                    'field' => 'userId',
                ),
            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelAuthorClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_author',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(
                'articles' => array(
                    'class' => 'Model\\Article',
                    'reference' => 'author',
                ),
            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelCategoryClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_category',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(
                'articles' => array(
                    'class' => 'Model\\Article',
                    'reference' => 'categories',
                ),
            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelCommentClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'text' => array(
                    'type' => 'string',
                    'dbName' => 'text',
                ),
                'note' => array(
                    'type' => 'string',
                    'dbName' => 'note',
                ),
                'line' => array(
                    'type' => 'string',
                    'dbName' => 'line',
                ),
                'date' => array(
                    'type' => 'date',
                    'dbName' => 'date',
                ),
                'authorId' => array(
                    'type' => 'raw',
                    'dbName' => 'author',
                    'referenceField' => true,
                ),
                'categoryIds' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'author' => array(
                    'class' => 'Model\\Author',
                    'field' => 'authorId',
                ),
            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'field' => 'categoryIds',
                ),
            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(
                'infos' => array(
                    'class' => 'Model\\Info',
                ),
            ),
            'indexes' => array(
                0 => array(
                    'keys' => array(
                        'line' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'authorId' => 1,
                        'note' => 1,
                    ),
                ),
            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'line' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'authorId' => 1,
                        'note' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'infos.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'infos.name' => 1,
                        'infos.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelInfoClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'text' => array(
                    'type' => 'string',
                    'dbName' => 'text',
                ),
                'note' => array(
                    'type' => 'string',
                    'dbName' => 'note',
                ),
                'line' => array(
                    'type' => 'string',
                    'dbName' => 'line',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'indexes' => array(
                0 => array(
                    'keys' => array(
                        'note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'name' => 1,
                        'line' => 1,
                    ),
                ),
            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'name' => 1,
                        'line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelSourceClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'id' => array(
                    'type' => 'string',
                    'dbName' => 'id',
                ),
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'text' => array(
                    'type' => 'string',
                    'dbName' => 'text',
                ),
                'note' => array(
                    'type' => 'string',
                    'dbName' => 'note',
                ),
                'line' => array(
                    'type' => 'string',
                    'dbName' => 'line',
                ),
                'from' => array(
                    'dbName' => 'desde',
                    'type' => 'string',
                ),
                'authorId' => array(
                    'type' => 'raw',
                    'dbName' => 'author',
                    'referenceField' => true,
                ),
                'categoryIds' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'author' => array(
                    'class' => 'Model\\Author',
                    'field' => 'authorId',
                ),
            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'field' => 'categoryIds',
                ),
            ),
            'embeddedsOne' => array(
                'info' => array(
                    'class' => 'Model\\Info',
                ),
            ),
            'embeddedsMany' => array(

            ),
            'indexes' => array(
                0 => array(
                    'keys' => array(
                        'name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'authorId' => 1,
                        'line' => 1,
                    ),
                ),
            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'authorId' => 1,
                        'line' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'info.name' => 1,
                        'info.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelUserClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_user',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'username' => array(
                    'type' => 'string',
                    'dbName' => 'username',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelSimpleEmbeddedClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelMessageClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_message',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'author' => array(
                    'type' => 'string',
                    'dbName' => 'author',
                ),
                'text' => array(
                    'type' => 'string',
                    'dbName' => 'text',
                ),
                'replyToId' => array(
                    'type' => 'raw',
                    'dbName' => 'replyTo',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'replyTo' => array(
                    'class' => 'Model\\Message',
                    'field' => 'replyToId',
                ),
            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(
                0 => array(
                    'keys' => array(
                        'author' => 'text',
                        'text' => 'text',
                    ),
                    'options' => array(
                        'name' => 'ExampleTextIndex',
                        'weights' => array(
                            'author' => 100,
                            'text' => 30,
                        ),
                    ),
                ),
            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'author' => 'text',
                        'text' => 'text',
                    ),
                    'options' => array(
                        'name' => 'ExampleTextIndex',
                        'weights' => array(
                            'author' => 100,
                            'text' => 30,
                        ),
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelBookClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_book',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'title' => array(
                    'type' => 'string',
                    'dbName' => 'title',
                ),
                'comment' => array(
                    'type' => 'string',
                    'default' => 'good',
                    'dbName' => 'comment',
                ),
                'isHere' => array(
                    'type' => 'boolean',
                    'default' => true,
                    'dbName' => 'isHere',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelEventsClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_events',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelEventsEmbeddedOneClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_eventsembeddedone',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(
                'embedded' => array(
                    'class' => 'Model\\EmbeddedEvents',
                ),
            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelEventsEmbeddedManyClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_eventsembeddedmany',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(
                'embedded' => array(
                    'class' => 'Model\\EmbeddedEvents',
                ),
            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelEmbeddedEventsClass()
    {
        return array(
            'isEmbedded' => true,
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelInitializeArgsClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_initializeargs',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
                'author_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'author',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'author' => array(
                    'class' => 'Model\\Author',
                    'field' => 'author_reference_field',
                ),
            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelImageClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_image',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelConnectionGlobalClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => 'global',
            'collection' => 'model_connectionglobal',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'field' => array(
                    'type' => 'string',
                    'dbName' => 'field',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelElementClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_element',
            'inheritable' => array(
                'type' => 'single',
                'field' => 'type',
                'values' => array(
                    'textelement' => 'Model\\TextElement',
                    'texttextelement' => 'Model\\TextTextElement',
                    'formelement' => 'Model\\FormElement',
                    'textarea' => 'Model\\TextareaFormElement',
                    'radio' => 'Model\\RadioFormElement',
                ),
            ),
            'inheritance' => false,
            'fields' => array(
                'label' => array(
                    'type' => 'string',
                    'dbName' => 'label',
                ),
                'categories_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(

            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'field' => 'categories_reference_field',
                ),
            ),
            'embeddedsOne' => array(
                'source' => array(
                    'class' => 'Model\\Source',
                ),
            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'source.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'source.authorId' => 1,
                        'source.line' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'source.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'source.info.name' => 1,
                        'source.info.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelTextElementClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_element',
            'inheritable' => array(
                'type' => 'single',
                'field' => 'type',
                'values' => array(
                    'texttextelement' => 'Model\\TextTextElement',
                ),
            ),
            'inheritance' => array(
                'class' => 'Model\\Element',
                'value' => 'textelement',
                'type' => 'single',
                'field' => 'type',
            ),
            'fields' => array(
                'label' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'label',
                ),
                'htmltext' => array(
                    'type' => 'string',
                    'inherited' => false,
                    'dbName' => 'htmltext',
                ),
                'categories_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                    'inherited' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(

            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'inherited' => true,
                    'field' => 'categories_reference_field',
                ),
            ),
            'embeddedsOne' => array(
                'source' => array(
                    'class' => 'Model\\Source',
                    'inherited' => true,
                ),
            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'source.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'source.authorId' => 1,
                        'source.line' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'source.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'source.info.name' => 1,
                        'source.info.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelTextTextElementClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_element',
            'inheritable' => false,
            'inheritance' => array(
                'class' => 'Model\\TextElement',
                'value' => 'texttextelement',
                'type' => 'single',
                'field' => 'type',
            ),
            'fields' => array(
                'label' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'label',
                ),
                'htmltext' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'htmltext',
                ),
                'text_text' => array(
                    'type' => 'string',
                    'inherited' => false,
                    'dbName' => 'text_text',
                ),
                'categories_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                    'inherited' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(

            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'inherited' => true,
                    'field' => 'categories_reference_field',
                ),
            ),
            'embeddedsOne' => array(
                'source' => array(
                    'class' => 'Model\\Source',
                    'inherited' => true,
                ),
            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'source.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'source.authorId' => 1,
                        'source.line' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'source.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'source.info.name' => 1,
                        'source.info.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelFormElementClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_element',
            'inheritable' => array(
                'type' => 'single',
                'field' => 'type',
                'values' => array(
                    'textarea' => 'Model\\TextareaFormElement',
                    'radio' => 'Model\\RadioFormElement',
                ),
            ),
            'inheritance' => array(
                'class' => 'Model\\Element',
                'value' => 'formelement',
                'type' => 'single',
                'field' => 'type',
            ),
            'fields' => array(
                'label' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'label',
                ),
                'default' => array(
                    'type' => 'raw',
                    'inherited' => false,
                    'dbName' => 'default',
                ),
                'author_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'author',
                    'referenceField' => true,
                ),
                'categories_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                    'inherited' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'author' => array(
                    'class' => 'Model\\Author',
                    'inherited' => false,
                    'field' => 'author_reference_field',
                ),
            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'inherited' => true,
                    'field' => 'categories_reference_field',
                ),
            ),
            'embeddedsOne' => array(
                'source' => array(
                    'class' => 'Model\\Source',
                    'inherited' => true,
                ),
            ),
            'embeddedsMany' => array(
                'comments' => array(
                    'class' => 'Model\\Comment',
                    'inherited' => false,
                ),
            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'source.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'source.authorId' => 1,
                        'source.line' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'source.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'source.info.name' => 1,
                        'source.info.line' => 1,
                    ),
                ),
                4 => array(
                    'keys' => array(
                        'comments.line' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                5 => array(
                    'keys' => array(
                        'comments.authorId' => 1,
                        'comments.note' => 1,
                    ),
                ),
                6 => array(
                    'keys' => array(
                        'comments.infos.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                7 => array(
                    'keys' => array(
                        'comments.infos.name' => 1,
                        'comments.infos.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelTextareaFormElementClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_element',
            'inheritable' => false,
            'inheritance' => array(
                'class' => 'Model\\FormElement',
                'value' => 'textarea',
                'type' => 'single',
                'field' => 'type',
            ),
            'fields' => array(
                'label' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'label',
                ),
                'default' => array(
                    'type' => 'string',
                    'inherited' => false,
                    'dbName' => 'default',
                ),
                'author_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'author',
                    'referenceField' => true,
                    'inherited' => true,
                ),
                'categories_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                    'inherited' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'author' => array(
                    'class' => 'Model\\Author',
                    'inherited' => true,
                    'field' => 'author_reference_field',
                ),
            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'inherited' => true,
                    'field' => 'categories_reference_field',
                ),
            ),
            'embeddedsOne' => array(
                'source' => array(
                    'class' => 'Model\\Source',
                    'inherited' => true,
                ),
            ),
            'embeddedsMany' => array(
                'comments' => array(
                    'class' => 'Model\\Comment',
                    'inherited' => true,
                ),
            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'source.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'source.authorId' => 1,
                        'source.line' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'source.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'source.info.name' => 1,
                        'source.info.line' => 1,
                    ),
                ),
                4 => array(
                    'keys' => array(
                        'comments.line' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                5 => array(
                    'keys' => array(
                        'comments.authorId' => 1,
                        'comments.note' => 1,
                    ),
                ),
                6 => array(
                    'keys' => array(
                        'comments.infos.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                7 => array(
                    'keys' => array(
                        'comments.infos.name' => 1,
                        'comments.infos.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelRadioFormElementClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_element',
            'inheritable' => false,
            'inheritance' => array(
                'class' => 'Model\\FormElement',
                'value' => 'radio',
                'type' => 'single',
                'field' => 'type',
            ),
            'fields' => array(
                'label' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'label',
                ),
                'default' => array(
                    'type' => 'raw',
                    'inherited' => true,
                    'dbName' => 'default',
                ),
                'options' => array(
                    'type' => 'serialized',
                    'inherited' => false,
                    'dbName' => 'options',
                ),
                'author_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'author',
                    'referenceField' => true,
                    'inherited' => true,
                ),
                'authorLocal_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'authorLocal',
                    'referenceField' => true,
                ),
                'categories_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'categories',
                    'referenceField' => true,
                    'inherited' => true,
                ),
                'categoriesLocal_reference_field' => array(
                    'type' => 'raw',
                    'dbName' => 'categoriesLocal',
                    'referenceField' => true,
                ),
            ),
            '_has_references' => true,
            'referencesOne' => array(
                'author' => array(
                    'class' => 'Model\\Author',
                    'inherited' => true,
                    'field' => 'author_reference_field',
                ),
                'authorLocal' => array(
                    'class' => 'Model\\Author',
                    'inherited' => false,
                    'field' => 'authorLocal_reference_field',
                ),
            ),
            'referencesMany' => array(
                'categories' => array(
                    'class' => 'Model\\Category',
                    'inherited' => true,
                    'field' => 'categories_reference_field',
                ),
                'categoriesLocal' => array(
                    'class' => 'Model\\Category',
                    'inherited' => false,
                    'field' => 'categoriesLocal_reference_field',
                ),
            ),
            'embeddedsOne' => array(
                'source' => array(
                    'class' => 'Model\\Source',
                    'inherited' => true,
                ),
                'sourceLocal' => array(
                    'class' => 'Model\\Source',
                    'inherited' => false,
                ),
            ),
            'embeddedsMany' => array(
                'comments' => array(
                    'class' => 'Model\\Comment',
                    'inherited' => true,
                ),
                'commentsLocal' => array(
                    'class' => 'Model\\Comment',
                    'inherited' => false,
                ),
            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(
                0 => array(
                    'keys' => array(
                        'source.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                1 => array(
                    'keys' => array(
                        'source.authorId' => 1,
                        'source.line' => 1,
                    ),
                ),
                2 => array(
                    'keys' => array(
                        'source.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                3 => array(
                    'keys' => array(
                        'source.info.name' => 1,
                        'source.info.line' => 1,
                    ),
                ),
                4 => array(
                    'keys' => array(
                        'sourceLocal.name' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                5 => array(
                    'keys' => array(
                        'sourceLocal.authorId' => 1,
                        'sourceLocal.line' => 1,
                    ),
                ),
                6 => array(
                    'keys' => array(
                        'sourceLocal.info.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                7 => array(
                    'keys' => array(
                        'sourceLocal.info.name' => 1,
                        'sourceLocal.info.line' => 1,
                    ),
                ),
                8 => array(
                    'keys' => array(
                        'comments.line' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                9 => array(
                    'keys' => array(
                        'comments.authorId' => 1,
                        'comments.note' => 1,
                    ),
                ),
                10 => array(
                    'keys' => array(
                        'comments.infos.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                11 => array(
                    'keys' => array(
                        'comments.infos.name' => 1,
                        'comments.infos.line' => 1,
                    ),
                ),
                12 => array(
                    'keys' => array(
                        'commentsLocal.line' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                13 => array(
                    'keys' => array(
                        'commentsLocal.authorId' => 1,
                        'commentsLocal.note' => 1,
                    ),
                ),
                14 => array(
                    'keys' => array(
                        'commentsLocal.infos.note' => 1,
                    ),
                    'options' => array(
                        'unique' => true,
                    ),
                ),
                15 => array(
                    'keys' => array(
                        'commentsLocal.infos.name' => 1,
                        'commentsLocal.infos.line' => 1,
                    ),
                ),
            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelNoneIdGeneratorClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_noneidgenerator',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelNativeIdGeneratorClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_nativeidgenerator',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelSequenceIdGeneratorClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_sequenceidgenerator',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelSequenceIdGenerator2Class()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_sequenceidgenerator2',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelSequenceIdGeneratorDescendingClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_sequenceidgeneratordescending',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelSequenceIdGeneratorStartClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_sequenceidgeneratorstart',
            'inheritable' => false,
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelIdGeneratorSingleInheritanceGrandParentClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_idgeneratorsingleinheritancegrandparent',
            'inheritable' => array(
                'type' => 'single',
                'field' => 'type',
                'values' => array(
                    'parent' => 'Model\\IdGeneratorSingleInheritanceParent',
                    'child' => 'Model\\IdGeneratorSingleInheritanceChild',
                ),
            ),
            'inheritance' => false,
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelIdGeneratorSingleInheritanceParentClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_idgeneratorsingleinheritancegrandparent',
            'inheritable' => array(
                'type' => 'single',
                'field' => 'type',
                'values' => array(
                    'child' => 'Model\\IdGeneratorSingleInheritanceChild',
                ),
            ),
            'inheritance' => array(
                'class' => 'Model\\IdGeneratorSingleInheritanceGrandParent',
                'value' => 'parent',
                'type' => 'single',
                'field' => 'type',
            ),
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }

    public function getModelIdGeneratorSingleInheritanceChildClass()
    {
        return array(
            'isEmbedded' => false,
            'Mongator' => null,
            'connection' => '',
            'collection' => 'model_idgeneratorsingleinheritancegrandparent',
            'inheritable' => false,
            'inheritance' => array(
                'class' => 'Model\\IdGeneratorSingleInheritanceParent',
                'value' => 'child',
                'type' => 'single',
                'field' => 'type',
            ),
            'fields' => array(
                'name' => array(
                    'type' => 'string',
                    'inherited' => true,
                    'dbName' => 'name',
                ),
            ),
            '_has_references' => false,
            'referencesOne' => array(

            ),
            'referencesMany' => array(

            ),
            'embeddedsOne' => array(

            ),
            'embeddedsMany' => array(

            ),
            'relationsOne' => array(

            ),
            'relationsManyOne' => array(

            ),
            'relationsManyMany' => array(

            ),
            'relationsManyThrough' => array(

            ),
            'indexes' => array(

            ),
            '_indexes' => array(

            ),
            'cache' => array(

            ),
            'behaviors' => array(

            ),
        );
    }
}