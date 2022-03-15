<?php

namespace App\Http\Requests;

use App\Enum\AdvertisementType;
use App\Rules\MaxWords;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementStoreRequest extends FormRequest
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
            'title' => 'required|min:2|max:255',
            'description' => ['required', 'min:10', new MaxWords(500)],
            'type' => ['required', new Enum(AdvertisementType::class)],
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'tags_ids' => 'sometimes|required|array|exists:tags,id',
            'start_date' => 'required|date|date_format:Y-m-d H:ia|after_or_equal:' . now()->format('Y-m-d H:ia'),
        ];
    }
}
