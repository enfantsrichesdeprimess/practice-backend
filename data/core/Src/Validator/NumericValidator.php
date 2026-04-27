<?php
namespace Src\Validator;

use Src\Validator\AbstractValidator;

class NumericValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть числом';

    public function rule(): bool
    {
        return is_numeric($this->value);
    }
}
