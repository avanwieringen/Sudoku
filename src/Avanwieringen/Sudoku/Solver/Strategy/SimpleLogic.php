<?php

namespace Avanwieringen\Sudoku\Solver\Strategy;

class SimpleLogic extends AbstractStrategy  {
    
    public function nextStep() {
        for($r = 0; $r < $this->sudoku->getRowCount(); $r++) {
            for($c = 0; $c < $this->sudoku->getColumnCount(); $c++) {
                $choices = $this->sudoku->getChoices($r, $c);
                if(count($choices) == 1) {
                    $this->sudoku->setValue($r, $c, $choices[0]);
                    return $this->sudoku;
                }
            }
        }
        return false;
    }
    
}

?>
