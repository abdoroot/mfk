<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Service;
use App\Models\Payment;
use App\Models\BookingStatus;
use App\Models\UserSubscriptionOrder;
use Carbon\Carbon;

class UserSubscriptionOrderController extends Controller
{
    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];
        $pageTitle = __('messages.list_form_title', ['form' => __('messages.userSubscriptionOrder')]);
        $auth_user = authSession();
        $assets = ['datatable'];
        return view('usersubscriptionorder.index', compact('pageTitle', 'auth_user', 'assets', 'filter'));
    }


    
    public function index_data(DataTables $datatable,Request $request)
    {
        $query = UserSubscriptionOrder::query()->myOrder();
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
            ->editColumn('id' , function ($query){
                return "<a class='btn-link btn-link-hover' href=" .route('user-subscriptions.show', $query->id).">#".$query->id ."</a>";
            })
            // ->editColumn('customer_id' , function ($query){
            //     return ($query->customer_id != null && isset($query->customer)) ? $query->customer->display_name : '';
            // })
            ->editColumn('customer_id' , function ($query){
                return view('usersubscriptionorder.customer', compact('query'));
            })
            ->filterColumn('customer_id',function($query,$keyword){
                $query->whereHas('customer',function ($q) use($keyword){
                    $q->where('display_name','like','%'.$keyword.'%');
                });
            })
            ->editColumn('service_id' , function ($query){
                $plan_name = $query->plan()->first()->title;
                //$plan_name = ($query->plan_id != null && isset($query->plan)) ? $query->plan->name : "pp";
                return "<a class='btn-link btn-link-hover' href=" .route('user-subscriptions.show', $query->id).">".$plan_name ."</a>";
            })
            // ->filterColumn('service_id',function($query,$keyword){
            //     $query->whereHas('plan',function ($q) use($keyword){
            //         $q->where('name','like','%'.$keyword.'%');
            //     });
            // })
            // ->editColumn('provider_id' , function ($query){
            //     return ($query->provider_id != null && isset($query->provider)) ? $query->provider->display_name : '';
            // })
            ->editColumn('provider_id' , function ($query){
                return view('usersubscriptionorder.provider', compact('query'));
            })
            ->filterColumn('provider_id',function($query,$keyword){
                $query->whereHas('provider',function ($q) use($keyword){
                    $q->where('display_name','like','%'.$keyword.'%');
                });
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

            ->addColumn('action', function($booking){
                return view('usersubscriptionorder.action',compact('booking'))->render();
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
        return $id;
    }
}
