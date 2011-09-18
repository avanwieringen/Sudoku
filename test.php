<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;
use Avanwieringen\Sudoku\Solver\Solver;

use Avanwieringen\Sudoku\Solver\Strategy\SimpleLogicStrategy;
use Avanwieringen\Sudoku\Solver\Strategy\BruteForceStrategy;

$sudoku = new Sudoku('800005216045862007670009500769204030020001765001670009004096800907400601306107940');
//$sudoku = new Sudoku('000004000100803907908200005807030200501009008000040500000102000000007100612300870');
//$sudoku = new Sudoku('000560300100000800024000000009000000080720006610800000007206000400080037000104090');
//$sudoku = new Sudoku('963......1....8......2.5....4.8......1....7......3..257......3...9.2.4.7......9..');
//$sudoku   = new Sudoku('249.6...3.3....2..8.......5.....6......2......1..4.82..9.5..7....4.....1.7...3...');

$renderer = new StringRenderer();
echo $renderer->render($sudoku) . "\n\n";

//$solver   = new Solver(array(new SimpleLogicStrategy(), new BruteForceStrategy()));
$solver   = new Solver(array(new BruteForceStrategy()));
//$solver   = new Solver(array(new SimpleLogicStrategy()));

$steps = 0;
$solver->onIterate(function($e) use(&$steps) { 
    if($steps%1==0) { 
        echo "Iteration " . $steps .": using " . get_class($e->getStrategy()) . ", level: " . $e->getLevel() ."\n"; 
    }
    $steps++;
});

//$solver->onIterationDone(function($e) { echo "In " . $e->getTime() * 1000 . " ms.\n"; });
$solution = $solver->solve($sudoku);

echo $renderer->render($solution->getSudoku());

//$bf = new BruteForceStrategy();
//$sols = $bf->solve($sudoku);
