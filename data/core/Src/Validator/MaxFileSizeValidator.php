<?php
namespace Src\Validator;

class MaxFileSizeValidator extends AbstractValidator
{
    protected string $message = 'Размер файла в поле :field не должен превышать :max КБ';

    public function rule(): bool
    {
        if (empty($this->value) || ($this->value['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if (($this->value['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return false;
        }

        $maxKb = (int)($this->args[0] ?? 0);
        if ($maxKb <= 0) {
            return true;
        }

        return (($this->value['size'] ?? 0) / 1024) <= $maxKb;
    }
}
