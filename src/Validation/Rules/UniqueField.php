<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class UniqueField extends AbstractRule
{
    public $model;
    public $column;
    public $ignore;

    public function __construct($model, $column, $ignore)
    {
        $this->model = $model;
        $this->column = $column;
        $this->ignore = $ignore;
    }

    public function validate($input): bool
    {
        return $input == $this->ignore 
            ? true
            : !$this->model::where($this->column, $input)->exists();
    }
}
