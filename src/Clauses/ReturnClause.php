<?php
namespace Moozla\QueryBuilder\Clauses;

class ReturnClause extends Clause{

	protected $clauseName = 'RETURN';

	public function return($variable, $attribute = ''){

		$append = !empty($this->getClause());

		if ($append){
			$this->addToClause(', ');
		}

		if (empty($attribute)){
			$this->addToClause($variable);
		}
		else {
			$this->addToClause($variable.'.'.$attribute);   
		}
	}
}
