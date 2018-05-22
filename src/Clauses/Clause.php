<?php
namespace QueryBuilder\Clauses;

abstract class Clause
{
	protected $clause = '';

	protected $clauseName;

	protected $initialised = false;

    public function addToClause($string){
        if (!$this->initialised){
        	$this->initialise();
        }
        $this->clause .= $string;
    }

    public function getClause(){
        return $this->clause;
    }

    public function initialise(){
    	$this->initialised = true;
    	$this->addToClause($this->clauseName.' ');
    }
}