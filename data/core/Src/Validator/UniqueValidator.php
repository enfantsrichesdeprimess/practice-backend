<?php
namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;

class UniqueValidator extends AbstractValidator
{
    protected string $message = 'Поле :field уже существует';

    public function rule(): bool
    {
        $table = $this->args[0] ?? '';
        $column = $this->args[1] ?? $this->field;
        
        return (bool)!Capsule::table($table)
            ->where($column, $this->value)
            ->count();
    }
}