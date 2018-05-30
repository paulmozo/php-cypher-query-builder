<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Moozla\QueryBuilder\Clauses\MatchClause;
use Moozla\QueryBuilder\Clauses\WhereClause;
use Moozla\QueryBuilder\Clauses\ReturnClause;

class GenericClauseTest extends TestCase{  


  public function testGetClauseName(){
    $clause = new MatchClause();
    $this->assertEquals('MATCH', $clause->getClauseName());

    $clause = new WhereClause();
    $this->assertEquals('WHERE', $clause->getClauseName());

    $clause = new ReturnClause();
    $this->assertEquals('RETURN', $clause->getClauseName());
  }
  
}