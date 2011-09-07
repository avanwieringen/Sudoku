<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;

class SimpleLogicStrategy extends AbstractStrategy  {
    
    private $possibleSteps = array();
    
    public function getNextStep($stepChoice) {
        return $this->possibleSteps[$stepChoice];
    }
    
    public function getPossibleSteps() {
        $this->possibleSteps = array();
        for($r = 0; $r < $this->sudoku->getRowCount(); $r++) {
            for($c = 0; $c < $this->sudoku->getColumnCount(); $c++) {
                $choices = $this->sudoku->getChoices($r, $c);
                if(count($choices) == 1) {
                    $this->possibleSteps[] = array($r, $c, $choices[0]);
                }
            }
        }
        return count($this->possibleSteps);
    }
    
}

?>
