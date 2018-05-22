<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase{  


  public function testMatchSingleNode(){
	 $client = new QueryBuilder\Client();
   $client->match->match('Person');
	 $this->assertTrue((string)$clause == 'MATCH (:Person)');
  }

  public function testComplexQuery(){
    $client = new QueryBuilder\Client();

    $client
      ->match('Person', 'person')
      ->match('LIKES')
      ->match('Movie', 'movie')
      ->whereEquals('movie', 'name', 'Taxi Driver')
      ->return('movie');

    $this->assertEquals('MATCH (person:Person)-[:LIKES]-(movie:Movie) WHERE movie.name="Taxi Driver" RETURN movie', (string)$client);
  }
}