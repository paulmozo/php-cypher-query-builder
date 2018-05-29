<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase{  

  public function testMatchSingleNode(){
	$client = new Moozla\QueryBuilder\Client();
	$client->match('Person');
	$this->assertEquals('MATCH (:Person)', (string)$client);
  }

  public function testComplexQuery(){
    $client = new Moozla\QueryBuilder\Client();

    $client
      ->match('Person', 'person')
      ->match('LIKES')
      ->match('Movie', 'movie')
      ->where('movie', 'name', "=", 'Taxi Driver')
      ->return('movie');

    $this->assertEquals('MATCH (person:Person)-[:LIKES]-(movie:Movie) WHERE movie.name = "Taxi Driver" RETURN movie', (string)$client);
  }
}