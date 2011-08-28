<?php

namespace Avanwieringen\Sudoku\Renderers;

/**
 *
 * @author arjan
 */
interface RendererInterface {
    
    public function render(\Avanwieringen\Sudoku\Sudoku $sudoku);
    
}

?>
