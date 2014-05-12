<?php

/*
 * This file is part of Mongator.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Level3\Mongator\Tests;

use Rest\SourceRepository;
use Symfony\Component\HttpFoundation\ParameterBag;
use Mockery as m;

class EmbeddedRepositoryTest extends TestCase
{
    const VALID_MONGO_ID = '4af9f23d8ead0e1d32000000';
    const VALID_MONGO_ID_B = '2af9f23d8ead0e1d32000000';

    const EXAMPLE_URI = 'foo/bar';

    protected function getRepository()
    {

        $this->document = $this->factory->quick('Model\Article', array(
            'id' => new \MongoId(self::VALID_MONGO_ID_B),
            'sources' => array(
                array('id' => new \MongoId(self::VALID_MONGO_ID))
            )
        ));

        $this->docRepository = $this->createDocumentRepositoryMock();
        $this->docRepository
            ->shouldReceive('findById')->with(array(self::VALID_MONGO_ID_B))
            ->andReturn(array($this->document));

        $this->level3 = $this->createLevel3Mock();

        $sourceRepository = new SourceRepository($this->level3, $this->mongator);
        $sourceRepository->setKey('article/sources');

        $articleRepository = m::mock('Rest\ArticleResource');
        $articleRepository->shouldReceive('getDocumentRepository')->withNoArgs()
            ->andReturn($this->docRepository);
        $articleRepository->shouldReceive('doGetDocument')->andReturn($this->document);

        $this->hub = $this->createHubMock();

        $this->hub->shouldReceive('get')->with('sources')
            ->andReturn($sourceRepository);

        $this->hub->shouldReceive('get')->with('article')
            ->andReturn($articleRepository);

        $this->hub->shouldReceive('get');

        $this->level3->shouldReceive('getHub')->withNoArgs()
            ->andReturn($this->hub);

        return $sourceRepository;
    }

    protected function level3ShouldReceiveGetURI()
    {
        $this->level3->shouldReceive('getURI')
            ->with("article/sources", null, m::type('Symfony\Component\HttpFoundation\ParameterBag'))->once()
            ->andReturn(self::EXAMPLE_URI);
    }
    
    public function testGet()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID_B);
        $attributes
            ->shouldReceive('get')->with('sourcesId')
            ->andReturn(self::VALID_MONGO_ID);


        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();
        
        $resource = $repository->get($attributes);

        $this->assertInstanceOf('Rest\SourceResource', $resource);

        $this->assertCount(8, $resource->getData());
    }

    public function testPost()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID_B);

        $data = new ParameterBag(array('name' => 'bar'));

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();


        $resource = $repository->post($attributes, $data);

        $this->assertInstanceOf('Rest\SourceResource', $resource);
        $data = $resource->getData();
        $this->assertCount(8, $data);
        $this->assertSame($data['name'], 'bar');

    }

    public function testPut()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID_B);
        $attributes
            ->shouldReceive('get')->with('sourcesId')
            ->andReturn(self::VALID_MONGO_ID);

        $mongoId = new \MongoId(self::VALID_MONGO_ID);

        $data = $this->createParametersMock();
        $data->shouldReceive('set')
            ->with('id', (string) $mongoId)->once()->andReturn();
        $data->shouldReceive('all')
            ->with()->once()->andReturn([
                'id' => self::VALID_MONGO_ID,
                'name' => 'foo'
            ]);


        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $resource = $repository->put($attributes, $data);

        $this->assertInstanceOf('Rest\SourceResource', $resource);
        $this->assertSame(self::EXAMPLE_URI, $resource->getURI());

        $data = $resource->getData();
        $this->assertCount(8, $data);
        $this->assertSame($data['name'], 'foo');

        $this->document->refresh();
        $this->assertCount(1, $this->document->getSources()->all());
    }

    public function testPatch()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID_B);
        $attributes
            ->shouldReceive('get')->with('sourcesId')
            ->andReturn(self::VALID_MONGO_ID);

        $mongoId = new \MongoId(self::VALID_MONGO_ID);
        $data = $this->createParametersMock();
        $data->shouldReceive('remove')
            ->with('id')->once()->andReturn();
        $data->shouldReceive('all')
            ->with()->once()->andReturn(['name' => 'qux']);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $resource = $repository->patch($attributes, $data);

        $this->assertInstanceOf('Rest\SourceResource', $resource);
        $data = $resource->getData();
        $this->assertCount(8, $data);
        $this->assertSame($data['name'], 'qux');
    }

    public function testDelete()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID_B);
        $attributes
            ->shouldReceive('get')->with('sourcesId')
            ->andReturn(self::VALID_MONGO_ID);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $this->docRepository
            ->shouldReceive('delete')->with($this->document)->once()
            ->andReturn(null);

        $resource = $repository->delete($attributes);

        $this->assertNull($resource);
    }


    public function testFind()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID_B);

        $filters = $this->createParametersMock();
        $filters
            ->shouldReceive('get')->with('range')
            ->andReturn(array(10, 50));
        $filters
            ->shouldReceive('get')->with('sort')
            ->andReturn($sort = array('foo' => 'bar'));
        $filters
            ->shouldReceive('get')->with('criteria')
            ->andReturn(array('qux' => 'baz'));

        $repository = $this->getRepository();

        $query = $this->createQueryMock();
        $query
            ->shouldReceive('findQux')->with('baz')->once()
            ->andReturn($query);
 
        $query
            ->shouldReceive('sort')->with($sort)->once()
            ->andReturn($query);

        $query
            ->shouldReceive('skip')->with(10)->once()
            ->andReturn($query);

        $query
            ->shouldReceive('limit')->with(40)->once()
            ->andReturn($query);

        $document = $this->factory->quick('Model\Article', array(
            'sources' => 3
        ));

        $query
            ->shouldReceive('all')->withNoArgs()->once()
            ->andReturn($document->getSources()->all());

        $this->level3->shouldReceive('getURI')
            ->andReturn('foo');

        $this->docRepository
            ->shouldReceive('createQuery')->withNoArgs()->once()
            ->andReturn($query);

        $resource = $repository->find($attributes, $filters);

        $this->assertInstanceOf('Rest\SourceResource', $resource);

        $resources = $resource->getAllResources();       

        $this->assertCount(1, $resources);
        $this->assertCount(1, $resources['resources']);
        $this->assertInstanceOf('Rest\SourceResource', $resources['resources'][0]);
      
    }
}
