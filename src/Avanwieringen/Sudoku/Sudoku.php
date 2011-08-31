<?php

namespace Avanwieringen\Sudoku;

use Avanwieringen\Collections\Tools;

class Sudoku {
    
    /**
     * Values of the Sudoku with '0','.' or ' ' being an empty cell
     * @var int 
     */
    private $values;
    
    /**
     * Number of columns in the Sudoku
     * @var int 
     */
    private $cols;
    
    /**
     * Number of rows in the Sudoku
     * @var int
     */
    private $rows;
    
    /**
     * Number of sectors in the Sudoku
     * @var int
     */
    private $secs;
    
    /** 
     * Maximum value of a cell
     * @var int 
     */
    private $maxValue;
    
    /**
     * Initializes Sudoku with a specific size
     * @param int $size Size
     */
    public function __construct($size = 81) {
        // check if $size is square and dimensions are power of 2
        $dim     = pow($size, 0.25);
        if($dim !== floor($dim)) {
            throw new \InvalidArgumentException('$size^(1/4) must be an integer');
        }   
        $this->values   = array_fill(0, $size, 0);
        $this->cols     = sqrt($size);
        $this->rows     = sqrt($size);
        $this->secs     = sqrt($size);
        $this->maxValue = sqrt($size);
        
        $this->setValues(array_fill(0, $size, 0));
    }
    
    /**
     * Sets the values of the Sudoku with '0','.' or ' ' being an empty cell
     * @param String|Array $values Values
     */
    public function setValues($values) {
        if(is_array($values)) {
            $maxVal = $this->maxValue;
            if(count($values)!== count($this->values)) {
                throw new \InvalidArgumentException(sprintf('$values must either be a string or an array consisting of %d characters or integers', count($this->values)));
            } //elseif(count(array_filter($values, function($v) use ($maxVal) { return (is_int($v) && ($v >= 0) && ($v <= $maxVal)); })) !== count($this->values)) {
                elseif(count(array_filter($values, array($this,'isValidNumber'))) !== count($this->values)) {
               throw new \InvalidArgumentException(sprintf('Every value in $values should be an integer between 0 and %d', $this->maxValue)); 
            }            
            $this->values = $values;
        } elseif(is_string($values)) {
            if(strlen($values)!== count($this->values)) {
                throw new \InvalidArgumentException(sprintf('$values must either be a string or an array consisting of %d characters or integers', count($this->values)));
            }            
            $values = array_map(array($this,'parseNumber'), str_split($values));
            $this->values = $values;
        }
    }
    
    /**
     * Sets the value of a specific Sudoku cell
     * @param int $r Row, 0-index
     * @param int $c Column, 0-index
     * @param int|String $v Value to set
     */
    public function setValue($r, $c, $v) {    
        $this->values[$this->getIndex($r, $c)] = $this->parseNumber($v);
    }
    
    /** 
     * Get a specific cell value
     * @param int $r Row
     * @param int $c Column
     * @return int Cell Value 
     */
    public function getValue($r, $c) {
        return $this->values[$this->getIndex($r, $c)];
    }
    
    /**
     * Return the Sudoku as an array
     * @return Array Integer array with the Sudoku values
     */
    public function toArray() {
        $values = array(array_fill(0, $this->rows, array_fill(0, $this->cols, 0)));
        for($i_r = 0; $i_r < $this->rows; $i_r++) {
            for($i_c = 0; $i_c < $this->cols; $i_c++) {
                $values[$i_r][$i_c] = $this->getValue($i_r, $i_c);
            }
        }
        return $values;
    }
    
    /** 
     * Return the number of rows in the Sudoku
     * @return int 
     */
    public function getRows() {
        return $this->rows;
    }
    
    /** 
     * Return the number of columns in the Sudoku
     * @return int 
     */
    public function getCols() {
        return $this->cols;
    }
    
    /** 
     * Return the number of sectors in the Sudoku
     * @return int 
     */
    public function getSectors() {
        return $this->secs;
    }
    
    /**
     * Checks wether or not the row and column indices are valid
     * @param int $r
     * @param int $c
     * @return boolean or an Exception on error 
     */
    protected function checkColumnAndRowIndex($r, $c) {
        if(!is_int($r) || !is_int($c)) {
            throw new \InvalidArgumentException('Row and column indices must be integers');
        }
        
        if($r >= $this->rows || $c >= $this->cols) {
            throw new \OutOfRangeException('Row and column index must be within the range 0..' . ($this->maxValue - 1));
        }
        return true;
    }
    
    /**
     * Return the index in the 1-dim array belonging to a column and row index
     * @param int $r Row
     * @param int $c Columnn
     * @return type 
     */
    protected function getIndex($r, $c) {
        $this->checkColumnAndRowIndex($r, $c);    
        return ($r*$this->maxValue + $c);
    }
    
    /**
     * Internal function to check if a variable is a valid Sudoku cell value
     * @param String|int $v Value
     * @return Boolean 
     */
    protected function isValidNumber($v) {
        $empty = array('0','.',' ');
        if(is_string($v) || is_int($v)) {
            if(in_array($v, $empty)) {
                return true;
            }
            
            if(intval($v) > 0 && intval($v) <= $this->maxValue) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Internal function to parse a variable as a suitable Sudoky cell value
     * @param String|int $v
     * @return int 
     */    
    protected function parseNumber(&$v) {
        if(!$this->isValidNumber($v)) {
            throw new \InvalidArgumentException(sprintf("Value must be a String or an integer within the range 0..%d. '%s' given.", $this->maxValue, $v));
        }
        return intval($v);
    }
    
    
}
