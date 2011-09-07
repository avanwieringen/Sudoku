<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;
use Avanwieringen\Sudoku\Solver\Solver;

use Avanwieringen\Sudoku\Solver\Strategy\SimpleLogicStrategy;

$sudoku = new Sudoku('800005216045862007670009500769204030020001765001670009004096800907400601306107940');
//$sudoku = new Sudoku('..84...3....3.....9....157479...8........7..514.....2...9.6...2.5....4......9..56');

$renderer = new StringRenderer();
echo $renderer->render($sudoku) . "\n\n";

$solver   = new Solver(array(new SimpleLogicStrategy()));
$solution = $solver->solve($sudoku);

if($solution !== false) { echo $renderer->render($solution); } else { echo 'Fuuuu...'; }