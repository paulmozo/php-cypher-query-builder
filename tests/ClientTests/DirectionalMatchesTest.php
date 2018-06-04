<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class DirectionalMatchesTest extends TestCase{  

	public function testRightMatch(){
		$client = new Moozla\QueryBuilder\Client();
		$client
			->match('Person')
			->rightMatch('LIKES')
			->match('Movie');
		$this->assertEquals('MATCH (:Person)-[:LIKES]->(:Movie)', (string)$client);
	}

	public function testLeftMatch(){
		$client = new Moozla\QueryBuilder\Client();
		$client
			->match('Movie')
			->leftMatch('LIKES')
			->match('Person');
		$this->assertEquals('MATCH (:Movie)<-[:LIKES]-(:Person)', (string)$client);
	}
}