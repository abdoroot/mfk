<?php

namespace App\Http\Controllers;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\BookingStatus;
use App\Models\StoreOrder;
use App\Models\User;
use Carbon\Carbon;

class StoreOrderController extends Controller
{
    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];
        $pageTitle = __('messages.list_form_title', ['form' => __('messages.orders')]);
        $auth_user = authSession();
        $assets = ['datatable'];
        return view('store.order.index', compact('pageTitle', 'auth_user', 'assets', 'filter'));
    }

    public function index_data(DataTables $datatable,Request $request)
    {
        $query = StoreOrder::query();
        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }
        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->withTrashed();
        }
        
        return $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="booking" onclick="dataTableRowCheck('.$row->id.',this)">';
            })
            ->addColumn('date', function ($row) {
                return $row->created_at;
            })
            ->editColumn('id' , function ($query){
                return "<a class='btn-link btn-link-hover' href=" .route('store-order.show', $query->id).">#".$query->id ."</a>";
            })
            ->editColumn('customer_id' , function ($query){
                return view('store.order.customer', compact('query'));
            })
            ->filterColumn('customer_id',function($query,$keyword){
                $query->whereHas('customer',function ($q) use($keyword){
                    $q->where('display_name','like','%'.$keyword.'%');
                });
            })
            ->editColumn('provider_id' , function ($query){
                return '';
            })
            ->editColumn('status' , function ($query){
                return bookingstatus(BookingStatus::bookingStatus($query->status));
            })
            ->editColumn('payment_id' , function ($query){
                $payment_status = optional($query->payment)->payment_status;
                if($payment_status !== 'paid'){
                    $status = '<span class="badge badge-pay-pending">'.__('messages.pending').'</span>';
                }else{
                    $status = '<span class="badge badge-paid">'.__('messages.paid').'</span>';
                }
                return  $status;
            })
            ->filterColumn('payment_id',function($query,$keyword){
                $query->whereHas('payment',function ($q) use($keyword){
                    $q->where('payment_status','like',$keyword.'%');
                });
            })
            ->editColumn('total_amount' , function ($query){
                return $query->total_amount ? getPriceFormat($query->total_amount) : '-';
            })

            ->addColumn('action', function($order){
                return view('store.order.action',compact('order'))->render();
            })

            ->editColumn('updated_at', function ($query) {
                $diff = Carbon::now()->diffInHours($query->updated_at);
                if ($diff < 25) {
                    return $query->updated_at->diffForHumans();
                } else {
                    return $query->updated_at->isoFormat('llll');
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action','status','payment_id','service_id','id','check'])
            ->toJson();
    }

    public function show($id)
    {
      $auth_user = authSession();

         $user = auth()->user();
         $user->last_notification_seen = now();
         $user->save();

         if(count($user->unreadNotifications) > 0 ) {

           foreach($user->unreadNotifications as $notifications){

              if($notifications['data']['id'] == $id){

                 $notification = $user->unreadNotifications->where('id', $notifications['id'])->first();
                if($notification){
                     $notification->markAsRead();
                       }
                  }
        
             }
                  
        }

        $orderdata = StoreOrder::find($id);
        $tabpage = 'info';
        if (empty($orderdata)) {
            $msg = __('messages.not_found_entry', ['name' => __('messages.order')]);
            return redirect(route('store-order.index'))->withError($msg);
        }
        if (count($auth_user->unreadNotifications) > 0) {
            $auth_user->unreadNotifications->where('data.id', $id)->markAsRead();
        }

        $pageTitle = __('messages.view_form_title', ['form' => __('messages.order')]);
        return view('store.order.view', compact('pageTitle', 'orderdata', 'auth_user', 'tabpage'));
    }

    public function orderStatus(Request $request, $id)
    {
        $tabpage = $request->tabpage;
        $auth_user = authSession();
        $user_id = $auth_user->id;
        $user_data = User::find($user_id);
        $orderdata = StoreOrder::with('payment')->find($id);
        switch ($tabpage) {
            case 'info':
                $data  = view('store.order.' . $tabpage, compact('user_data', 'tabpage', 'auth_user', 'orderdata'))->render();
                break;
            case 'status':
                $data  = view('store.order.' . $tabpage, compact('user_data', 'tabpage', 'auth_user', 'orderdata'))->render();
                break;
            default:
                $data  = view('store.order.' . $tabpage, compact('tabpage', 'auth_user', 'orderdata'))->render();
                break;
        }
        return response()->json($data); 
    }

    public function changeOrderStatusForm(Request $request) {
        $orderdata = StoreOrder::find($request->id);
        $orderStatus = getOrdersStatus();
        $pageTitle = __('messages.assign_form_title',['form'=> __('messages.order')]);
        return view('store.order.change_order_status_form',compact('orderStatus','pageTitle','orderdata'));
    }

    public function changeOrderStatus(Request $request) {
        $id = $request->id;
        $status = $request->status;
        $orderdata = StoreOrder::find($id);
        $resp = StoreOrder::where("id",$id)->update([
            "status" => $status,
        ]);
        
        $customer_name = $orderdata->customer->display_name;
        $notification_data = [
            'id' => $orderdata->id,
            'type' => 'update_store_order_status',
            'subject' => 'update_store_order_status',
            'message' => __('messages.store_order_status_changed', ['name' => $customer_name]),
            "ios_badgeType" => "Increase",
            "ios_badgeCount" => 1,
            "notification-type" => 'update_store_order_status'
        ];

        $user = $user = \App\Models\User::getUserByKeyValue('id', $orderdata->customer_id);
        sendNotification('user', $user, $notification_data);

        $message = __('messages.save_form',[ 'form' => __('messages.order_status') ] );
        return response()->json(['status' => true,'event' => 'callback' , 'message' => $message]);
    }

    public function destroy($id)
    {

        $plan = StoreOrder::find($id);
        $msg= __('messages.msg_fail_to_delete',['item' => __('messages.order')] );
        
        if($plan!='') {
            $plan->delete();
            $msg= __('messages.msg_deleted',['name' => __('messages.order')] );
        }
        return comman_custom_response(['message'=> $msg, 'status' => true]);
    }

    public function action(Request $request){
        $id = $request->id;
        $order = StoreOrder::withTrashed()->where('id',$id)->first();
        $msg = __('messages.not_found_entry',['name' => __('messages.item')] );
        if($request->type === 'restore'){
            $order->restore();
            $msg = __('messages.msg_restored',['name' => __('messages.item')] );
        }

        if($request->type === 'forcedelete'){
            $order->forceDelete();
            $msg = __('messages.msg_forcedelete',['name' => __('messages.item')] );
        }

        return comman_custom_response(['message'=> $msg , 'status' => true]);
    }

       /* bulck action method */
       public function bulk_action(Request $request)
       {
           $ids = explode(',', $request->rowIds);
   
           $actionType = $request->action_type;
   
           $message = 'Bulk Action Updated';
   
           switch ($actionType) {
               case 'change-status':
                   $branches = StoreOrder::whereIn('id', $ids)->update(['status' => $request->status]);
                   $message = 'Bulk Plans Status Updated';
                   break;
   
               case 'delete':
                    StoreOrder::whereIn('id', $ids)->delete();
                    $message = 'Bulk Plans Deleted';
                    break;
   
               default:
                    return response()->json(['status' => false, 'message' => 'Action Invalid']);
                    break;
           }
   
           return response()->json(['status' => true, 'message' => 'Bulk Action Updated']);
       }
}
