<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Moozla\QueryBuilder\Clauses\SetClause;
use Moozla\QueryBuilder\Exceptions\PropertyTypeException;

class SetClauseTest extends TestCase{  

	public function testSetSingleProperty(){
		$clause = new SetClause();
		$clause->set('person', 'name', 'Jeff');
		$this->assertEquals('SET person.name = "Jeff"', $clause->getClause());
	}

	public function testMultipleSets(){
		$clause = new SetClause();
		$clause->set('person', 'name', 'Jeff');
		$clause->set('person', 'age', 47);
		$this->assertEquals('SET person.name = "Jeff", person.age = 47', $clause->getClause());
	}

	public function testMultipleReturns(){
		$clause = new SetClause();
		$this->expectException(PropertyTypeException::class);
		$clause->set('person', 'name', ['array' => 'This will cause an exception']);
	}
	
}