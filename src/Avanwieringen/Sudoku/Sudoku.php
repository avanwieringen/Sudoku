<?php

namespace Avanwieringen\Sudoku;

use Avanwieringen\Collections\Tools;

class Sudoku {
    const ROWS = 9;
    const COLS = 9;

    private $values = array();

    public function __construct($values = null) {
        if(is_null($values)) {
           $this->setValues(Tools::generate(self::ROWS, Tools::generate(self::COLS, 0)));
        } elseif(is_array($values)) {
            $this->parseArray($values);
        } else {
            $this->parseString($values);
        }
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
            throw new \OutOfRangeException(sprintf('Row index (%d) exceeds dimensions [0 - %d]', $row, self::ROWS - 1));
        } elseif($col >= self::COLS) {
            throw new \OutOfRangeException(sprintf('Column index (%d) exceeds dimensions [0 - %d]', $col, self::COLS - 1));
        } elseif(!is_int($value)) {
            throw new \InvalidArgumentException(sprintf('Value %s is not an integer', $value));
        }
        $this->values[$row][$col] = $value;
    }
    
    public function getValue($row, $col) {
        if($row >= self::ROWS) {
            throw new \OutOfRangeException(sprintf('Row index (%d) exceeds dimensions [0 - %d]', $row, self::ROWS - 1));
        } elseif($col >= self::COLS) {
            throw new \OutOfRangeException(sprintf('Column index (%d) exceeds dimensions [0 - %d]', $col, self::COLS - 1));
        }
        return $this->values[$row][$col];
    }
    
    public function getNumCols() {
        return self::COLS;
    }
    
    public function getNumRows() {
        return self::ROWS;
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
            
            if(!is_numeric($char)) {
                $char = 0;
            }
            $this->setValue($r, $c, (int)$char);
        }
    }
    
    public function getRow($index) {
        if(!is_numeric($index)) {
            throw new \InvalidArgumentException('Index is not an integer');
        } elseif($index < 0 || $index > (self::ROWS - 1)) {
            throw new \OutOfRangeException(sprintf('Row index (%d) exceeds dimensions [0 - %d]', $col, self::ROWS - 1));
        }        
        return $this->values[$index];
    }
    
    public function getColumn($index) {
        if(!is_numeric($index)) {
            throw new \InvalidArgumentException('Index is not an integer');
        } elseif($index < 0 || $index > (self::COLS - 1)) {
            throw new \OutOfRangeException(sprintf('Row index (%d) exceeds dimensions [0 - %d]', $col, self::COLS - 1));
        }
        $col = array();
        foreach($this->values as $row) {
            $col[] = $row[$index];
        }
        return $col;
    }
    
    public function getSector($index) {
        if(!is_numeric($index)) {
            throw new \InvalidArgumentException('Index is not an integer');
        } elseif($index < 0 || $index > (self::COLS - 1)) {
            throw new \OutOfRangeException(sprintf('Sector index (%d) exceeds dimensions [0 - %d]', $col, self::ROWS - 1));
        }
        
        $vals = array();
        for($r = floor($index /sqrt(self::ROWS)) * sqrt(self::ROWS); $r < (floor($index/sqrt(self::ROWS)) + 1) * sqrt(self::ROWS); $r++) {
            for($c = $index%sqrt(self::COLS) * sqrt(self::COLS); $c < ($index%sqrt(self::COLS) + 1) * sqrt(self::COLS);  $c++) {
                $vals[] = $this->getValue($r, $c);
            }
        }
        return $vals;
    }
    
    public function isValid() {
        
    }
    
    public function isSolved() {
        
    }
}
