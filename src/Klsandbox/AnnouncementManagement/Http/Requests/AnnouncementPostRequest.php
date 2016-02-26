<?php

namespace Klsandbox\AnnouncementManagement\Http\Requests;

use Klsandbox\RoleModel\Role;

class AnnouncementPostRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->role->name == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delivery_mode' => 'in:SMS',
            'role_id' => 'required|numeric|in:' . Role::Stockist()->id,
            'description' => 'required|max:140',
        ];
    }

}
