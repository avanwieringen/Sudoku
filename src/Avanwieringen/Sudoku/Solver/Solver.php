<?php

namespace Avanwieringen\Sudoku\Solver;
use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Solver\Strategy\StrategyInterface;

class Solver {
    
    /**
     * Array of Solver Strategies
     * @var array 
     */
    private $strategies = array();
    
    /** 
     * Tree-structure of all Sudokus
     * @var array
     */
    private $solverTree = array();
    
    /**
     * Construct a solver with a strategy or an array of strategies, executed in that order
     * @param StrategyInterface|Array $strategies 
     */
    public function __construct($strategies = null) {
        if(is_array($strategies)) {
            foreach($strategies as $s) {
                $this->addStrategy($s);
            }
        } elseif($strategies instanceof StrategyInterface) {
            $this->addStrategy($strategies);
        }
    }
    
    /**
     * Add a solverstrategy, executed in that order
     * @param StrategyInterface $s 
     */
    public function addStrategy(StrategyInterface $s) {
        $this->strategies[] = $s;
    }
    
    /**
     * Solve a Sudoku
     * @param Sudoku $s 
     * @return Sudoku
     */
    public function solve(Sudoku $s, $parent = null, $level = 0) {
        if(count($this->strategies) == 0) throw new SolverException("No solverstrategies added");        
        
        if(is_null($parent)) {
            $parent = 0;
            $this->appendSolverTree($s);
        }
        
        $ret = clone $s;
        
        /* Make solver routine */
        
        return $ret;
    }
    
    /**
     * Appends a Sudoku to the solver tree
     * @param Sudoku $s
     * @return int Index 
     */
    private function appendSolverTree(Sudoku $s, $parent = null) {
        $index = count($this->solverTree);
        $this->solverTree[$index] = array('sudoku' => $s, 'solved' => $s->isSolved(), 'solvable' => $s->isSolvable(), 'parent' => $parent);
        return $index;
    }
}

class SolverException extends \Exception {};