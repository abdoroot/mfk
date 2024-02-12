<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\ProviderSubscription;
use App\Http\Resources\API\UserSubscriptionResource;

class UserSubscriptionController extends Controller
{
    public function subscriptionList(Request $request)
    {
        $subscriptions = UserSubscription::where('status', 1);
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
}
