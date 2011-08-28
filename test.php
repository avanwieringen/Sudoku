<?php

require_once('bootstrap.php');

use Avanwieringen\Sudoku\Sudoku;


$s = new Sudoku();
$s->setValues(str_repeat('3', 81));