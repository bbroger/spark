<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class UniqueField extends AbstractRule
{
    public $model;
    public $column;

    public function __construct($model, $column)
    {
        $this->model = $model;
        $this->column = $column;
    }

    public function validate($input): bool
    {
        return !$this->model::where($this->column, $input)->exists();
    }
}
