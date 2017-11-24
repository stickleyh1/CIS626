<?php

/**
 * Removes all unsafe formatting and whitespace
 * @param $field - form field
 */
function formatInput($field)
{
    return htmlspecialchars(stripslashes(trim($field)));
}
    
/**
 * Validates non-blank input
 * Sets blank input to zero
 * @param $field - form field
 */
function validateInput($field, $type)
{
    // If string is non-blank replace escapes with space then format
    if ($type == 'string') {
        return empty($field)? "" : formatInput(preg_replace('/\t|\R/', ' ', $field));
    }
    if ($type == 'number') {
        return empty($field)? 0 : formatInput($field);
    }
}

/**
 * Checks if variable is set, if not returns correct blank value for type
 * @param $field - form field
 * @param $type - type of data (e.g. number, string)
 */
function isSetHandler($field, $type)
{
    if ($type == 'number') {
        return isset($field) ? validateInput($field, $type) : 0;
    } elseif ($type == 'string') {
        return isset($field) ? validateInput($field, $type) : "";
    } elseif ($type == '' || $type == 'bool'){
        return isset($field);
    }
}

/**
 * Reads a given file and returns an array
 * @param $filename - the file to read
 * @param $delim - the file's delimiter (e.g. csv-',')
*/
function readFileToArr($filename, $delim){
    $fileArray = [];
    // Open file for reading
    @$fp = fopen(dirname(__FILE__, 2)."/files/".$filename, 'rb');
    flock($fp, LOCK_SH); // lock file for reading

    if (!$fp) {
        exit;
    }

    // Loop through file til end
    while (!feof($fp)) {
        // Break line into array based on file delim
        $line= explode("".$delim,fgets($fp));
        // Skip if line is blank continue
        if(count($line) == 0){
            continue;
        } 
        // Add line to array
        array_push($fileArray, $line);
    }
    flock($fp, LOCK_UN); // release read lock
    fclose($fp); 
    // Return file in array form
    return $fileArray;
}

?>