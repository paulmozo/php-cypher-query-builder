<?php
namespace Moozla\QueryBuilder\Clauses;
use Moozla\QueryBuilder\Exceptions\MatchEndingWithRelationshipException;
use Moozla\QueryBuilder\Exceptions\DirectionalMatchOnNodeException;

class MatchClause extends Clause{

	protected $clauseName = 'MATCH';

	protected $relationShipMatch = false;

	public function match($label, $variable = ''){
		if (!$this->relationShipMatch){
			$this->nodeMatch($label, $variable);
		}
		else {
			$this->relationshipMatch($label, $variable);	
		}
		$this->relationShipMatch = !$this->relationShipMatch;
	}

	private function nodeMatch($label, $variable){
		$this->addToClause("($variable:$label)");
	}

	private function relationshipMatch($label, $variable){
		$this->addToClause("-[$variable:$label]-");
	}

	public function leftMatch($label, $variable = ''){
		if (!$this->relationShipMatch){
			throw new DirectionalMatchOnNodeException('Directional matches must be made on relationships not nodes');
		}
		$this->addToClause('<');
		$this->relationshipMatch($label, $variable);
		$this->relationShipMatch = !$this->relationShipMatch;
	}

	public function rightMatch($label, $variable = ''){
		if (!$this->relationShipMatch){
			throw new DirectionalMatchOnNodeException('Directional matches must be made on relationships not nodes');
		}
		$this->relationshipMatch($label, $variable);
		$this->addToClause('>');
		$this->relationShipMatch = !$this->relationShipMatch;
	}

	public function getClause(){
		if (!$this->relationShipMatch){
			throw new MatchEndingWithRelationshipException('Match clauses cannot end with a relationship match. ');
		}
		return $this->clause;
	}
}
