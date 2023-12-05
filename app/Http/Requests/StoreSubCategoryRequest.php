<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request()->id;
        info($this->all());
        return [
            //'name'              => 'required|unique:sub_categories,name,'.$id,
            'name' => 'required|array',
            'status' => 'required',
            'store_category_id' => 'required',
            // 'subcategory_image'    => 'mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg',
        ];
    }
}
