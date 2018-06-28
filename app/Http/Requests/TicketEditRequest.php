<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketEditRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
            'priority' => 'required',
            'storyPoints' => 'required|numeric',
            'project' => 'required|max:255',
        ];
    }

}
