<?php
namespace QueryBuilder\Clauses;
use QueryBuilder\Exceptions\MatchEndingWithRelationshipException;

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

    public function getClause(){
    	if (!$this->relationShipMatch){
    		throw new MatchEndingWithRelationshipException('Match clauses cannot end with a relationship match. ');
    	}
        return $this->clause;
    }
}