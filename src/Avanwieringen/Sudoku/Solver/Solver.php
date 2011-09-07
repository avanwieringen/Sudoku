<?php

namespace Avanwieringen\Sudoku\Solver;
use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Solver\Strategy\StrategyInterface;

class Solver {
    
    /**
     * Array of Solver Strategies
     * @var Array 
     */
    private $strategies = array();
    
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
     * @return mixed Sudoku on success and false on failure
     */
    public function solve(Sudoku $s, $strategyIndex = 0) {
        if(count($this->strategies) == 0) throw new SolverException("No solverstrategies added");        
        
        /* @var $strategy StrategyInterface */
        $strategy = $this->strategies[$strategyIndex];        
        $strategy->setSudoku($s);
        
        $choices = $strategy->getPossibleSteps();
        if($choices == 0) return false;
        
        for($i_c = 0; $i_c < $choices; $i_c++) {
            $step = $strategy->getNextStep($i_c);
            
            /* @var $ns Sudoku */
            $ns   = clone $s;
            $ns->setValue($step[0], $step[1], $step[2]);
            
            // is the sudoku solved or solveable?
            if(!$ns->isSolvable()) return false;
            if($ns->isSolved()) return $ns;
            
            // traverse child possibilities
            $childSolution = $this->solve($ns, $strategyIndex);
            if($childSolution instanceof Sudoku) return $childSolution;
        }
        return false;
    }
}

class SolverException extends \Exception {};