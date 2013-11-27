<?php
namespace Level3\Mongator\Helper;

use Level3\Hub;
use Level3\Repository;
use Level3\Repository\Finder;
use Level3\Resource\Resource;
use Level3\Resource\Link;
use Level3\Exceptions\BadRequest;
use Level3\Exceptions\NotFound;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Return the repository metadata from mongator
 */
class MetadataRepository extends Repository implements Finder
{
    public function __construct(\Level3\Level3 $level3, \Mongator\Mongator $mongator)
    {
        parent::__construct($level3);

        $this->mongator = $mongator;
    }

    public function find(ParameterBag $attributes, ParameterBag $query)
    {
        if (!$query->has('byKey')) {
            throw new BadRequest('"byKey" query param required!');
        }

        $repository = $this->findDocumentRepositoryByKey($query->get('byKey'));
        $metadata = $this->getMetadata($repository->getDocumentClass());

        if ($query->has('byRelation')) {
            $class = $this->getClassByRelation($metadata, $query->get('byRelation'));
            $metadata = $this->getMetadata($class);
        }

        return $this->createResourceFromMetadata($query->get('byKey'), $metadata);
    }

    protected function findDocumentRepositoryByKey($key)
    {
        $hub = $this->level3->getHub();
        return $hub->get($key)->getDocumentRepository();
    }

    protected function getClassByRelation(Array $metadata, $relation)
    {
        if (isset($metadata['referencesOne'][$relation])) {
            return $metadata['referencesOne'][$relation]['class'];
        }

        if (isset($metadata['referencesMany'][$relation])) {
            return $metadata['referencesMany'][$relation]['class'];
        }

        if (isset($metadata['embeddedsOne'][$relation])) {
            return $metadata['embeddedsOne'][$relation]['class'];
        }

        if (isset($metadata['embeddedsMany'][$relation])) {
            return $metadata['embeddedsMany'][$relation]['class'];
        }

        throw new NotFound();
    }

    protected function getMetadata($documentClass)
    {
        return $this->mongator->getMetadataFactory()->getClass($documentClass);
    }

    protected function createResourceFromMetadata($key, Array $metadata)
    {
        $resource = new Resource();
        $resource->setData($metadata);
        
        $resource->setLinks(
            'embeddedsOne', 
            $this->createLinksForEmbeddeds($key, $metadata['embeddedsOne'])
        );

        $resource->setLinks(
            'embeddedsMany', 
            $this->createLinksForEmbeddeds($key, $metadata['embeddedsMany'])
        );

        $resource->setLinks(
            'referencesOne', 
            $this->createLinksForReferences($key, $metadata['referencesOne'])
        );

        $resource->setLinks(
            'referencesMany', 
            $this->createLinksForReferences($key, $metadata['referencesOne'])
        );

        return $resource;
    }

    protected function createLinksForReferences($key, $references)
    {
        $links = [];
        foreach ($references as $relation => $reference) {
            $key =  $this->level3->getHub()->getByClass($reference['class'])->getKey();

            $link = new Link(sprintf(
                '%s?byKey=%s',
                $this->getURI(null), $key
            ));

            $link->setName($relation);
            
            $links[] = $link;
        }

        return $links;
    }

    protected function createLinksForEmbeddeds($key, $embeddeds)
    {
        $links = [];
        foreach ($embeddeds as $relation => $embedded) {
            $link = new Link(sprintf(
                '%s?byKey=%s&byRelation=%s',
                $this->getURI(null), $key, $relation
            ));

            $link->setName($relation);

            $links[] = $link;
        }

        return $links;
    }
}
