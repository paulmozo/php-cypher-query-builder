<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class MultiMatchTest extends TestCase{  

	public function testMatchSingleNode(){
		$client = new Moozla\QueryBuilder\Client();
		$client
			->match('Person', 'person')
			->endMatch()
			->match('Movie', 'movie')
			->match('DIRECTED_BY')
			->match('Director', 'director')
			->where('director', 'name', '=', 'Ms Director')
			->return('movie')
			->return('person');

		$this->assertEquals('MATCH (person:Person) MATCH (movie:Movie)-[:DIRECTED_BY]-(director:Director) WHERE director.name = "Ms Director" RETURN movie, person', (string)$client);
	}

	public function testMatchThreeUnconnectedNodes(){
		$client = new Moozla\QueryBuilder\Client();
		$client
			->match('Person', 'person')
			->endMatch()
			->match('Director', 'director')
			->endMatch()
			->match('Actor', 'actor')
			->return('person')
			->return('director')
			->return('actor');

		$this->assertEquals('MATCH (person:Person) MATCH (director:Director) MATCH (actor:Actor) RETURN person, director, actor', (string)$client);
	}
}