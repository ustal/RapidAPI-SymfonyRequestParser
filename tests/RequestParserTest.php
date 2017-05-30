<?php

/**
 * Created by PhpStorm.
 * User: George Cherenkov
 * Date: 30.05.17
 * Time: 15:29
 */

namespace RapidAPI\Tests;

use PHPUnit\Framework\TestCase;
use RapidAPI\Service\RequestParser;
use Symfony\Component\HttpFoundation\Request;

class RequestParserTest extends TestCase
{
    /** @var RequestParser */
    private $parser;

    public function setUp()
    {
        $method = "post";
        $url = "http://localhost/api/testBlock1";
        $body = $this->getData();
        $request = Request::create($url, $method, $body);
        $this->parser = new RequestParser($request);
    }

    public function test() {
        $data = $this->parser->getParams();
        $this->assertTrue($this->getData() == $data);
    }

    private function getData() {
        return [
            "accessToken" => "asd",
            "json" => [
                [
                    "test" => "test"
                ],
                [
                    "test3" => [
                        "test4" => "test5"
                    ]
                ]
            ]
        ];
    }
}