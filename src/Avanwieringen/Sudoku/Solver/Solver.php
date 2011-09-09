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
     * @return Sudoku
     */
    public function solve(Sudoku $s) {
        if(count($this->strategies) == 0) throw new SolverException("No solverstrategies added");        
        
        for($i_s = 0; $i_s < count($this->strategies); $i_s++) {
            /* @var $strategy StrategyInterface */
            $strategy = clone $this->strategies[$i_s];        
            $strategy->setSudoku($s);

            $choices = $strategy->getPossibleSteps();
            for($i_c = 0; $i_c < $choices; $i_c++) {
                $step = $strategy->getNextStep($i_c);

                /* @var $ns Sudoku */
                $ns   = clone $s;
                $ns->setValue($step[0], $step[1], $step[2]);

                // is the sudoku solved or solveable?
                if(!$ns->isSolvable() || $ns->isSolved()) { 
                    return $ns;
                }            

                $childResult = $this->solve($ns);
                if(!$childResult->isSolvable()) {
                    $ns = $childResult;
                } elseif($childResult->isSolved()) {
                    return $childResult;
                }
            }
        }
        return $ns;
    }
}

class SolverException extends \Exception {};