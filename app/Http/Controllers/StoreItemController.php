<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreItem;
use App\Models\User;
use App\Models\Setting;
use App\Http\Requests\StoreItemRequest;
use Yajra\DataTables\DataTables;

class StoreItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];
        $pageTitle = __('messages.list_form_title', ['form' => __('messages.store_item')]);
        $auth_user = authSession();
        $assets = ['datatable'];
        return view('store.item.index', compact('pageTitle', 'auth_user', 'assets', 'filter'));
    }

    // get datatable data
    public function index_data(DataTables $datatable, Request $request)
    {
        $query = StoreItem::query();

        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }

        return $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-' . $row->id . '"  name="datatable_ids[]" value="' . $row->id . '" data-type="item" onclick="dataTableRowCheck(' . $row->id . ',this)">';
            })
            ->editColumn('name', function($query){                
                if (auth()->user()->can('category edit')) {
                    $link =  '<a class="btn-link btn-link-hover" href='.route('store-item.create', ['id' => $query->id]).'>'.$query->name.'</a>';
                } else {
                    $link = $query->name; 
                }
                return $link;
            })
            ->editColumn('category_id', function ($query) {
                return ($query->category_id != null && isset($query->category)) ? $query->category->name : '-';
            })
            ->filterColumn('category_id', function ($query, $keyword) {
                $query->whereHas('category', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->editColumn('provider_id', function ($query) {
                return view('service.service', compact('query'));
            })
            ->editColumn('price' , function ($query){
                return getPriceFormat($query->price);
            })
            
            ->editColumn('discount' , function ($query){
                return $query->discount ? $query->discount .'%' : '-';
            })
            ->addColumn('action', function ($data) {
                return view('store.item.action', compact('data'));
            })
            ->editColumn('status', function ($query) {
                $disabled = $query->trashed() ? 'disabled' : '';
                return '<div class="custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline">
                    <div class="custom-switch-inner">
                        <input type="checkbox" class="custom-control-input  change_status" data-type="store_item_status" ' . ($query->status ? "checked" : "") . '  ' . $disabled . ' value="' . $query->id . '" id="' . $query->id . '" data-id="' . $query->id . '">
                        <label class="custom-control-label" for="' . $query->id . '" data-on-label="" data-off-label=""></label>
                    </div>
                </div>';
            })
            ->rawColumns(['action', 'status', 'check','name'])
            ->toJson();
    }

    public function create(Request $request)
    {
        $id = $request->id;
        $auth_user = authSession();

        $storeItemData = StoreItem::find($id);

        $settingdata = Setting::where('type', '=', 'ADVANCED_PAYMENT_SETTING')->first();

        $pageTitle = __('messages.update_form_title', ['form' => __('messages.store_item')]);

        if ($storeItemData == null) {
            $pageTitle = __('messages.add_button_form', ['form' => __('messages.store_item')]);
            $storeItemData = new StoreItem;
        }

        return view('store.item.create', compact('pageTitle', 'storeItemData', 'auth_user', 'settingdata'));
    }

    public function store(StoreItemRequest $request)
    {
        $item = $request->all();

        if ($request->id == null) {
            $item['added_by'] =  !empty($request->added_by) ? $request->added_by : auth()->user()->id;
        }

        $item['provider_id'] = !empty($item['provider_id']) ?  $item['provider_id']     : auth()->user()->id;
        if (!empty($request->advance_payment_amount)) {
            $item['advance_payment_amount'] = $request->advance_payment_amount;
        }

        $item["is_featured"] = $request->has("is_featured") ? 1 : 0;
        $result = StoreItem::updateOrCreate(['id' => $request->id], $item);

        if ($request->is('api/*')) {
            if ($request->has('attachment_count')) {
                for ($i = 0; $i < $request->attachment_count; $i++) {
                    $attachment = "store_item_attachment_" . $i;
                    if ($request->$attachment != null) {
                        $file[] = $request->$attachment;
                    }
                }
                storeMediaFile($result, $file, 'store_item_attachment');
            }
        } else {
            storeMediaFile($result, $request->store_item_attachment, 'store_item_attachment');
        }

        $message = __('messages.update_form', ['form' => __('messages.item')]);
        if ($result->wasRecentlyCreated) {
            $message = __('messages.save_form', ['form' => __('messages.item')]);
        }

        if ($request->is('api/*')) {
            $response = [
                'message' => $message,
                'item_id' => $result->id
            ];
            return comman_custom_response($response);
        }
        return redirect(route('store-item.index'))->withSuccess($message);
    }

    public function destroy($id)
    {
        $item = StoreItem::find($id);
        $msg= __('messages.msg_fail_to_delete',['item' => __('messages.item')] );
        
        if($item!='') {
            $item->delete();
            $msg= __('messages.msg_deleted',['name' => __('messages.item')] );
        }
        if(request()->is('api/*')){
            return comman_custom_response(['message'=> $msg , 'status' => true]);
        }
        return comman_custom_response(['message'=> $msg, 'status' => true]);
    }

    public function action(Request $request){
        $id = $request->id;
        $item = StoreItem::withTrashed()->where('id',$id)->first();
        $msg = __('messages.not_found_entry',['name' => __('messages.item')] );
        if($request->type === 'restore'){
            $item->restore();
            $msg = __('messages.msg_restored',['name' => __('messages.item')] );
        }

        if($request->type === 'forcedelete'){
            $item->forceDelete();
            $msg = __('messages.msg_forcedelete',['name' => __('messages.item')] );
        }

        return comman_custom_response(['message'=> $msg , 'status' => true]);
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = 'Bulk Action Updated';

        
        switch ($actionType) {
            case 'change-status':
                $branches = StoreItem::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = 'Bulk Service Status Updated';
                break;

            case 'delete':
                StoreItem::whereIn('id', $ids)->delete();
                $message = 'Bulk Service Deleted';
                break;

            case 'restore':
                StoreItem::whereIn('id', $ids)->restore();
                $message = 'Bulk Service Restored';
                break;
                
            case 'permanently-delete':
                StoreItem::whereIn('id', $ids)->forceDelete();
                $message = 'Bulk Service Permanently Deleted';
                break;

            default:
                return response()->json(['status' => false, 'message' => 'Action Invalid']);
                break;
        }

        return response()->json(['status' => true, 'message' => 'Bulk Action Updated']);
    }
}
