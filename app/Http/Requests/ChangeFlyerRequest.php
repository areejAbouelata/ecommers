<?php

namespace App\Http\Requests;

use App\Flyer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ChangeFlyerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return Flyer::where([
            'zip' =>$request->zip ,
            'street' => $request->street,
            'user_id' => auth()->user()->id
        ])->exists() ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|image|mimes:jpg,jpeg,png,bmp'
        ];
    }
}
