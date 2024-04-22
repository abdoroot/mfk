<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StoreOrder;
use App\Http\Resources\API\OrderHistoryResource;

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
            'payment_type' => 'required|string|in:cash,stripe',
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

    public function getOrderList(Request $request){
        $order = StoreOrder::myOrder()->with('customer');

        if ($request->has('status') && isset($request->status)) {

            $status = explode(',', $request->status); 
            $order->whereIn('status', $status);
           
         }


        $per_page = config('constant.PER_PAGE_LIMIT');
        if( $request->has('per_page') && !empty($request->per_page)){
            if(is_numeric($request->per_page)){
                $per_page = $request->per_page;
            }
            if($request->per_page === 'all' ){
                $per_page = $order->count();
            }
        }
        $orderBy = 'desc';
        if( $request->has('orderby') && !empty($request->orderby)){
            $orderBy = $request->orderby;
        }

        $order = $order->orderBy('updated_at',$orderBy)->paginate($per_page);
        //$items = BookingResource::collection($order);
        $items = OrderHistoryResource::collection($order);

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
}
