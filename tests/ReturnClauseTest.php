<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use QueryBuilder\Clauses\ReturnClause;

class ReturnClauseTest extends TestCase{  

  public function testReturnSingleCondition(){
  	$clause = new ReturnClause();
	$clause->return('person');
	$this->assertEquals('RETURN person', $clause->getClause());
  }

  public function testReturnAttribute(){
  	$clause = new ReturnClause();
	$clause->return('person', 'name');
	$this->assertEquals('RETURN person.name', $clause->getClause());
  }

  public function testMultipleReturns(){
  	$clause = new ReturnClause();
	$clause->return('person', 'name');
	$clause->return('movie');
	$this->assertEquals('RETURN person.name, movie', $clause->getClause());
  }
  
}