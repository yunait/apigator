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

use Rest\ArticleRepository;
use Mockery as m;

class RepositoryTest extends TestCase
{
    const VALID_MONGO_ID = '4af9f23d8ead0e1d32000000';
    const VALID_ISO_DATE = '2005-08-15T15:52:01+0000';

    const EXAMPLE_URI = 'foo/bar';

    protected function getRepository()
    {
        $mongoId = new \MongoId('4af9f23d8ead0e1d32000000');

        $this->document = $this->factory->quick('Model\Article', array(
            'id' => $mongoId,
            'author',
            'categories' => 2
        ));

        $this->docRepository = $this->createDocumentRepositoryMock();
        $this->docRepository
            ->shouldReceive('findById')->with(array(self::VALID_MONGO_ID))
            ->andReturn(array($this->document));

        $this->mongator = $this->createMongatorMock();
        $this->mongator
            ->shouldReceive('getRepository')->with('Model\Article')
            ->andReturn($this->docRepository);

        $this->level3 = $this->createLevel3Mock();

        $repository = new ArticleRepository($this->level3, $this->mongator);
        $repository->setKey('article');

        $this->hub = $this->createHubMock();
        $this->hub->shouldReceive('get')
            ->andReturn($repository);

        $this->level3->shouldReceive('getHub')->withNoArgs()
            ->andReturn($this->hub);

        return $repository;
    }

    protected function level3ShouldReceiveGetURI()
    {
        $this->level3->shouldReceive('getURI')
            ->with('article', null, m::type('Symfony\Component\HttpFoundation\ParameterBag'))->once()
            ->andReturn(self::EXAMPLE_URI);
    }
    
    public function testGet()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();
        
        $resource = $repository->get($attributes);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
    }

    public function testPost()
    {
        $atributes = $this->createParametersMock();
        $data = array('date' => self::VALID_ISO_DATE);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $document = $this->createDocumentMock();
        $document->shouldReceive('getId')->withNoArgs()
            ->once()
            ->andReturn(new \MongoId(self::VALID_MONGO_ID));

        $this->docRepository
            ->shouldReceive('create')->withNoArgs()->once()
            ->andReturn($this->document);

        $data = $this->createParametersMock();
        $data->shouldReceive('set')
            ->with('id', (string) $document->getId())->once()->andReturn();
        $data->shouldReceive('all')
            ->with()->once()->andReturn(['date' => self::VALID_ISO_DATE]);

        $resource = $repository->post($atributes, $data);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
        $data = $resource->getData();       

        $this->assertCount(14, $data);
        $this->assertInstanceOf('DateTime', $this->document->getDate());

    }

    public function testPut()
    {
        $atributes = $this->createParametersMock();
        $atributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID);

        $mongoId = new \MongoId(self::VALID_MONGO_ID);
        
        $document = $this->factory->quick('Model\Article', array(), false);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();
        
        $data = $this->createParametersMock();
        $data->shouldReceive('set')
            ->with('id', (string) $this->document->getId())->once()->andReturn();
        $data->shouldReceive('all')
            ->with()->once()->andReturn(['date' => self::VALID_ISO_DATE]);

        $this->docRepository
            ->shouldReceive('create')->withNoArgs()->once()
            ->andReturn($document);

        $resource = $repository->put($atributes, $data);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
        $this->assertSame(self::EXAMPLE_URI, $resource->getURI());

        $data = $resource->getData();
        $this->assertCount(14, $data);
        $this->assertInstanceOf('DateTime', $document->getDate());
    }

    public function testPatch()
    {
        $atributes = $this->createParametersMock();
        $atributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID);

        $mongoId = new \MongoId(self::VALID_MONGO_ID);
        
        $data = $this->createParametersMock();
        $data->shouldReceive('remove')
            ->with('id')->once()->andReturn();
        $data->shouldReceive('all')
            ->with()->once()->andReturn(['date' => self::VALID_ISO_DATE]);


        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $resource = $repository->patch($atributes, $data);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
        
        $data = $resource->getData();
        $this->assertCount(14, $data);
        $this->assertInstanceOf('DateTime', $this->document->getDate());
    }

    public function testDelete()
    {
        $atributes = $this->createParametersMock();
        $atributes
            ->shouldReceive('get')->with('articleId')
            ->andReturn(self::VALID_MONGO_ID);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $this->docRepository
            ->shouldReceive('delete')->with($this->document)->once()
            ->andReturn(null);

        $resource = $repository->delete($atributes);

        $this->assertNull($resource);
    }

    public function testFind()
    {
        $atributes = $this->createParametersMock();
        $atributes
            ->shouldReceive('get')->with('_limit')
            ->andReturn(40);
        $atributes
            ->shouldReceive('get')->with('_offset')
            ->andReturn(10);
        $atributes
            ->shouldReceive('get')->with('_sort')
            ->andReturn($sort = array('foo' => 'bar'));
        $atributes
            ->shouldReceive('get')->with('_criteria')
            ->andReturn(array('qux' => 'baz'));

        $filters = $this->createParametersMock();
        $filters
            ->shouldReceive('all')->with()->once()
            ->andReturn([]);


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

        $query
            ->shouldReceive('all')->withNoArgs()->once()
            ->andReturn(array(
                $this->factory->create('Article'),
                $this->factory->create('Article'),
                $this->factory->create('Article')
            ));

        $this->level3->shouldReceive('getURI')
            ->andReturn('foo');

        $this->docRepository
            ->shouldReceive('createQuery')->withNoArgs()->once()
            ->andReturn($query);

        $resource = $repository->find($atributes, $filters);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);

        $resources = $resource->getAllResources();
        $this->assertCount(1, $resources);
        $this->assertCount(3, $resources['resources']);
        $this->assertInstanceOf('Rest\ArticleResource', $resources['resources'][0]);
        $this->assertInstanceOf('Rest\ArticleResource', $resources['resources'][1]);
        $this->assertInstanceOf('Rest\ArticleResource', $resources['resources'][2]);
    }
}
