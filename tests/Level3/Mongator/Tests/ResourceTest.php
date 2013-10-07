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

class ResourceTest extends TestCase
{
    protected function createResource()
    {
        $this->hub = $this->createHubMock();
        $this->hub->shouldReceive('get');
        
        $this->level3 = $this->createLevel3Mock();
        $this->level3 = $this->createLevel3Mock();
        $this->level3->shouldReceive('getHub')->withNoArgs()
            ->andReturn($this->hub);

        return new ArticleResource($this->level3);
    }

    public function testFromDocument()
    {
        $resource = $this->createResource();
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
}
