<?php

namespace Avanwieringen\Sudoku\Solver;
use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Solver\Strategy\StrategyInterface;
use Avanwieringen\Sudoku\Solver\SolverResult;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Avanwieringen\Sudoku\Solver\Event\IterationEvent;
use Avanwieringen\Sudoku\Solver\Event\IterationDoneEvent;
use Avanwieringen\Benchmark\Benchmarker as Bench;

class Solver {
    
    /**
     * Array of Solver Strategies
     * @var array 
     */
    private $strategies = array();
    
    private $dispatcher;
    
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
        
        $this->dispatcher = new EventDispatcher();
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
     * @return SolverResult
     */
    public function solve(Sudoku $s) {
        if(count($this->strategies) == 0) throw new SolverException("No solverstrategies added");      
        
        if(!$s->isSolvable()) return new SolverResult($s, SolverResult::UNSOLVABLE);
        if($s->isSolved()) return new SolverResult($s, SolverResult::SOLVED);
        
        return $this->iterate($s);
    }
    
    public function onIterate($listener) {
        $this->dispatcher->addListener('sudoku.solver.iteration', $listener);
    }
    
    public function onIterationDone($listener) {
        $this->dispatcher->addListener('sudoku.solver.iteration.done', $listener);
    }
    
    /**
     * Iteration of the solver loop
     * @param Sudoku $s 
     * @return SolverResult Result
     */
    protected function iterate(Sudoku $s, $level = 0) {       
        foreach($this->strategies as $strategy) { 
            $this->dispatcher->dispatch('sudoku.solver.iteration', new IterationEvent($s, $strategy, $level));            
            /* @var $strategy StrategyInterface */            
            
            
            Bench::start('solver');
            $solutions = $strategy->solve($s);         
            $this->dispatcher->dispatch('sudoku.solver.iteration.done', new IterationDoneEvent(Bench::stop('solver')));
            if(count($solutions) > 0) {                
                foreach($solutions as $solution) {
                    /* @var $solution Sudoku */
                    if($solution->isSolved()) return new SolverResult($solution, SolverResult::SOLVED);
                    if($solution->isSolvable()) {
                        $childSolution = $this->iterate($solution, $level + 1);
                        if($childSolution->getResult()===SolverResult::SOLVED ) return $childSolution;
                    }
                }                
            }
        }  
        return new SolverResult($s, SolverResult::UNSOLVABLE);
    }
}

class SolverException extends \Exception {};