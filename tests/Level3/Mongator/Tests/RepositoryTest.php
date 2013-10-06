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
    const EXAMPLE_URI = 'foo/bar';

    protected function getRepository()
    {
        $mongoId = new \MongoId('4af9f23d8ead0e1d32000000');

        $this->document = $this->createDocumentMock();
        $this->document->shouldReceive('getId')->withNoArgs()
            ->once()
            ->andReturn($mongoId);
        
        $this->docRepository = $this->createDocumentRepositoryMock();
        $this->docRepository
            ->shouldReceive('findById')->with(array(self::VALID_MONGO_ID))
            ->andReturn($this->docRepository);

        $this->docRepository
            ->shouldReceive('one')->withNoArgs()
            ->andReturn($this->document);

        $this->mongator = $this->createMongatorMock();
        $this->mongator
            ->shouldReceive('getRepository')->with('Model\Article')
            ->andReturn($this->docRepository);

        $this->level3 = $this->createLevel3Mock();

        return new ArticleRepository($this->level3, $this->mongator);
    }

    protected function level3ShouldReceiveGetURI()
    {
        $this->level3->shouldReceive('getURI')
            ->with(null, null, m::type('Level3\Resource\Parameters'))->once()
            ->andReturn(self::EXAMPLE_URI);
    }
    
    public function testGet()
    {
        $attributes = $this->createParametersMock();
        $attributes
            ->shouldReceive('get')->with('id')
            ->andReturn(self::VALID_MONGO_ID);

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();
        
        $resource = $repository->get($attributes);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
    }

    public function testPost()
    {
        $atributes = $this->createParametersMock();
        $data = array('foo' => 'bar');

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $this->docRepository
            ->shouldReceive('create')->withNoArgs()->once()
            ->andReturn($this->document);

        $this->document
            ->shouldReceive('fromArray')->with($data)->once()
            ->andReturn(null);

        $this->document
            ->shouldReceive('save')->withNoArgs()->once()
            ->andReturn(null);

        $resource = $repository->post($atributes, $data);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
    }

    public function testPut()
    {
        $atributes = $this->createParametersMock();
        $atributes
            ->shouldReceive('get')->with('id')
            ->andReturn(self::VALID_MONGO_ID);

        $mongoId = new \MongoId(self::VALID_MONGO_ID);
        $expectedData = $data = array('foo' => 'bar');
        $expectedData['id'] = $mongoId;

        $document = $this->createDocumentMock();
        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $this->docRepository
            ->shouldReceive('create')->withNoArgs()->once()
            ->andReturn($document);

        $this->document
            ->shouldReceive('getId')->withNoArgs()->once()
            ->andReturn($mongoId);

        $document
            ->shouldReceive('getId')->withNoArgs()->once()
            ->andReturn($mongoId);
            
        $document
            ->shouldReceive('fromArray')->with($expectedData)->once()
            ->andReturn(null);

        $document
            ->shouldReceive('setIsNew')->with(false)->once()
            ->andReturn(null);

        $document
            ->shouldReceive('save')->withNoArgs()->once()
            ->andReturn(null);

        $resource = $repository->put($atributes, $data);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
    }

    public function testPatch()
    {
        $atributes = $this->createParametersMock();
        $atributes
            ->shouldReceive('get')->with('id')
            ->andReturn(self::VALID_MONGO_ID);

        $mongoId = new \MongoId(self::VALID_MONGO_ID);
        $data = $expectedData = array('foo' => 'bar');
        $data['id'] = $mongoId;

        $repository = $this->getRepository();
        $this->level3ShouldReceiveGetURI();

        $this->document
            ->shouldReceive('fromArray')->with($expectedData)->once()
            ->andReturn(null);

        $this->document
            ->shouldReceive('save')->withNoArgs()->once()
            ->andReturn(null);

        $resource = $repository->patch($atributes, $data);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
    }

    public function testDelete()
    {
        $atributes = $this->createParametersMock();
        $atributes
            ->shouldReceive('get')->with('id')
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

        $query
            ->shouldReceive('all')->withNoArgs()->once()
            ->andReturn(array());

        $this->docRepository
            ->shouldReceive('createQuery')->withNoArgs()->once()
            ->andReturn($query);
 

        $resource = $repository->find($atributes, $filters);

        $this->assertInstanceOf('Rest\ArticleResource', $resource);
    }
}
