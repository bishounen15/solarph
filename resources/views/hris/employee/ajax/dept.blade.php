<?php
    use App\DeptLink as DeptLink;
    $departments = DeptLink::getDepartments($div_id);
    return $departments;