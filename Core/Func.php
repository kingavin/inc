<?php
namespace Core;

class Func
{
	public static function getNumericArray($start = 1, $end, $inc = 1)
    {
    	$arr = array();
    	for($i = $start; $i < $end; $i = $i+$inc) {
    		$arr[$i] = $i;
    	}
    	return $arr;
    }
}