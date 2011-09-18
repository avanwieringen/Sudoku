<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderer\StringRenderer;
use Avanwieringen\Sudoku\Reader\FileReader;
use Avanwieringen\Sudoku\Solver\Solver;

use Avanwieringen\Sudoku\Solver\Strategy\SinglesStrategy;
use Avanwieringen\Sudoku\Solver\Strategy\HiddenSinglesStrategy;
use Avanwieringen\Sudoku\Solver\Strategy\BruteForceStrategy;

//$sudoku = new Sudoku('800005216045862007670009500769204030020001765001670009004096800907400601306107940');
//$sudoku = new Sudoku('000004000100803907908200005807030200501009008000040500000102000000007100612300870');
//$sudoku = new Sudoku('000560300100000800024000000009000000080720006610800000007206000400080037000104090');
$sudoku = new Sudoku('...8....9.873...4.6..7.......85..97...........43..75.......3....3...145.4....2..1'); //hard

$renderer = new StringRenderer();
echo $renderer->render($sudoku) . "\n\n";

$solver   = new Solver(array(new SinglesStrategy(),
                             new HiddenSinglesStrategy(),   
                             new BruteForceStrategy()
                            ));

$steps = 0;
$solver->onIterate(function($e) use(&$steps) { 
    if($steps%100==0) { 
        echo "Iteration " . $steps .": using " . get_class($e->getStrategy()) . ", level: " . $e->getLevel() ."\n"; 
    }
    $steps++;
});

$solution = $solver->solve($sudoku);

echo $renderer->render($solution->getSudoku());
