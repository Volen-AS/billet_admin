<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       //return auth()->check();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=> 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'string|max:500|min:3',
            'parent_id' => 'required|integer|exists:blog_categories,id',
        ];
    }

    //    /**
//     *Get the error messages for the defined validation rules
//     *
//     *@return  array
//     */
//    public function messages()
//    {
//        return [
//            'title.required' => 'Input title of post',
//            'content_raw' => 'min lenght for article [:min] characters'
//        ];
//    }
//
//    /**
//     *Get custom attributes for validator errors
//     *
//     * @return array
//     */
//
//    public  function attributes() {
//        return [
//            'title' => 'Заголовок',
//        ];
//    }
}
