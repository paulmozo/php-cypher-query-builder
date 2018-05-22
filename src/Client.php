<?php namespace QueryBuilder;

use QueryBuilder\Clauses\MatchClause;
use QueryBuilder\Clauses\WhereClause;
use QueryBuilder\Clauses\ReturnClause;

/**
*  Query Builder Client
*
*  The client class for interaction with the query builder
*/
class Client{

	private $matchClause;

	private $whereClause;

	private $returnClause;

	private $clauses = [];

	public function __construct(){
		$this->reset();

		$this->clauses = [
			$this->matchClause,
			$this->whereClause,
			$this->returnClause
		];
	}

	public function match($label, $variable = ''){
		$this->matchClause->match($label, $variable);
		return $this;
	}

	public function where($variable, $attribute, $operator, $value, $or = false){
		$this->whereClause->where($variable, $attribute, $operator, $value, $or = false);
		return $this;
	}

	public function return($variable, $attribute = ''){
		$this->returnClause->return($variable, $attribute);
		return $this;
	}

	public function __toString(){
		$clauseStrings = [];

		foreach ($this->clauses as $clause){
			if (!empty($clause->getClause())){
				$clauseStrings[] = $clause->getClause();	
			}
		}
		return implode(' ', $clauseStrings);
	}

	public function reset(){
		$this->matchClause = new MatchClause;
		$this->whereClause = new WhereClause;
		$this->returnClause = new ReturnClause;
	}
}