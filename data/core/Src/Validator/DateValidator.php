<?php
namespace Src\Validator;

use Src\Validator\AbstractValidator;

class DateValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно быть корректной датой';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return false;
        }
        
        $d = \DateTime::createFromFormat('Y-m-d', $this->value);
        return $d && $d->format('Y-m-d') === $this->value;
    }
}
