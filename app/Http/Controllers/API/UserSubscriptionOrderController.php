<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubscriptionOrder as Order;
use App\Models\UserSubscriptionPlan as Plan;
use App\Http\Requests\CreateUserSubscriptionOrderRequest;
use App\Models\Coupon;
use App\Http\Resources\API\UserSubscribeOrderResource;
use App\Models\Payment;

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
        $data['customer_id'] = auth()->user()->id;
        
        if($request->has('tax') && $request->tax != null) {
            $data['tax'] = json_encode($request->tax);
        }


        if(!$request->has('quantity')) {
            $data['quantity'] = 1;
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

    public function index(Request $request){
        $user_id = auth()->id();
        $subscription_history = Order::where('customer_id',$user_id);
        $per_page = config('constant.PER_PAGE_LIMIT');
        $orderBy = $request->orderby ? $request->orderby: 'asc';
        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page === 'all' ){
                $per_page = $subscription_history->count();
            }
        }
        $subscription_history = $subscription_history->orderBy('id',$orderBy)->paginate($per_page);
        $items = UserSubscribeOrderResource::collection($subscription_history);
        $response = [
            'pagination' => [
                'total_items' => $items->total(),
                'per_page' => $items->perPage(),
                'currentPage' => $items->currentPage(),
                'totalPages' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
                'next_page' => $items->nextPageUrl(),
                'previous_page' => $items->previousPageUrl(),
            ],
            'data' => $items,
        ];

        return comman_custom_response($response);
    }

    public function show(Request $request,$id){
        $order = Order::where('id',$id,);
        $subscription = $order->first();
        $item = new UserSubscribeOrderResource($subscription);
        $payments = Payment::where("subscription_id",$item->id)->get();//subscription_id
        $response = [
            'data' => $item,
            'payments' => $payments,
        ];

        return comman_custom_response($response);
    }
}
