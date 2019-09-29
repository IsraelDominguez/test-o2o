<?php

namespace App\Tests\Infrastructure\Utils;

use App\Infrastructure\Utils\QueryBuilderTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QueryBuilderTest extends WebTestCase
{
    use QueryBuilderTrait;

    public function testAppendQuery() {
        $this->assertEquals('url?p=value', $this->appendQuery('url', ['p'=>'value']));
        $this->assertEquals('url?p=value&p2=value2', $this->appendQuery('url', ['p'=>'value', 'p2'=>'value2']));
        $this->assertEquals('url', $this->appendQuery('url', []));
    }
}