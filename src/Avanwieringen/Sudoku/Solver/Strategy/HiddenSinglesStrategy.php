<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;

use Avanwieringen\Sudoku\Sudoku;

class HiddenSinglesStrategy implements StrategyInterface {
    
    public function solve(Sudoku $s) {
        $types = array('row' => array(), 'col' => array(), 'sec' => array());
        
        $rowcols = array();
        foreach(array_keys($types) as $type) {
            for($i = 0; $i < $s->getSectorCount(); $i++) {
                
                switch($type) {
                    case 'row':
                        for($j = 0; $j < $s->getSectorCount(); $j++) {
                            $rowcols[$i][] = array('r' => $i, 'c' => $j);
                        }
                        break;
                        
                    case 'col':
                        for($j = 0; $j < $s->getSectorCount(); $j++) {
                            $rowcols[$i + $s->getSectorCount()][] = array('r' => $j, 'c' => $i);
                        }
                        break;
                        
                    case 'sec':
                        $rows = range(floor($i/sqrt($s->getSectorCount())) * sqrt($s->getSectorCount()), floor($i/sqrt($s->getSectorCount())) * sqrt($s->getSectorCount()) + 2);
                        $cols = range($i%sqrt($s->getSectorCount())*sqrt($s->getSectorCount()), ($i%sqrt($s->getSectorCount())+1)*sqrt($s->getSectorCount()) - 1);
                        foreach($rows as $r) {
                            foreach($cols as $c) {
                                $rowcols[$i + 2*$s->getSectorCount()][] = array('r' => $r, 'c' => $c);
                            }
                        }
                        break;
                }
            }
        }
        
        $possibleSteps = array();
        foreach($rowcols as $section) {
            $choices = array();
            foreach($section as $rc) {
                $ch = $s->getChoices($rc['r'], $rc['c']);
                if(count($ch) > 0) {
                    foreach($ch as $c) {
                        $choices[$c][] = $rc;
                    }
                }
            }
            
            if(count($choices) > 0) {
                foreach($choices as $value => $locations) {
                    if(count($locations) == 1) {
                        $possibleSteps[] = array($locations[0]['r'], $locations[0]['c'], $value);
                    }
                }
            }
        }
        
        $possibilities = array();
        if(count($possibleSteps) > 0) {
            $ns = clone $s;
            foreach($possibleSteps as $step) {
                $ns->setValue($step[0], $step[1], $step[2]);
            }
            $possibilities[] = $ns;
        }
        return $possibilities;
    }
    
}
