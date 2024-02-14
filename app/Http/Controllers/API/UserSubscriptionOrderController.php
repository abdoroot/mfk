<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubscriptionOrder as Order;
use App\Models\UserSubscriptionPlan as Plan;
use App\Http\Requests\CreateUserSubscriptionOrderRequest;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\User;

class UserSubscriptionOrderController extends Controller
{
    public function store(CreateUserSubscriptionOrderRequest $request)  {
        $data = $request->all();

        if($request->id == null)
        {
            $data['status'] = !empty($data['status']) ? $data['status'] :'pending';
        }  
        $data['date'] = isset($request->date) ? date('Y-m-d H:i:s',strtotime($request->date)) : date('Y-m-d H:i:s');
        $plan_data = Plan::find($data['plan_id']);
        
        $data['provider_id'] = !empty($data['provider_id']) ? $data['provider_id']: $plan_data->provider_id;
        
        if($request->has('tax') && $request->tax != null) {
            $data['tax'] = json_encode($request->tax);
        }

        if(!$request->has('amount')) {
            $data['amount'] = $plan_data->amount;
        }

        if($request->coupon_id != null) {
            $coupons = Coupon::where('code',$request->coupon_id)
                ->where('expire_date','>',date('Y-m-d H:i'))->where('status',1)
                ->where('','subscription_orders')//Todo alter coupon to support our orders; //abdoroot
                ->first();
            if( $coupons == null ) {
                return comman_message_response( __('messages.invalid_coupon_code'),406);
            } else {
                $data['coupon_id'] = $coupons->id;
            }
        }

        $result = Order::updateOrCreate(['id' => $request->id], $data);

        if($result->wasRecentlyCreated){
			$message = __('messages.save_form',[ 'form' => __('messages.booking') ] );
            sendUserSubscriptionOrderNotification($result);
		}

        $response = [
            'message'=>$message,
            'order_id' => $result->id
        ];

        return comman_custom_response($response,201);
    }
}
