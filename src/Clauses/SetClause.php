<?php
namespace Moozla\QueryBuilder\Clauses;
use Moozla\QueryBuilder\Exceptions\PropertyTypeException;

class SetClause extends Clause{

	protected $clauseName = 'SET';

	public function set($variable, $property, $value){
		if (!empty($this->getClause())){
			$this->addToClause(", ");
		}
		$this->addToClause($this->updateProperty($variable, $property, $value));
	}

	public function setArray($variable, $setArray){
		$this->addToClause($this->updateFromArray($variable, $setArray));
	}

	private function updateFromArray($variableName, $array){
		$return = [];

		foreach ($array as $key => $val){
			$return[] = $this->updateProperty($variableName, $key, $val);
		}
		return implode($return, ', ');
	}

	private function updateProperty($variableName, $key, $val){
		if (gettype($val) == 'string'){
			return "$variableName.$key = \"$val\"";
		}
		elseif (gettype($val) == 'integer' || gettype($val) == 'double'){
			return "$variableName.$key = $val";
		}
		else {
			throw new PropertyTypeException("Properties can not be set to type of ".gettype($val));
		}
	}
}
