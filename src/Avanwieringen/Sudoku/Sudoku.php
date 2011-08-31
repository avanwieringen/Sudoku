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
     * @param int $size 
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
     * @param String|Array $values 
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
     * Internal function to check if a variable is a valid Sudoku cell value
     * @param String|int $v
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
     *  Internal function to parse a variable as a suitable Sudoky cell value
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
