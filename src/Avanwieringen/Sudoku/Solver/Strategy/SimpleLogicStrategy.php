<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;

use Avanwieringen\Sudoku\Sudoku;

class SimpleLogicStrategy implements StrategyInterface {
    
    public function solve(Sudoku $s) {
        $possiblities = array();
        $possibleSteps = array();   
        for($r = 0; $r < $s->getRowCount(); $r++) {
            for($c = 0; $c < $s->getColumnCount(); $c++) {
                if(!$s->isFilledCell($r, $c)) {
                    $choices = $s->getChoices($r, $c);
                    if(count($choices) == 0) return array();
                    if(count($choices) == 1) {
                        $possibleSteps[] = array($r, $c, $choices[0]);
                    }
                }
            }
        }
        
        if(count($possibleSteps) > 0) {
            $solution = clone $s;
            foreach($possibleSteps as $step) {
                $solution->setValue($step[0], $step[1], $step[2]);
            }
            $possiblities[] = $solution;
        }
        return $possiblities;        
    }
    
}
