<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubscriptionPlan;
use App\Models\ProviderSubscription;
use App\Http\Resources\API\UserSubscriptionResource;
use App\Http\Resources\API\UserSubscriptionDetailResource;
use App\Http\Resources\API\UserResource;

class UserSubscriptionPlanController extends Controller
{
    public function subscriptionPlanList(Request $request)
    {
        $subscriptions = UserSubscriptionPlan::where('status', 1);
        $user_id = auth()->id();
        
        $get_user_free_plan = ProviderSubscription::where('user_id', $user_id)->first();
        if (!empty($get_user_free_plan)) {
            $subscriptions = $subscriptions->whereNotIn('identifier', ['free']);
        }
        
        $orderBy = $request->orderby ? $request->orderby : 'asc';
        $per_page = config('constant.PER_PAGE_LIMIT');
        
        if ($request->has('per_page') && !empty($request->per_page)) {
            if (is_numeric($request->per_page)) {
                $per_page = $request->per_page;
            }
            if ($request->per_page === 'all') {
                $per_page = $subscriptions->count();
            }
        }

        $subscriptions = $subscriptions->orderBy('id', $orderBy)->paginate($per_page);
        $items = UserSubscriptionResource::collection($subscriptions);

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

    public function showPlan($id) {
        $plan = UserSubscriptionPlan::where('status',1)->with('providers','category','subcategory')->find($id);
        if(empty($plan)){
            $message = __('messages.record_not_found');
            return comman_message_response($message,406);   
        }

        $plan_detail = new UserSubscriptionDetailResource($plan);

        $response = [
            'service_detail'    => $plan_detail,
            'provider'          => new UserResource(optional($plan->providers)),
        ];

        return comman_custom_response($response);
    }
}
