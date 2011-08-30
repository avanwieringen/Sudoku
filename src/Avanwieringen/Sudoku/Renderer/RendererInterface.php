<?php

namespace Avanwieringen\Sudoku\Renderer;
use Avanwieringen\Sudoku\Sudoku;

/**
 *
 * @author arjan
 */
interface RendererInterface {
    
    public function render(Sudoku $sudoku);
    
}

?>
