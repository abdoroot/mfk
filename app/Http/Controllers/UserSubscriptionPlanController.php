<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscriptionPlan;
use App\Models\StaticData;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\SubCategory;

class UserSubscriptionPlanController extends Controller
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
        $pageTitle = trans('messages.list_form_title',['form' => trans('messages.usersubscriptionsplan')] );
        $auth_user = authSession();
        $assets = ['datatable'];
        return view('usersubscriptionsplans.index', compact('pageTitle','auth_user','assets','filter'));
    }

    public function index_data(DataTables $datatable,Request $request)
    {
        $query = UserSubscriptionPlan::query();
        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }


        if (auth()->user()->hasAnyRole(['admin'])) {
            $query->newQuery();
        }
        
        return $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" onclick="dataTableRowCheck('.$row->id.')">';
            })
           
            ->editColumn('title', function($query){                
                if (auth()->user()->can('category edit')) {
                    $link = '<a class="btn-link btn-link-hover" href='.route('user-subscriptions-plan.create', ['id' => $query->id]).'>'.$query->title.'</a>';
                } else {
                    $link = $query->title; 
                }
                return $link;
            })

            ->editColumn('category', function($query){                
               $category = Category::find($query->category_id);
                return $category->name;
            })


            ->editColumn('status' , function ($query){
                return '<div class="custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline">
                    <div class="custom-switch-inner">
                        <input type="checkbox" class="custom-control-input  change_status" data-type="user_subscriptions_plan_status" '.($query->status ? "checked" : "").'   value="'.$query->id.'" id="'.$query->id.'" data-id="'.$query->id.'">
                        <label class="custom-control-label" for="'.$query->id.'" data-on-label="" data-off-label=""></label>
                    </div>
                </div>';
            })
            ->editColumn('amount' , function ($query){
                $price = !empty($query->amount)? getPriceFormat($query->amount) : '-'; 
                return $price;
            })
            ->addColumn('action', function($plan){
                return view('usersubscriptionsplans.action',compact('plan'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['title','action','status','check'])
            ->toJson();
    }

    /* bulck action method */
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = 'Bulk Action Updated';

        switch ($actionType) {
            case 'change-status':
                $branches = UserSubscriptionPlan::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = 'Bulk Plans Status Updated';
                break;

            case 'delete':
                UserSubscriptionPlan::whereIn('id', $ids)->delete();
                $message = 'Bulk Plans Deleted';
                break;

            default:
                return response()->json(['status' => false, 'message' => 'Action Invalid']);
                break;
        }

        return response()->json(['status' => true, 'message' => 'Bulk Action Updated']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->id;
        $auth_user = authSession();

        $plan = UserSubscriptionPlan::find($id);
        $plan_type = StaticData::where('type','user_subscription_plan_type')->get();
        $pageTitle = trans('messages.update_form_title',['form'=>trans('messages.usersubscriptionsplan')]);
        
        if($plan == null){
            $pageTitle = trans('messages.add_button_form',['form' => trans('messages.plan')]);
            $plan = new UserSubscriptionPlan;
        }
        
        return view('usersubscriptionsplans.create', compact('pageTitle' ,'plan' ,'auth_user','plan_type' ));
    }


    public function store(Request $request)
    {
        $requestData = $request->all();
        $plans = UserSubscriptionPlan::where('title', '=', $requestData['title'])->first();
        if ($plans !== null && $request->id == null) {
            return  redirect()->back()->withErrors(__('validation.unique',['attribute'=>__('messages.plan')]));
        }

        $planData = [
            'title' => $requestData['title'],
            'amount' => $requestData['amount'],
            'status' => $requestData['status'],
            'description' => $requestData['description'],
            'plan_type'=> $requestData['type'],
            'category_id'=> $requestData['category_id'],
            'subcategory_id'=> $requestData['subcategory_id']
        ];

        $planData['provider_id'] = !empty($request->provider_id) ? $request->provider_id : auth()->user()->id;
        
        if(empty($request->id) && $request->id == null){
            $planData['identifier'] = strtolower($requestData['title']["en"] ?? "");
        }

        $result = UserSubscriptionPlan::updateOrCreate(['id' => $requestData['id'] ],$planData);
        
        $message = trans('messages.update_form',['form' => trans('messages.plan')]);

        if($result->wasRecentlyCreated){
            $message = trans('messages.save_form',['form' => trans('messages.plan')]);
        }

        return redirect(route('user-subscriptions-plan.index'))->withSuccess($message);        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function destroy($id)
    {

        $plan = UserSubscriptionPlan::find($id);
        $msg= __('messages.msg_fail_to_delete',['item' => __('messages.plan')] );
        
        if($plan!='') {
            $plan->delete();
            $msg= __('messages.msg_deleted',['name' => __('messages.plan')] );
        }
        return comman_custom_response(['message'=> $msg, 'status' => true]);
    }
}
