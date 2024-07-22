<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter4.github.io/CodeIgniter4/
 */
if(!function_exists('arrayToXML')){
    /**
    * Converts an array to XML
    *
    * @param array $array
    * @param SimpleXMLElement $xml
    * @param string $child_name
    *
    * @return SimpleXMLElement $xml
    */
    function arrayToXML($array, \SimpleXMLElement $xml, $child_name){
        // Loop through the data
        foreach ($array as $k => $v) {
            if(is_array($v)) {
                (is_int($k)) ? arrayToXML($v, $xml->addChild($child_name), $v) : arrayToXML($v, $xml->addChild(strtolower($k)), $child_name);
            } else {
                (is_int($k)) ? $xml->addChild($child_name, $v) : $xml->addChild(strtolower($k), $v);
            }
        }
        //
        return $xml->asXML();
    }
}