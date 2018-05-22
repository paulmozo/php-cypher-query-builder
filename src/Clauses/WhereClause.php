<?php
namespace QueryBuilder\Clauses;

class WhereClause extends Clause
{
	protected $clauseName = 'WHERE';

    public function where($variable, $attribute, $operator, $value, $or = false)
    {
    	$append = !empty($this->getClause());

    	if ($append){
    		$this->appendAndOr($or);
    	}

    	switch ($operator) {
    		case "=":
        		$this->equals($variable, $attribute, $value);
        		break;
        	default:
        		throw new UnsupportedOperator("$operator is not supported as an operator");
        }
    }

    private function equals($variable, $attribute, $value)
    {
    	$this->addToClause("$variable.$attribute = \"$value\"");
    }

    /**
     * Appends an "AND" or an "OR"
     */
    private function appendAndOr($appendOr)
    {
    	$stringToAppend = ($appendOr ? "OR" : "AND");
    	$this->addToClause(" $stringToAppend ");
    }
}