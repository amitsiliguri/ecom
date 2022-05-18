<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Http\Requests\Admin\Customer;

use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;

class GroupFromRequest extends HttpFormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'customerGroup';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer'],
            'title' => ['required', 'string'],
            'status' => ['required', 'boolean']
        ];
    }
}
