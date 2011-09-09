<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;

class BruteForceStrategy extends AbstractStrategy  {
    
    private $possibleSteps = array();
    
    public function getNextStep($stepChoice) {
        return $this->possibleSteps[$stepChoice];
    }
    
    public function getPossibleSteps() {
        $this->possibleSteps = array();
        
        $currentMin = pow($this->sudoku->getSectorCount(), 2);
        
        for($r = 0; $r < $this->sudoku->getRowCount(); $r++) {
            for($c = 0; $c < $this->sudoku->getColumnCount(); $c++) {
                $choices = $this->sudoku->getChoices($r, $c);
                if(count($choices) < $currentMin && count($choices) > 0) { 
                    $this->possibleSteps = array(); 
                    $currentMin = count($choices);
                }
                
                if(count($choices) == $currentMin) {
                    foreach($choices as $choice) {
                        $this->possibleSteps[] = array($r, $c, $choice);
                    }
                }               
            }
        }
        return count($this->possibleSteps);
    }
    
}

?>
