<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;

$reader  = new FileReader();
$sudokus = $reader->read(__DIR__ . '/sudokus.txt');
$renderer= new StringRenderer();

$sudoku  = $sudokus[4];

echo $renderer->render($sudoku);
print_r($sudoku->getSector(8));
