<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;

$sudoku = new Sudoku(16);
//$sudoku->setValues(array(0, 1, 2, 3, 4, 2, 3, 2, 3, 4, 2, 3, 2, 1, 0, 1));
$sudoku->setValues('0123423234232101');