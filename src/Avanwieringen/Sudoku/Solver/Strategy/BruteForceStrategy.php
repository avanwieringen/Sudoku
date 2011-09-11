<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;

use Avanwieringen\Sudoku\Sudoku;

class BruteForceStrategy implements StrategyInterface {
    
    public function solve(Sudoku $s) {
        $solutions = array();
        $possibleSteps = array();     
        
        $currentMin = pow($s->getSectorCount(), 2);
        for($r = 0; $r < $s->getRowCount(); $r++) {
            for($c = 0; $c < $s->getColumnCount(); $c++) {
                $choices = $s->getChoices($r, $c);
                if(count($choices) < $currentMin && count($choices) > 0) { 
                    $possibleSteps = array(); 
                    $currentMin = count($choices);
                }
                
                if(count($choices) == $currentMin) {
                    foreach($choices as $choice) {
                        $possibleSteps[] = array($r, $c, $choice);
                    }
                }               
            }
        }       
        
        
        if(count($possibleSteps) > 0) {
            foreach($possibleSteps as $pos) {
                $solution = clone $s;
                $solution->setValue($pos[0], $pos[1], $pos[2]);
                $solutions[] = $solution;
            }
        }    
        return $solutions;
    }
    
}
