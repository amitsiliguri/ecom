<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Http\Requests\Admin\Catalog\Category;

use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Easy\Ecommerce\Rules\fileUploadRule;
use Illuminate\Validation\Rule;

/**
 * @package Easy\Ecommerce
 * @namespace Easy\Ecommerce\Http\Requests\Admin\Catalog\Category
 * @FormRequest
 */
class FormRequest extends HttpFormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'catalogCategory';

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
        $rule = [
            'title' => ['required', 'string'],
            'status' => ['required', 'boolean'],
            'banner' => [new fileUploadRule],
            'description' => ['nullable', 'string', 'max:500'],
            'meta_description' => ['nullable', 'string', 'max:170'],
            'meta_title' => ['nullable', 'string', 'max:60'],
            'meta_image' => [new fileUploadRule],
            'banner.*' => ['required', 'array:id,initial_sort_index,url,name,size,file,show'],
            'meta_image.*' => ['required', 'array:id,initial_sort_index,url,name,size,file,show'],
        ];
        if ($this->id) {
            $rule['id'] = ['required', 'integer'];
            $rule['slug'] = ['required', 'string', Rule::unique('catalog_categories', 'slug')->ignore($this->id)];
            $rule['banner.*.file'] = ['nullable', 'required_without:banner.*.id', 'image','mimes:png,jpeg,jpg','max:2048'];
            $rule['meta_image.*.file'] = ['nullable', 'required_without:banner.*.id', 'image','mimes:png,jpeg,jpg','max:2048'];
        } else {
            $rule['slug'] = ['required', 'string', Rule::unique('catalog_categories', 'slug')];
            $rule['banner.*.file'] = ['required', 'image','mimes:png,jpeg,jpg','max:2048'];
            $rule['meta_image.*.file'] = ['required', 'image','mimes:png,jpeg,jpg','max:2048'];
        }
        return $rule;
    }
}
