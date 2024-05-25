<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreItem;
use App\Http\Resources\API\StoreItemResource;
use App\Http\Resources\API\UserResource;

class StoreItemController extends Controller
{
    public function getItemList(Request $request)
    {
        $items = StoreItem::where('status', 1);
        
        $orderBy = $request->orderby ? $request->orderby : 'asc';
        $per_page = config('constant.PER_PAGE_LIMIT');
        
        if ($request->has('per_page') && !empty($request->per_page)) {
            if (is_numeric($request->per_page)) {
                $per_page = $request->per_page;
            }
            if ($request->per_page === 'all') {
                $per_page = $items->count();
            }
        }

        $items = $items->orderBy('id', $orderBy)->paginate($per_page);
        $itemsResource = StoreItemResource::collection($items);

        $response = [
            'pagination' => [
                'total_items' => $itemsResource->total(),
                'per_page' => $itemsResource->perPage(),
                'currentPage' => $itemsResource->currentPage(),
                'totalPages' => $itemsResource->lastPage(),
                'from' => $itemsResource->firstItem(),
                'to' => $itemsResource->lastItem(),
                'next_page' => $itemsResource->nextPageUrl(),
                'previous_page' => $itemsResource->previousPageUrl(),
            ],
            'data' => $itemsResource,
        ];

        return comman_custom_response($response);
    }

    public function getItemById(Request $request)
    {
        $id = $request->id;
        $item = StoreItem::findOrFail($id);
        $item_detail = new StoreItemResource($item);

        $response = [
            'item_detail'    => $item_detail,
            'provider'          => new UserResource(optional($item->providers)),
        ];
        return comman_custom_response($response);
    }

}
