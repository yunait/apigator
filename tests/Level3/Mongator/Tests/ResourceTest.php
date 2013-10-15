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
use MongoId;
use DateTime;

class ResourceTest extends TestCase
{
    const VALID_MONGO_ID = '4af9f23d8ead0e1d32000000';
    const VALID_ISO_DATE = '2005-08-15T15:52:01+0000';
    const INVALID_MONGO_ID = 'foo';
    const INVALID_ISO_DATE = 'bar';

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

        $categories = $document->getCategories();
        $this->assertSame((string) $categories->one()->getId(), $links['categories'][0]->getName());

    }

    public function testFormatToDocument()
    {
        $data = array(
            'id' => self::VALID_MONGO_ID,
            'date' => self::VALID_ISO_DATE,
            'source' => array(
                'id' => self::VALID_MONGO_ID,
            ),
            'comments' => array(
                array('date' => self::VALID_ISO_DATE),
                array('date' => self::VALID_ISO_DATE)
            ),
            'author' => self::VALID_MONGO_ID,
            'categories' => array(
                self::VALID_MONGO_ID,
                self::VALID_MONGO_ID
            )
        );

        $result = ArticleResource::formatToDocument($data);
        $this->assertInstanceOf('MongoId', $result['id']);
        $this->assertSame(self::VALID_MONGO_ID, (string) $result['id']);

        $this->assertInstanceOf('DateTime', $result['date']);
        $this->assertSame(self::VALID_ISO_DATE, $result['date']->format(DateTime::ISO8601));

        $this->assertInstanceOf('MongoId', $result['source']['id']);
        $this->assertSame(self::VALID_MONGO_ID, (string) $result['source']['id']);

        $this->assertInstanceOf('DateTime', $result['comments'][0]['date']);
        $this->assertSame(self::VALID_ISO_DATE, $result['comments'][0]['date']->format(DateTime::ISO8601));

        $this->assertInstanceOf('DateTime', $result['comments'][1]['date']);
        $this->assertSame(self::VALID_ISO_DATE, $result['comments'][1]['date']->format(DateTime::ISO8601));
        
        $this->assertFalse(isset($result['author']));
        $this->assertInstanceOf('MongoId', $result['author_reference_field']);
        $this->assertSame(self::VALID_MONGO_ID, (string) $result['author_reference_field']);

        $this->assertFalse(isset($result['categories']));
        $this->assertInstanceOf('MongoId', $result['categories_reference_field'][0]);
        $this->assertSame(self::VALID_MONGO_ID, (string) $result['categories_reference_field'][0]);
        $this->assertInstanceOf('MongoId', $result['categories_reference_field'][1]);
        $this->assertSame(self::VALID_MONGO_ID, (string) $result['categories_reference_field'][1]);
    }

    /**
     * @expectedException Level3\Exceptions\BadRequest
     */
    public function testFormatToDocumentInvalidId()
    {
        $data = array(
            'id' => self::INVALID_MONGO_ID
        );

        $result = ArticleResource::formatToDocument($data);
    }

    /**
     * @expectedException Level3\Exceptions\BadRequest
     */
    public function testFormatToDocumentInvalidDate()
    {
        $data = array(
            'date' => self::INVALID_ISO_DATE
        );

        $result = ArticleResource::formatToDocument($data);
    }

    /**
     * @expectedException Level3\Exceptions\BadRequest
     */
    public function testFormatToDocumentInvalidEmbedded()
    {
        $data = array(
            'source' => ''
        );

        $result = ArticleResource::formatToDocument($data);
    }

    /**
     * @expectedException Level3\Exceptions\BadRequest
     */
    public function testFormatToDocumentInvalidEmbeddedMany()
    {
        $data = array(
            'comments' => Array('')
        );

        $result = ArticleResource::formatToDocument($data);
    }

    /**
     * @expectedException Level3\Exceptions\BadRequest
     */
    public function testFormatToDocumentInvalidReference()
    {
        $data = array(
            'author' => self::INVALID_MONGO_ID,
        );

        $result = ArticleResource::formatToDocument($data);
    }

    /**
     * @expectedException Level3\Exceptions\BadRequest
     */
    public function testFormatToDocumentInvalidReferenceMany()
    {
        $data = array(
            'categories' => Array(
                self::INVALID_MONGO_ID,
            )
        );

        $result = ArticleResource::formatToDocument($data);
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
