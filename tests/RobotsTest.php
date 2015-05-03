<?php

class MateriaTest extends PHPUnit_Framework_TestCase {
    protected $client;
    
    protected function setUp(){
        $this->client = new GuzzleHttp\Client(array(
            "base_url"  => "https://phalcon-rest-travis-vytorcalixto.c9.io",
            "defaults"  => ["exceptions" => false]
        ));
    }
    
    public function testGetAllRobots(){
        $response = $this->client->get("/api/robots");
        
        $this->assertEquals(200, $response->getStatusCode());
        
        var_dump($response);
        var_dump($response->getBody());
        
        $data = $response->json();
        $this->assertInternalType('array', $data);
        $this->assertEquals(6, count($data));
    }
    
    public function testGetRobotId1(){
        $response = $this->client->get("/api/robots/1");
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $data = $response->json();
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('FOUND', $data['status']);
        $this->assertArrayHasKey('data', $data);
        $robot = $data['data'];
        $this->assertEquals('R2-D2', $robot['name']);
    }
    
    public function testGetNonexistingRobot(){
        $response = $this->client->get("/api/robots/0");
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $data = $response->json();
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('NOT-FOUND', $data['status']);
    }
    
    public function testSearchRobotT(){
        $response = $this->client->get("/api/robots/search/t");
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $data = $response->json();
        
        $this->assertInternalType('array', $data);
        $this->assertEquals(3, count($data));
    }
    
    public function testCreateRobot(){
        $robot = array(
            "name"  => "bb-8", 
            "type"  => "droid",
            "year"  => 2015
        );
        $response = $this->client->post("/api/robots/", [
            "json" => $robot
        ]);
        
        $this->assertEquals(201, $response->getStatusCode());
        $data = $response->json();
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('OK', $data['status']);
        $this->assertArrayHasKey('data', $data);
        $this->assertEquals($robot['name'], $data['data']['name']);
        $this->assertEquals($robot['type'], $data['data']['type']);
        $this->assertEquals($robot['year'], $data['data']['year']);
    }
    
    public function testUpdateRobot(){
        $lastId = end($this->client->get("/api/robots")->json())['id'];
        $robot = array(
            "id"    => $lastId,
            "name"  => "bb-800", 
            "type"  => "droid",
            "year"  => 2015
        );
        $response = $this->client->put("/api/robots/".$lastId, array(
            "json" => $robot
        ));
        
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->json();
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('OK', $data['status']);
    }
    
    public function testUpdateNonexistingRobot(){
        $robot = array(
            "id"    => 0,
            "name"  => "bb-800", 
            "type"  => "droid",
            "year"  => 2015
        );
        $response = $this->client->put("/api/robots/0", array(
            "json" => $robot
        ));
        
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->json();
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('OK', $data['status']);
    }
    
    public function testDeleteRobot(){
        $lastId = end($this->client->get("/api/robots")->json())['id'];
        $response = $this->client->delete("/api/robots/".$lastId);
        
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->json();
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('OK', $data['status']);
    }
    
    public function testDeleteNonexistingRobot(){
        $response = $this->client->delete("/api/robots/0");
        
        $this->assertEquals(200, $response->getStatusCode());
        $data = $response->json();
        
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals('OK', $data['status']);
    }
}
?>