<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;
use Avanwieringen\Sudoku\Solver\Solver;

use Avanwieringen\Sudoku\Solver\Strategy\SimpleLogic;

$sudoku = new Sudoku('800005216045862007670009500769204030020001765001670009004096800907400601306107940');

$renderer = new StringRenderer();
echo $renderer->render($sudoku) . "\n\n";

$solver   = new Solver(array(new SimpleLogic()));
echo $renderer->render($solver->solve($sudoku))  . "\n\n";
echo $renderer->render($sudoku);