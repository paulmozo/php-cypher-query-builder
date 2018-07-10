<?php
namespace Moozla\QueryBuilder\Clauses;
use Moozla\QueryBuilder\Exceptions\PropertyTypeException;

class CreateClause extends Clause{

	protected $clauseName = 'CREATE';

	public function create($variable, $label, $properties = []){
		if (!empty($this->getClause())){
			$this->addToClause(", ");
		}

		if (!empty($properties)){
			$this->addToClause("($variable:$label ".$this->getPropertyString($properties).")");	
		}
		else {
			$this->addToClause("($variable:$label)");
		}
	}

	private function getPropertyString($properties){
		$return = [];
		foreach ($properties as $key => $value){
			if (gettype($value) == 'string'){
				$return[] = "$key: \"$value\"";
			}
			elseif (gettype($value) == 'integer' || gettype($value) == 'double'){
				$return[] = "$key: $value";
			}
			else {
				throw new PropertyTypeException("Properties can not be set to type of ".gettype($value));
			}
		}
		return '{ '.implode($return, ', ').' }';
	}
}
