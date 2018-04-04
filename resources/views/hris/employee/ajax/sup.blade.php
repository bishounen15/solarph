<?php
    use App\Employee as Employee;
    $superiors = Employee::getQualifiedSuperiors($div_id, $dep_id, $pos_id);
    return $superiors;