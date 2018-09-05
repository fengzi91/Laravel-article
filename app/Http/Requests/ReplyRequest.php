<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        return [
            'content' => 'required|min:2|clean',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '请填写内容',
            'content.min' => '至少2个字符',
            'content.clean' => '内容包含非法字符',
        ];
    }
}
