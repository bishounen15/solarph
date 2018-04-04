<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReadOnlyBase
{
    //
    protected $object_array = [];

    public function all()
    {
        return $this->object_array;
    }

    public function get( $id )
    {
        return $this->object_array[$id];
    }
}
