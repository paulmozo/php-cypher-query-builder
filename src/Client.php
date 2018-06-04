<?php namespace Moozla\QueryBuilder;

use Moozla\QueryBuilder\Clauses\MatchClause;
use Moozla\QueryBuilder\Clauses\WhereClause;
use Moozla\QueryBuilder\Clauses\ReturnClause;

/**
*  Query Builder Client
*
*  The client class for interaction with the query builder
*/
class Client{

	private $matchClause;

	private $whereClause;

	private $returnClause;

	private $generatedMethods;

	private $clauses = [];

	public function __construct(){
		$this->reset();
	}

	public function match($label, $variable = ''){
		$this->matchClause->match($label, $variable);
		return $this;
	}

	public function rightMatch($label, $variable = ''){
		$this->matchClause->rightMatch($label, $variable);
		return $this;
	}

	public function leftMatch($label, $variable = ''){
		$this->matchClause->leftMatch($label, $variable);
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

		$this->clauses = [
			$this->matchClause,
			$this->whereClause,
			$this->returnClause
		];

		$this->createCustomAppendMethods();

	}

	/**
	 * Creates a custom append method for each clause at run time
	 */
	private function createCustomAppendMethods(){
		foreach ($this->clauses as $clause){
			$this->createAppendMethod($clause);
		}
	}

	private function createAppendMethod($clause){
		$clauseAttributeString = strtolower($clause->getClauseName()).'Clause';
		$appendFunc = function ($string) use ($clauseAttributeString) {
			$this->$clauseAttributeString->addToClause($string);
			return $this;
		};

		$funcName = 'appendTo'.ucwords(strtolower($clause->getClauseName()));

		$this->generatedMethods[$funcName] = \Closure::bind($appendFunc, $this, get_class());
	}

	function __call($method, $args) {
		if(is_callable($this->generatedMethods[$method])){
			return call_user_func_array($this->generatedMethods[$method], $args);
		}
	}
}