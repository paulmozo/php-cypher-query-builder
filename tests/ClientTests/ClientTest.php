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

	public function testCustomMatch(){
		$client = new Moozla\QueryBuilder\Client();

		$client
		->match('Person', 'person')
		->match('LIKES')
		->match('Movie', 'movie')
		->appendToMatch(' Here Is My Custom Cypher');

		$this->assertEquals('MATCH (person:Person)-[:LIKES]-(movie:Movie) Here Is My Custom Cypher', (string)$client);
	}

	public function testCustomCombination(){
		$client = new Moozla\QueryBuilder\Client();

		$client
		->match('Person', 'person')
		->appendToMatch(' Custom match Cypher')
		->appendToWhere('Custom where Cypher')
		->appendToReturn('Custom return Cypher');

		$this->assertEquals('MATCH (person:Person) Custom match Cypher WHERE Custom where Cypher RETURN Custom return Cypher', (string)$client);
	}

	public function testResetClient(){
		$client = new Moozla\QueryBuilder\Client();

		$client
		->match('Person', 'person')
		->match('LIKES')
		->match('Movie', 'movie')
		->where('movie', 'name', "=", 'Taxi Driver')
		->return('movie');

		$client->reset();

		$client
		->match('Actor', 'a');

		$this->assertEquals('MATCH (a:Actor)', (string)$client);
	}

	public function testMultipleReturns(){
		$client = new Moozla\QueryBuilder\Client();

		$client
		->match('Person', 'person')
		->match('LIKES')
		->match('Movie', 'movie')
		->return('movie')
		->return('person');

		$this->assertEquals('MATCH (person:Person)-[:LIKES]-(movie:Movie) RETURN movie, person', (string)$client);
	}

	public function testSet(){
		$client = new Moozla\QueryBuilder\Client();

		$client
		->match('Person', 'person')
		->match('LIKES')
		->match('Movie', 'movie')
		->set('person', 'age', 29);

		$this->assertEquals('MATCH (person:Person)-[:LIKES]-(movie:Movie) SET person.age = 29', (string)$client);
	}

	public function testSetArray(){
		$client = new Moozla\QueryBuilder\Client();

		$client
		->match('Person', 'person')
		->match('LIKES')
		->match('Movie', 'movie')
		->setArray('person', ['name' => 'Jeff', 'age' => 47]);

		$this->assertEquals('MATCH (person:Person)-[:LIKES]-(movie:Movie) SET person.name = "Jeff", person.age = 47', (string)$client);
	}

	public function testCreate(){
		$client = new Moozla\QueryBuilder\Client();

		$client->create('person', 'Person', ['name' => 'Jeff', 'age' => 47]);

		$this->assertEquals('CREATE (person:Person { name: "Jeff", age: 47 })', (string)$client);
	}

	public function testDelete(){
		$client = new Moozla\QueryBuilder\Client();

		$client
		->match('Person', 'person')
		->match('LIKES')
		->match('Movie', 'movie')
		->delete('movie')
		->delete('person');

		$this->assertEquals('MATCH (person:Person)-[:LIKES]-(movie:Movie) DELETE movie, person', (string)$client);
	}
}