<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;

$sudoku = new Sudoku('6.....8.3.4.7.................5.4.7.3..2.....1.6.......2.....5.....8.6......1....');

$renderer = new StringRenderer();
echo $renderer->render($sudoku) . "\n\n";

var_dump($sudoku->isSolvable());