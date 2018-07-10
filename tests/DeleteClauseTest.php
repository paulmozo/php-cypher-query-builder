<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Moozla\QueryBuilder\Clauses\DeleteClause;

class DeleteClauseTest extends TestCase{  

	public function testDelete(){
		$clause = new DeleteClause();
		$clause->delete('person');
		$this->assertEquals('DELETE person', $clause->getClause());
	}

	public function testMultiple(){
		$clause = new DeleteClause();
		$clause->delete('person');
		$clause->delete('movie');
		$this->assertEquals('DELETE person, movie', $clause->getClause());
	}
}