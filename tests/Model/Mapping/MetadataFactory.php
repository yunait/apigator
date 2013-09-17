<?php

namespace Model\Mapping;

class MetadataFactory extends \Mongator\MetadataFactory
{

    protected $classes = array(
        'Model\\Article' => false,
        'Model\\ArticleInformation' => false,
        'Model\\ArticleVote' => false,
        'Model\\Author' => false,
        'Model\\Category' => false,
        'Model\\Comment' => true,
        'Model\\Info' => true,
        'Model\\Source' => true,
        'Model\\User' => false,
        'Model\\SimpleEmbedded' => true,
        'Model\\Message' => false,
        'Model\\Book' => false,
        'Model\\Events' => false,
        'Model\\EventsEmbeddedOne' => false,
        'Model\\EventsEmbeddedMany' => false,
        'Model\\EmbeddedEvents' => true,
        'Model\\InitializeArgs' => false,
        'Model\\Image' => false,
        'Model\\ConnectionGlobal' => false,
        'Model\\Element' => false,
        'Model\\TextElement' => false,
        'Model\\TextTextElement' => false,
        'Model\\FormElement' => false,
        'Model\\TextareaFormElement' => false,
        'Model\\RadioFormElement' => false,
        'Model\\NoneIdGenerator' => false,
        'Model\\NativeIdGenerator' => false,
        'Model\\SequenceIdGenerator' => false,
        'Model\\SequenceIdGenerator2' => false,
        'Model\\SequenceIdGeneratorDescending' => false,
        'Model\\SequenceIdGeneratorStart' => false,
        'Model\\IdGeneratorSingleInheritanceGrandParent' => false,
        'Model\\IdGeneratorSingleInheritanceParent' => false,
        'Model\\IdGeneratorSingleInheritanceChild' => false,
    );
}