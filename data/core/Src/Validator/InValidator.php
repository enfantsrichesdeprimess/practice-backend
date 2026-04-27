<?php
namespace Src\Validator;

use Src\Validator\AbstractValidator;

class InValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть одним из: :values';

    public function rule(): bool
    {
        return in_array($this->value, $this->args);
    }
}
