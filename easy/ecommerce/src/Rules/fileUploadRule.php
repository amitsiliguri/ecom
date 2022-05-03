<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @fileUploadRule
 */
class fileUploadRule implements Rule
{
    /**
     * @var string
     */
    protected string $field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->field = 'File';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->field = $attribute;
        $needToRemove = 0;
        $newFileUpload = 0;
        $isPassed = true;
        if (is_array($value) && count($value) > 0) {
            foreach ($value as $key => $item) {
                if ( $item['id'] && (bool) $item['show'] === false  && $item['file'] === null) {
                    $needToRemove++;
                }
                if ( !$item['id'] && $item['file'] !== null) {
                    $newFileUpload++;
                }
            }
            if ($newFileUpload === 0 && $needToRemove === count($value)) {
                $isPassed = false;
            }
        } else {
            $isPassed = false;
        }

        return $isPassed;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'No ' . $this->field . ' uploaded.';
    }
}
