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
use Level3\Helper\IndexRepository as BaseIndexRepository;

/**
 * Return the repository metadata from mongator
 */
class IndexRepository extends BaseIndexRepository
{
    protected function createResourceFromRepository(Repository $repository)
    {
        $resource = parent::createResourceFromRepository($repository);

        $metadataRepository = $this->level3->getHub()->get('metadata');

        if ($repository === $this || $repository === $metadataRepository) {
            return $resource;
        }

        $link = new Link(sprintf(
            '%s?byKey=%s',
            $metadataRepository->getURI(), $repository->getKey()
        ));

        $resource->setLink('metadata', $link);

        return $resource;
    }
}
