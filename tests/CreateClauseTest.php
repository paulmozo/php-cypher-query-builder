<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Moozla\QueryBuilder\Clauses\CreateClause;
use Moozla\QueryBuilder\Exceptions\PropertyTypeException;

class CreateClauseTest extends TestCase{  

	public function testCreateNoProperties(){
		$clause = new CreateClause();
		$clause->create('person', 'Person');
		$this->assertEquals('CREATE (person:Person)', $clause->getClause());
	}

	public function testMultipleProperties(){
		$clause = new CreateClause();
		$clause->create('person', 'Person', ['name' => 'Jeff', 'age' => 47]);
		$this->assertEquals('CREATE (person:Person { name: "Jeff", age: 47 })', $clause->getClause());
	}

	public function testException(){
		$clause = new CreateClause();
		$this->expectException(PropertyTypeException::class);
		$clause->create('person', 'name', ['array' => ['This will cause an exception']]);
	}
	
}