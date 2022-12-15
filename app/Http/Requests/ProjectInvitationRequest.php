<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectInvitationRequest extends FormRequest
{

    protected $errorBag = 'invitations';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('owner', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', Rule::notIn($this->user()->email), 'exists:users']
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'This Email isn\'t associated with a valid account.',
            'email.not_in' => 'You cannot invite yourself.'
        ];
    }
}
