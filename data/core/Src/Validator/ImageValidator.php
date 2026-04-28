<?php
namespace Src\Validator;

class ImageValidator extends AbstractValidator
{
    protected string $message = 'Поле :field должно содержать изображение';

    public function rule(): bool
    {
        if (empty($this->value) || ($this->value['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if (($this->value['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return false;
        }

        $tmpName = $this->value['tmp_name'] ?? '';
        if (!$tmpName || !is_uploaded_file($tmpName)) {
            return false;
        }

        $imageInfo = @getimagesize($tmpName);
        if (!$imageInfo) {
            return false;
        }

        return in_array($imageInfo['mime'] ?? '', [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
        ], true);
    }
}
