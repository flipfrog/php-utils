<?php

namespace utils;

class ArrayUtil
{
    /**
     * digging array layer by specified indexes then update destination value.
     * if destination by indexes does not exist intermediate indexes will be created.
     * @param array $base array to be digging
     * @param string ...$args indexes
     * @return mixed value to update
     * @throws \Exception
     */
    static public function digSet(array &$base, ...$args): mixed
    {
        if (count($args) < 2) {
            throw new \Exception('it needs at least 3 parameters consists of array, index(es), value.');
        }
        $value = $args[count($args) - 1];
        $pointer = &$base;
        $indexes = array_slice($args, 0, count($args) - 1);
        $index = null;
        foreach ($indexes as $i => $index) {
            if (isset($pointer[$index])) {
                if ($i < count($indexes) - 1) {
                    if (is_array($pointer[$index])) {
                        $pointer = &$pointer[$index];
                    } else {
                        throw new \Exception("value by intermediate index '$index' is not an array.");
                    }
                }
            } else {
                if ($i === count($indexes) - 1) {
                    $pointer[$index] = null;
                } else {
                    $pointer[$index] = [];
                    $pointer = &$pointer[$index];
                }
            }
        }
        $pointer[$index] = $value;
        return $pointer[$index];
    }

    /**
     * Same as digSet except index(es) parameter style, the index(es) are provided by array dot notation.
     * @param array $base
     * @param string $dotNotation array dot notation string
     * @param $value
     * @return mixed
     * @throws \Exception
     */
    static public function digSetDn(array &$base, string $dotNotation, $value): mixed
    {
        $params = array_filter(explode('.', $dotNotation));
        if (empty($params)) {
            throw new \Exception('index(es) are not provided.');
        }
        $params[] = $value;
        return self::digSet($base, ...$params);
    }
}
