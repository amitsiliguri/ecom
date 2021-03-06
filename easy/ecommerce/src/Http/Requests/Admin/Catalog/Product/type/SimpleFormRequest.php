<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Http\Requests\Admin\Catalog\Product\type;

use Illuminate\Foundation\Http\FormRequest as HttpFormRequest;
use Illuminate\Validation\Rule;

class SimpleFormRequest extends HttpFormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'catalogProductSimple';

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
        $rules = [
            'status' => ['required', 'boolean'],
            'sku' => ['required', 'string'],
            'title' => ['required', 'string'],
            'small_description' => ['nullable', 'string', 'max:300'],
            'description' => ['nullable', 'string', 'max:1500'],
            'maintain_stock' => ['nullable', 'boolean'],
            'in_stock' => ['required', 'boolean'],
            'meta_title' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            'price.base_price' => ['required', 'string'],
            'price.special_price' => ['nullable', 'string'],
            'price.offer_start' => ['nullable', 'string'],
            'price.offer_end' => ['nullable', 'string'],
            'tier_prices.*.quantity' => ['sometimes', 'integer'],
            'tier_prices.*.special_price' => ['sometimes', 'string'],
            'tier_prices.*.customer_group_id' => ['sometimes', 'integer'],
            'tier_prices.*.offer_start' => ['nullable', 'string'],
            'tier_prices.*.offer_end' => ['nullable', 'string'],
            'stocks.*.quantity' => ['nullable', Rule::requiredIf($this->maintain_stock  === true), 'integer'],
            'stocks.*.inventory_id' => ['nullable', Rule::requiredIf($this->maintain_stock  === true), 'integer'],
            'categories.*' => ['integer','exists:catalog_categories,id']
        ];

        if ($this->id) {
            $rules['id'] = ['required', 'integer'];
            $rules['slug'] = ['required', 'string', Rule::unique('catalog_products', 'slug')->ignore($this->id)];
            $rules['images.*.file'] = ['nullable', 'required_without:images.*.id', 'image','mimes:png,jpeg,jpg','max:2048'];
            $rules['meta_image.*.file'] = ['nullable', 'required_without:images.*.id', 'image','mimes:png,jpeg,jpg','max:2048'];
        } else {
            $rules['slug'] = ['required', 'string', Rule::unique('catalog_products', 'slug')];
            $rules['images.*.file'] = ['nullable', 'image','mimes:png,jpeg,jpg','max:2048'];
            $rules['meta_image.*.file'] = ['nullable', 'image','mimes:png,jpeg,jpg','max:2048'];
        }
        return $rules;
    }
}
