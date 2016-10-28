<?php
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

/*
| -------------------------------------------------------------------
| GENERAL USE FUNCTIONS
| -------------------------------------------------------------------
*/

/**
 * Get an item from an array using "dot" notation.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function array_get($array, $key, $default = null)
{
    if (is_null($key)) {
        return $array;
    }

    if (isset($array[$key])) {
        return $array[$key];
    }

    foreach (explode('.', $key) as $segment) {
        if (! is_array($array) || ! isset($array[$segment])) {
            return $default;
        }

        $array = $array[$segment];
    }

    return $array;
}

/**
 * Check if an item exists in an array using "dot" notation.
 *
 * @param array $array
 * @param string $key
 * @return bool
 */
function array_has(array $array, $key)
{
    if (empty($array) || is_null($key)) {
        return false;
    }

    if (array_key_exists($key, $array)) {
        return true;
    }

    foreach (explode('.', $key) as $segment) {
        if (! is_array($array) || ! array_key_exists($segment, $array)) {
            return false;
        }

        $array = $array[$segment];
    }

    return true;
}

/**
 * Set an array item to a given value using "dot" notation.
 *
 * If no key is given to the method, the entire array will be replaced.
 *
 * @param  array   $array
 * @param  string  $key
 * @param  mixed   $value
 * @return array
 */
function array_set(&$array, $key, $value)
{
    if (is_null($key)) {
        return $array = $value;
    }

    $keys = explode('.', $key);

    while (count($keys) > 1) {
        $key = array_shift($keys);

        // If the key doesn't exist at this depth, we will just create an empty array
        // to hold the next value, allowing us to create the arrays to hold final
        // values at the correct depth. Then we'll keep digging into the array.
        if (! isset($array[$key]) || ! is_array($array[$key])) {
            $array[$key] = [];
        }

        $array = &$array[$key];
    }

    $array[array_shift($keys)] = $value;

    return $array;
}

/**
 * Remove one or many array items from a given array using "dot" notation.
 *
 * @param  array  $array
 * @param  array|string  $keys
 * @return void
 */
function array_forget(&$array, $keys)
{
    $original = &$array;

    $keys = (array) $keys;

    if (count($keys) === 0) {
        return;
    }

    foreach ($keys as $key) {
        $parts = explode('.', $key);

        while (count($parts) > 1) {
            $part = array_shift($parts);

            if (isset($array[$part]) && is_array($array[$part])) {
                $array = &$array[$part];
            } else {
                $parts = [];
            }
        }

        unset($array[array_shift($parts)]);

        // clean up after each pass
        $array = &$original;
    }
}

/**
 * Flatten a multi-dimensional associative array with dots.
 *
 * @param  array   $array
 * @param  string  $prepend
 * @return array
 */
function array_dot($array, $prepend = '')
{
    $results = [];

    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $results = array_merge($results, array_dot($value, $prepend.$key.'.'));
        } else {
            $results[$prepend.$key] = $value;
        }
    }

    return $results;
}

/**
 * Determine if a given string starts with a given substring.
 *
 * @param  string  $haystack
 * @param  string|array  $needles
 * @return bool
 */
function starts_with($haystack, $needles)
{
    foreach ((array) $needles as $needle) {
        if ($needle != '' && mb_strpos($haystack, $needle) === 0) {
            return true;
        }
    }

    return false;
}

/**
 * Cuts off the specified substring from the beginning of the specified string
 *
 * @param string $string
 * @param string $unwanted
 * @return string
 */
function cut_string_left($string, $unwanted)
{
    if (!starts_with($string, $unwanted)){
        return $string;
    }

    return substr($string, strlen($unwanted));
}

/**
 * Cuts off the specified substring from the end of the specified string
 *
 * @param string $string
 * @param string $unwanted
 * @return string
 */
function cut_string_right($string, $unwanted)
{
    if (!ends_with($string, $unwanted)){
        return $string;
    }

    return substr($string, 0, strlen($string) - strlen($unwanted));
}

if (!function_exists('array_column')) {
    /**
     * This function provides functionality for array_column() to versions of PHP earlier than 5.5. It mimics the functionality of the built-in function in every way.
     *
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array|bool
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}

/**
 * Convert a value to camel case.
 *
 * @param  string  $value
 * @return string
 */
function camel_case($value)
{
    return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value))));
}

/**
 * Convert a string to snake case.
 *
 * @param  string  $value
 * @param  string  $delimiter
 * @return string
 */
function snake_case($value, $delimiter = '_')
{
    if (!ctype_lower($value)) {
        $value = preg_replace('/\s+/u', '', $value);

        $value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value), 'UTF-8');
    }

    return $value;
}

/**
 * Converts all keys to camel case
 *
 * @param array $data
 * @return array]
 */
function camel_keys(array $data)
{
    $result = [];

    foreach ($data as $key => $value) {
        $result[camel_case($key)] = is_array($value) ? camel_keys($value) : $value;
    }

    return $result;
}

/*
| -------------------------------------------------------------------
| ALIASES OF METHODS IN THE "DEBUG" CLASS
| -------------------------------------------------------------------
*/

function pre()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::pre', func_get_args());
}

function pred()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::pred', func_get_args());
}

function vred()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::vred', func_get_args());
}

function vre()
{
    call_user_func_array('ImmediateSolutions\Support\Debugging\Debug::vre', func_get_args());
}