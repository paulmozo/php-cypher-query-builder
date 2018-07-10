<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Moozla\QueryBuilder\Clauses\MatchClause;
use Moozla\QueryBuilder\Clauses\WhereClause;
use Moozla\QueryBuilder\Clauses\ReturnClause;
use Moozla\QueryBuilder\Clauses\SetClause;
use Moozla\QueryBuilder\Clauses\CreateClause;
use Moozla\QueryBuilder\Clauses\DeleteClause;

class GenericClauseTest extends TestCase{  


  public function testGetClauseName(){
    $clause = new MatchClause();
    $this->assertEquals('MATCH', $clause->getClauseName());

    $clause = new WhereClause();
    $this->assertEquals('WHERE', $clause->getClauseName());

    $clause = new ReturnClause();
    $this->assertEquals('RETURN', $clause->getClauseName());

    $clause = new SetClause();
    $this->assertEquals('SET', $clause->getClauseName());

    $clause = new CreateClause();
    $this->assertEquals('CREATE', $clause->getClauseName());

    $clause = new DeleteClause();
    $this->assertEquals('DELETE', $clause->getClauseName());
  }
  
}