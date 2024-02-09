<?php

namespace App\Shop\Products\Requests;

use App\Shop\Base\BaseFormRequest;

class EvaluatedRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return 
        [
            'product' => ['required', 'integer'],
            'evaluat' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:100']
        ];
    }
}
