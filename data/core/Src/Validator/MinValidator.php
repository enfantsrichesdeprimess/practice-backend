<?php
namespace Src\Validator;

use Src\Validator\AbstractValidator;

class MinValidator extends AbstractValidator
{
    protected string $message = 'Минимальная длина поля :field - :min символов';

    public function rule(): bool
    {
        $min = (int)($this->args[0] ?? 0);
        return strlen($this->value) >= $min;
    }
}
