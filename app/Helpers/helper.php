<?php

function formatCurrency($value, $prefix = ''){
    return $prefix.number_format($value, 0);
}

function enumText($value){
    return ucwords($value);
}

function clearCurrency($value) {
    if (preg_match('/^\d{1,3}(,\d{3})*(\.\d{2})?$/', $value)) {
        return str_replace(',', '', $value);
    }
    return 0; 
}
