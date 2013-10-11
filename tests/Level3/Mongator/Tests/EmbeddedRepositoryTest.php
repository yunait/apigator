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
            'sources' => [
                ['id' => new \MongoId(self::VALID_MONGO_ID)]
            ]
        ));

        $this->docRepository = $this->createDocumentRepositoryMock();
        $this->docRepository
            ->shouldReceive('findById')->with(array(self::VALID_MONGO_ID_B))
            ->andReturn($this->docRepository);

        $this->docRepository
            ->shouldReceive('one')->withNoArgs()
            ->andReturn($this->document);

        $this->level3 = $this->createLevel3Mock();

        $sourceRepository = new SourceRepository($this->level3, $this->mongator);
        $sourceRepository->setKey('article/sources');

        $articleRepository = m::mock('Rest\ArticleResource');
        $articleRepository->shouldReceive('getDocumentRepository')->withNoArgs()
            ->andReturn($this->docRepository);

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
            ->with("article/sources", null, m::type('Level3\Resource\Parameters'))->once()
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
        $this->assertCount(6, $resource->getData());
    }

    public function testPost()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID_B);

        $data = array('name' => 'bar');

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();


        $resource = $repository->post($attributes, $data);

        $this->assertInstanceOf('Rest\SourceResource', $resource);
        $data = $resource->getData();
        $this->assertCount(6, $data);
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
        $expectedData = $data = array('name' => 'bar');
        $expectedData['id'] = $mongoId;

        $document = $this->factory->quick('Model\Article', array(), false);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $this->docRepository
            ->shouldReceive('create')->withNoArgs()->once()
            ->andReturn($document);

        $resource = $repository->put($attributes, $data);

        $this->assertInstanceOf('Rest\SourceResource', $resource);
        $this->assertSame(self::EXAMPLE_URI, $resource->getURI());

        $data = $resource->getData();
        $this->assertCount(6, $data);
        $this->assertSame($data['name'], 'bar');
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
        $data = $expectedData = array('name' => 'qux');
        $data['id'] = $mongoId;

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $resource = $repository->patch($attributes, $data);

        $this->assertInstanceOf('Rest\SourceResource', $resource);
        $data = $resource->getData();
        $this->assertCount(6, $data);
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

        $resources = $resource->getResources();       

        $this->assertCount(1, $resources);
        $this->assertCount(1, $resources['source']);
        $this->assertInstanceOf('Rest\SourceResource', $resources['source'][0]);
      
    }
}
