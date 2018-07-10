<?php
namespace Moozla\QueryBuilder\Clauses;

class DeleteClause extends Clause{

	protected $clauseName = 'DELETE';

	public function delete($variable){
		if (!empty($this->getClause())){
			$this->addToClause(", ");
		}
		$this->addToClause("$variable");
	}
}
