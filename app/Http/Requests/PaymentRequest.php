<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
use Redirect;

class PaymentRequest extends FormRequest
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

    public function messages()
    {
      return [
        // 'amount.required' => 'จำนวนเงินห้ามว่าง',
        // 'amount.regex' => 'จำนวนเงินไม่ถูกต้อง',
        'holder_name.required' => 'ชื่อเจ้าของบัตรห้ามว่าง',
        'card_number.required' => 'หมายเลขบัตรห้ามว่าง',
        // 'card_number.numeric' => 'หมายเลขบัตรไม่ถูกต้อง',
        'cvc.required' => 'CVC ห้ามว่าง',
        'cvc.numeric' => 'CVC ไม่ถูกต้อง',
        'card_expire.required' => 'วันหมดอายุห้ามว่าง',
      ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
        // 'amount' => 'required|regex:/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/',
        'holder_name' => 'required',
        'card_number' => 'required',
        'cvc' => 'required|numeric',
        'card_expire' => 'required'
      ];
    }

    public function forbiddenResponse()
    {
      return Response::make('Permission Denied!', 403);
    }

    public function response(array $errors) {
      return Redirect::back()->withErrors($errors)->withInput();
    }

}
