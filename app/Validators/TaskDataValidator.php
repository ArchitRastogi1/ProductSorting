<?php

namespace Validators;

class TaskDataValidator {
    
    public function validateProductIds($productIdArr) {
        if(count($productIdArr)==0 || empty($productIdArr)) {
            return 'Please provide product id values';
        } 
        foreach($productIdArr as $product) {
            if(!is_numeric($product)) {
                return 'Please provide correct product id values';
            }
        }
        return true;
    }
}

