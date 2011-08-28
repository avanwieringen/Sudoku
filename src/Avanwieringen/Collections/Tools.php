<?php

namespace Avanwieringen\Collections;

class Tools {
    
    public static function generate($size, $value) {
        return array_fill(0, $size, $value);
    }
    
}