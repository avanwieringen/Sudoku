<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;

$sudoku = new Sudoku(16);
$sudoku->setValues('0123423234232101');

$renderer = new StringRenderer();
echo $renderer->render($sudoku) . "\n\n";

echo $sudoku->isValidCell(0, 0);