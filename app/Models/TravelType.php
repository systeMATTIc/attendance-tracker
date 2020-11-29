<?php

namespace App\Models;

use ArrayAccess;
use LogicException;

class TravelType implements ArrayAccess
{
    protected $attributes;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new LogicException(
            sprintf("{0} attributes are readonly", self::class)
        );
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->attributes);
    }

    public function offsetUnset($offset)
    {
        throw new LogicException(
            sprintf("{0} attributes are readonly", self::class)
        );
    }
}
