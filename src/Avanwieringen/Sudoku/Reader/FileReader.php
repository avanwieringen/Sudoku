<?php

namespace Avanwieringen\Sudoku\Reader;

use Avanwieringen\Sudoku\Sudoku;

class FileReader {
    
    public function read($filename) {
        if(!file_exists($filename)) {
            throw new \InvalidArgumentException(sprintf('File %s does not exist', $filename));
        }
        $lines = explode("\n",file_get_contents($filename));
        
        $sudokus = array();
        foreach($lines as $line) {
            if(strlen($line) > 0) {
                $sudokus[] = new Sudoku($line);
            }
        }
        return $sudokus;
    }
    
}
