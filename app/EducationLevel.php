<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends ReadOnlyBase
{
    //
    protected $connection = 'hris';
    protected $object_array = [
        [
            "id" => 1,
            "description" => "Elementary",
            "basic" => 1,
        ],
        [
            "id" => 2,
            "description" => "High School",
            "basic" => 1,
        ],
        [
            "id" => 3,
            "description" => "College",
            "basic" => 0,
        ],
        [
            "id" => 4,
            "description" => "Technical / Vocational",
            "basic" => 0,
        ],
        [
            "id" => 5,
            "description" => "Post Graduate Degree",
            "basic" => 0,
        ],
    ];
}
