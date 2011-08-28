<?php

namespace Avanwieringen\Sudoku;

use Avanwieringen\Collections\Tools;

class Sudoku {
    const ROWS = 9;
    const COLS = 9;

    private $values = array();

    public function __construct() {
        $this->values = Tools::generate(self::ROWS, Tools::generate(self::COLS, 0));
    }

    public function getValues() {
        return $this->values;
    }

    public function setValues($values) {
        if (is_array($values)) {
           $this->parseArray($values); 
        } elseif(is_string($values)) {
            $this->parseString($values);
        } else {
           throw new \InvalidArgumentException(sprintf('Values must be a %dx%d integer array or a string consisting of %d numbers', self::ROWS, self::COLS, self::ROWS * self::COLS)); 
        }
    }
    
    public function setValue($row, $col, $value) {
        if($row >= self::ROWS) {
            throw new \InvalidArgumentException(sprintf('Row index (%d) exceeds dimensions [0 - %d]', $row, self::ROWS - 1));
        } elseif($col >= self::COLS) {
            throw new \InvalidArgumentException(sprintf('Column index (%d) exceeds dimensions [0 - %d]', $col, self::COLS - 1));
        } elseif(!is_int($value)) {
            throw new \InvalidArgumentException(sprintf('Value %s is not an integer', $value));
        }
        $this->values[$row][$col] = $value;
    }
    
    public function getValue($row, $col) {
        if($row >= self::ROWS) {
            throw new \InvalidArgumentException(sprintf('Row index (%d) exceeds dimensions [0 - %d]', $row, self::ROWS - 1));
        } elseif($col >= self::COLS) {
            throw new \InvalidArgumentException(sprintf('Column index (%d) exceeds dimensions [0 - %d]', $col, self::COLS - 1));
        }
        return $this->values[$row][$col];
    }

    public function parseArray(array $values) {
        if (count($values) != self::ROWS || count($values[0]) != self::COLS) {
            throw new \InvalidArgumentException(sprintf('Values must be a %dx%d integer array', self::ROWS, self::COLS));
        }
    }
    
    public function parseString($values) {
        if(strlen($values) != (self::COLS * self::ROWS)) {
            throw new \InvalidArgumentException(sprintf('Values must be a string consisting of %d numbers', self::ROWS * self::COLS));
        }
        
        $chars = str_split($values);
        foreach($chars as $i => $char) {
            $r = floor($i / self::COLS);
            $c = ($i - $r*self::ROWS);
            $this->setValue($r, $c, (int)$char);
        }
    }
}
