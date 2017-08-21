<?php

define('STEP1', 1);
define('STEP2', 2);
define('STEP3', 3);
define('STEP4', 4);


/**
 *  Return only top value of an array
 * @param Array
 * @param $nested_level
 * @return mixed|null
 */
function unwrap($data, $nested_level = 2)
{
    if ($nested_level == 1) {
        return current($data);
    }
    return current(unwrap($data, $nested_level - 1));
}
