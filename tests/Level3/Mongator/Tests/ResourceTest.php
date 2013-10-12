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

use Rest\ArticleResource;
use Mockery as m;

use Level3\Formatter\JsonFormatter;

class ResourceTest extends TestCase
{
    protected function createResource()
    {
        $this->hub = $this->createHubMock();
        
        $this->level3 = $this->createLevel3Mock();
        $this->level3 = $this->createLevel3Mock();
        $this->level3->shouldReceive('getHub')->withNoArgs()
            ->andReturn($this->hub);

        return new ArticleResource($this->level3);
    }

    public function testFromDocumentData()
    {
        $resource = $this->createResource();
        $this->hub->shouldReceive('get');

        $document = $this->factory->create('Article');

        $resource->fromDocument($document);

        $data = $resource->getData();
        $this->assertSame((string) $document->getId(), $data['id']); 

        $this->assertSame($document->getTitle(), $data['title']); 
        $this->assertSame($document->getContent(), $data['content']); 
        $this->assertSame($document->getNote(), $data['note']); 
        $this->assertSame($document->getLine(), $data['line']); 
        $this->assertSame($document->getText(), $data['text']); 

        $this->assertSame($document->getDate()->format(\DateTime::ISO8601), $data['date']); 
        $this->assertSame($document->getIsActive(), $data['isActive']); 
    }

    public function testFromDocumentResources()
    {
        $document = $this->factory->create('ArticleWithEmbeddeds');
        $resource = $this->createResource();
        $expected = new \Rest\SourceResource($this->level3);

        $repository = $this->createRepositoryMock();
        $repository->shouldReceive('createDocumentResource')
            ->with(m::type('Model\Source'))->andReturn($expected);

        $this->hub->shouldReceive('get')
            ->with('article/source')->andReturn($repository);
        $this->hub->shouldReceive('get')
            ->with('category')->andReturn($repository);


        $resource->fromDocument($document);

        $resources = $resource->getResources();
        $this->assertCount(3, $resources);
        $this->assertCount(1, $resources['source']);
        $this->assertSame($expected, $resources['source'][0]);

        $this->assertCount(1, $resources['simpleEmbedded']);
        $this->assertInstanceOf('Rest\SimpleEmbeddedResource', $resources['simpleEmbedded'][0]);

        $this->assertCount(2, $resources['comments']);
        $this->assertInstanceOf('Rest\CommentResource', $resources['comments'][0]);
        $this->assertInstanceOf('Rest\CommentResource', $resources['comments'][1]);
    }

    public function testFromDocumentLinks()
    {
        $document = $this->factory->create('ArticleWithReferences');
        $expected = $this->createResourceMock();
        $resource = $this->createResource();

        $repository = $this->createRepositoryMock();
        $repository->shouldReceive('getDocumentURI')
            ->with(m::type('Model\Author'))->andReturn('author/foo');
        $repository->shouldReceive('getDocumentURI')
            ->with(m::type('Model\Category'))->andReturn('category/foo');
        $repository->shouldReceive('getDocumentURI')
            ->with(m::type('Model\ArticleInformation'))->andReturn('information/foo');


        $this->hub->shouldReceive('get')
            ->with('author')->andReturn($repository);
        $this->hub->shouldReceive('get')
            ->with('article_information')->andReturn($repository);
        $this->hub->shouldReceive('get')
            ->with('category')->andReturn($repository);

        $resource->fromDocument($document);

        $links = $resource->getLinks();

        $this->assertCount(3, $links);
        $this->assertCount(1, $links['author']);
        $this->assertSame('author/foo', $links['author'][0]->getHref());

        $this->assertCount(1, $links['information']);
        $this->assertSame('information/foo', $links['information'][0]->getHref());

        $this->assertCount(2, $links['categories']);
        $this->assertSame('category/foo', $links['categories'][0]->getHref());
        $this->assertSame('category/foo', $links['categories'][1]->getHref());
    }

    protected function defineFactoryDefaults()
    {
        $this->factory->define('Article', 'Model\Article', array(
            'title', 'content', 'note', 'line', 'text', 'isActive', 'date'
        ));

        $this->factory->define('ArticleWithEmbeddeds', 'Model\Article', array(
            'source' => array('name' => 1, 'author', 'categories' => 2), 'simpleEmbedded',
            'comments' => 2
        ));

        $this->factory->define('ArticleWithReferences', 'Model\Article', array(
            'author', 'information',
            'categories' => 2
        ));
    }
}
