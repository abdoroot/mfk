<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StoreOrder;

class StoreOrderController extends Controller
{
    public function store(Request $request){

        $validator = Validator::make(request()->all(), [
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer',
            'items.*.price' => 'required|numeric',
            'amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'discount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'shipping_address' => 'required|string',
            'payment_type' => 'required|string|in:cash_on_delivery,stripe',
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $message = __('messages.error',[ 'form' => __('messages.invalid_data') ] );
            $response = [
                'message' => $message,
                'errors'=> $errors,
            ];
            return comman_custom_response($response,404);
        }

        $data = $request->all();
        $data['status'] = 'pending';
        $data['customer_id'] = auth()->user()->id;

        //create order
        $result = StoreOrder::create($data);
        if($result->wasRecentlyCreated){
			$activity_data = [
                'activity_type' => 'add_store_order',
                'order_id' => $result->id,
                'order' => $result,
            ];
            //notify prvoider
            saveStoreOrderActivity($activity_data);

            $message = __('messages.save_form',[ 'form' => __('messages.order') ] );
            $response = [
                'message' => $message,
                'order_id'=> $result->id
            ];
            return comman_custom_response($response);
		}

        $message = __('messages.error',[ 'form' => __('messages.interal_error') ] );
        $response = [
            'message' => $message,
        ];
    
    }
}
