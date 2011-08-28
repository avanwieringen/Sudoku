<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;
use Avanwieringen\Sudoku\Renderers\StringRenderer;


$s = new Sudoku();
$s->setValues(str_repeat('3', 81));

$r = new StringRenderer();
print_r($r->render($s));