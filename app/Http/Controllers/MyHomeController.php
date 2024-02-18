<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Myhome;
use App\Models\UserSubscriptionOrder;
use App\Models\UserSubscriptionPlan;
use App\Models\Category;
use Yajra\DataTables\DataTables;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyHomeController extends Controller
{
    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];
        $pageTitle = trans('messages.list_form_title', ['form' => trans('messages.myhome')]);
        $auth_user = authSession();
        $assets = ['datatable'];
        return view('myhome.index', compact('pageTitle', 'auth_user', 'assets', 'filter'));
    }

    public function index_data(DataTables $datatable, Request $request)
    {
        $query = Myhome::query();
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
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-' . $row->id . '"  name="datatable_ids[]" value="' . $row->id . '" data-type="category" onclick="dataTableRowCheck(' . $row->id . ',this)">';
            })

            ->editColumn('name', function ($query) {
                if (auth()->user()->can('category edit')) {
                    $link = '<a class="btn-link btn-link-hover" href=' . route('my-home.create', ['id' => $query->id]) . '>' . $query->name . '</a>';
                } else {
                    $link = $query->name;
                }
                return $link;
            })
            ->editColumn('address', function ($query) {
                return $query->address;
            })
            ->addColumn('action', function ($data) {
                return view('myhome.action', compact('data'))->render();
            })
            ->editColumn('status', function ($query) {
                $disabled = $query->trashed() ? 'disabled' : '';
                return '<div class="custom-control custom-switch custom-switch-text custom-switch-color custom-control-inline">
                    <div class="custom-switch-inner">
                        <input type="checkbox" class="custom-control-input  change_status" data-type="myhome_status" ' . ($query->status ? "checked" : "") . '  ' . $disabled . ' value="' . $query->id . '" id="' . $query->id . '" data-id="' . $query->id . '">
                        <label class="custom-control-label" for="' . $query->id . '" data-on-label="" data-off-label=""></label>
                    </div>
                </div>';
            })
            ->rawColumns(['action', 'status', 'check', 'name'])
            ->toJson();
    }


    public function create(Request $request)
    {
        $edit = false;
        $id = $request->id;
        $auth_user = authSession();

        $data = Myhome::find($id);

        $pageTitle = trans('messages.update_form_title', ['form' => trans('messages.myhome')]);

        if ($data == null) {
            $pageTitle = trans('messages.add_button_form', ['form' => trans('messages.myhome')]);
            $data = new Myhome;
        }

        return view('myhome.create', compact('pageTitle', 'data', 'auth_user'));
    }

    public function store(Request $request)
    {
        /*
           start transactions step are :
            1- create customer (customer_id)
            2- create myhome
            3- create special plan for it
            4- create plan order with start data and end date
            5- send customer login data via email
        */

        $data = $request->all();
        $data['provider_id'] = !empty($request->provider_id) ? $request->provider_id : auth()->user()->id;
        $now = Carbon::now();
    
        DB::beginTransaction();
        // 1- create customer (customer_id)
         $userData = [
            'id' => 37,
            'username' => $data["name"]["en"] ?? "",
            'first_name' => $data["name"]["en"] ?? "",
            'last_name' => '',
            'email' => $data["email"],
            'password' => bcrypt('12345678'),
            'user_type' => 'user',
            'contact_number' => $data["phone"],
            'country_id' => 229,
            'state_id' => 3800,
            'city_id' => 44580,
            'provider_id' => NULL,
            'address' => $data["address"]["en"],
            'player_id' => '02e39223-34ec-45c3-831b-f550af48c816',
            'status' => 1,
            'display_name' => $data["name"]["en"],
            'providertype_id' => NULL,
            'is_featured' => 0,
            'time_zone' => 'UTC',
            'last_notification_seen' => NULL,
            'email_verified_at' => NULL,
            'remember_token' => NULL,
            'deleted_at' => NULL,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'login_type' => NULL,
            'service_address_id' => NULL,
            'uid' => NULL,
            'handymantype_id' => NULL,
            'is_subscribe' => 0,
            'social_image' => NULL,
            'is_available' => 0,
            'designation' => NULL,
            'last_online_time' => NULL,
            'slots_for_all_services' => 0,
            'known_languages' => NULL,
            'skills' => NULL,
            'description' => NULL,
            'profile_image' => public_path('/images/profile-images/user/david.png'),
         ];
         $customer = User::create($userData);
         if(is_null($customer)){
            DB::rollBack();
        }

        // 2- create myhome
        $data["customer_id"] = $customer->id;
        $myhome = Myhome::updateOrCreate(['id' => $request->id ],$data);
        if(is_null($myhome)){
            DB::rollBack();
        }

        // 3- create special plan for it
        $planData = [
            'my_home_id' => $myhome->id,
            'provider_id' => auth()->user()->id,
            'title' => ["ar" => " خطة منزلي - ".$myhome->id,"en" => "my home plan - ".$myhome->id],
            'amount' => 0,
            'status' => 0,
            'description' => ["ar" =>"","en" => "&nbsp;"],
            'plan_type'=> 'yearly',
            'category_id'=> null,
            'subcategory_id'=> null
        ];

        $plan = UserSubscriptionPlan::create($planData);
        if(is_null($plan)){
            DB::rollBack();
        }


        // 4- create plan order with start data and end date
        $orderData = [
            "status"=>"completed",
            "provider_id"=> auth()->user()->id,
            "start_at"=> $now,
            "end_at"=> get_plan_expiration_date($now,$plan->plan_type),
            "date" => date('Y-m-d H:i:s',strtotime($request->date)) ,
            "provider_id" => auth()->user()->id,
            "plan_id" => $plan->id,
            "customer_id" => $customer->id,
            "quantity" => 1,
            "amount" => 0,
            "discount" => 0,
            "tax" => 0,
            "total_amount" => 0,
        ];
        
        $subscriptionOrder = UserSubscriptionOrder::updateOrCreate(['id' => $request->id], $orderData);
        if($subscriptionOrder->wasRecentlyCreated){
			$message = __('messages.save_form',[ 'form' => __('messages.myhome') ] );
		}
        DB::commit();

        //todo
        // 5- send customer login data via email
        return redirect(route('my-home.index'))->withSuccess($message);
    }

    public function update(Request $request)
    {
        $data =  $request->all();
        $result = Myhome::updateOrCreate(['id' => $data['id']], $data);
        $message = "";
        if($result->wasChanged()){
			$message = __('messages.update_form',[ 'form' => __('messages.myhome') ] );
		}
        if($message != ""){
            return redirect(route('my-home.index'))->withSuccess($message);
        }

        return redirect(route('my-home.index'));
        
    }

    /* bulck action method */
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);

        $actionType = $request->action_type;

        $message = 'Bulk Action Updated';

        switch ($actionType) {
            case 'change-status':

                $branches = Myhome::whereIn('id', $ids)->update(['status' => $request->status]);
                $message = 'Bulk Category Status Updated';
                break;

            case 'delete':
                Myhome::whereIn('id', $ids)->delete();
                $message = 'Bulk Category Deleted';
                break;

            case 'restore':
                Myhome::whereIn('id', $ids)->restore();
                $message = 'Bulk Category Restored';
                break;

            case 'permanently-delete':
                Myhome::whereIn('id', $ids)->forceDelete();
                $message = 'Bulk Category Permanently Deleted';
                break;

            default:
                return response()->json(['status' => false, 'is_featured' => false, 'message' => 'Action Invalid']);
                break;
        }

        return response()->json(['status' => true, 'is_featured' => true, 'message' => 'Bulk Action Updated']);
    }

    public function destroy($id)
    {
        $myhome = Myhome::find($id);
        $msg = __('messages.msg_fail_to_delete', ['name' => __('messages.myhome')]);

        if ($myhome != '') {
            $myhome->delete();
            $msg = __('messages.msg_deleted', ['name' => __('messages.myhome')]);
        }
        if (request()->is('api/*')) {
            return comman_message_response($msg);
        }
        return comman_custom_response(['message' => $msg, 'status' => true]);
    }

    public function action(Request $request)
    {
        $id = $request->id;
        $myhome = Myhome::withTrashed()->where('id', $id)->first();
        $msg = __('messages.t_found_entry', ['name' => __('messages.myhome')]);
        if ($request->type == 'restore') {
            $myhome->restore();
            $msg = __('messages.msg_restored', ['name' => __('messages.myhome')]);
        }
        if ($request->type === 'forcedelete') {
            $myhome->forceDelete();
            $msg = __('messages.msg_forcedelete', ['name' => __('messages.myhome')]);
        }
        if (request()->is('api/*')) {
            return comman_message_response($msg);
        }
        return comman_custom_response(['message' => $msg, 'status' => true]);
    }

}
