<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use QueryBuilder\Clauses\WhereClause;

class WhereClauseTest extends TestCase{  

  public function testEmptyWhere(){
    $clause = new WhereClause();
	$this->assertEmpty($clause->getClause());
  }

  public function testWhereSingleCondition(){
  	$clause = new WhereClause();
	$clause->where('person', 'name', '=', 'TestMan');
	$this->assertEquals('WHERE person.name = "TestMan"', $clause->getClause());
  }

  public function testWhereMultipleConditions(){
  	$clause = new WhereClause();
	$clause->where('person', 'name', '=', 'TestMan');
	$clause->where('movie', 'genre', '=', 'Noir');
	$this->assertEquals('WHERE person.name = "TestMan" AND movie.genre = "Noir"', $clause->getClause());
  }

  public function testWhereMultipleConditionsWithOr(){
  	$clause = new WhereClause();
	$clause->where('person', 'name', '=', 'TestMan');
	$clause->where('movie', 'genre', '=', 'Noir', true);
	$this->assertEquals('WHERE person.name = "TestMan" OR movie.genre = "Noir"', $clause->getClause());
  }
  
}