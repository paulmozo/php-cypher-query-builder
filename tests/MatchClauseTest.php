<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Moozla\QueryBuilder\Clauses\MatchClause;
use Moozla\QueryBuilder\Exceptions\MatchEndingWithRelationshipException;
use Moozla\QueryBuilder\Exceptions\DirectionalMatchOnNodeException;

class MatchClauseTest extends TestCase{  


	public function testMatchSingleNode(){
		$clause = new MatchClause();
		$clause->match('Person');
		$this->assertEquals('MATCH (:Person)', $clause->getClause());
	}

	public function testMatchTwoNodesAndRelationship(){
		$clause = new MatchClause();
		$clause->match('Person');
		$clause->match('LIKES');
		$clause->match('Movie');
		$this->assertEquals('MATCH (:Person)-[:LIKES]-(:Movie)', $clause->getClause());
	}

	public function testMatchEndingWithRelationshipException(){
		$clause = new MatchClause();
		$clause->match('Person');
		$clause->match('LIKES');
		$this->expectException(MatchEndingWithRelationshipException::class);
		$clause->getClause();
	}

	public function testRightmatch(){
		$clause = new MatchClause();
		$clause->match('Person');
		$clause->rightMatch('LIKES');
		$clause->match('Movie');
		$this->assertEquals('MATCH (:Person)-[:LIKES]->(:Movie)', $clause->getClause());
	}

	public function testLeftmatch(){
		$clause = new MatchClause();
		$clause->match('Movie');
		$clause->leftMatch('LIKES');
		$clause->match('Person');
		$this->assertEquals('MATCH (:Movie)<-[:LIKES]-(:Person)', $clause->getClause());
	}

	public function testRightMatchOnNode(){
		$clause = new MatchClause();
		$this->expectException(DirectionalMatchOnNodeException::class);
		$clause->rightMatch('Person');
	}

	public function testLeftMatchOnNode(){
		$clause = new MatchClause();
		$this->expectException(DirectionalMatchOnNodeException::class);
		$clause->rightMatch('Person');
	}

	public function testMultiMatch(){
		$clause = new MatchClause();
		$clause->match('Person', 'person');
		$clause->end();
		$clause->match('Movie', 'movie');
		$this->assertEquals('MATCH (person:Person) MATCH (movie:Movie)', $clause->getClause());
	}
}