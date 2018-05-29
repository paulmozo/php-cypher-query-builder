<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Moozla\QueryBuilder\Clauses\MatchClause;
use Moozla\QueryBuilder\Exceptions\MatchEndingWithRelationshipException;

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
  
}