<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends ReadOnlyBase
{
    //
    protected $object_array = [
        [
            "description" => "Parent",
            "max_age" => 65,
        ],
        [
            "description" => "Sibling",
            "max_age" => 21,
        ],
        [
            "description" => "Spouse",
            "max_age" => 65,
        ],
        [
            "description" => "Child",
            "max_age" => 21,
        ],
    ];
}
