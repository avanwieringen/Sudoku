<?php

namespace Avanwieringen\Sudoku\Renderers;

/**
 * Description of String
 *
 * @author arjan
 */
class StringRenderer implements RendererInterface {
    
    public function render(\Avanwieringen\Sudoku\Sudoku $sudoku) {
        $lines = array();
        foreach($sudoku->getValues() as $rows) {
            $lines[] = str_replace('0', ' ', implode('', $rows));
        }
        return implode("\n", $lines);
    }
    
}
