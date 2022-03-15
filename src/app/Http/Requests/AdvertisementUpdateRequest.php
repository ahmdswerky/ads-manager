<?php

namespace App\Http\Requests;

use App\Rules\MaxWords;
use App\Enum\AdvertisementType;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementUpdateRequest extends FormRequest
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
        return [
            'title' => 'sometimes|required|min:2|max:255',
            'description' => ['sometimes', 'required', 'min:10', new MaxWords(500)],
            'type' => ['sometimes', 'required', new Enum(AdvertisementType::class)],
            'user_id' => 'sometimes|required|exists:users,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'start_date' => 'sometimes|required|date_format:Y-m-d H:ia|after_or_equal:now',
            'tags_ids' => 'array',
            'tags_ids.*' => 'nullable|exists:tags,id',
        ];
    }
}
