<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;

use Avanwieringen\Sudoku\Sudoku;

class SimpleLogicStrategy implements StrategyInterface {
    
    public function solve(Sudoku $s) {
        $possiblities = array();        
        for($r = 0; $r < $s->getRowCount(); $r++) {
            for($c = 0; $c < $s->getColumnCount(); $c++) {
                $choices = $s->getChoices($r, $c);
                if(count($choices) == 1) {
                    $ns = clone $s;
                    $ns->setValue($r, $c, $choices[0]);
                    $possiblities[] = $ns;
                }
            }
        }        
        return $possiblities;        
    }
    
}
