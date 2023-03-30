<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use App\Helpers\HttpRequests;
use App\Traits\CmsTrait;

class UsersController extends Controller
{
    use Helper, CmsTrait, HttpRequests;

    public function __construct()
    {
        //
    }
    public function OfType($type)
    {
        $type = strtoupper($type);
        $types = config('custom.users_type');
        if(in_array($type, $types)){ return $type; }
    }
    public function index(Request $request,  $type)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $type = $this->OfType($request->type);
        return view('backend.users.index', [ 'type' => $type ]);
    }
    public function data(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $param = [
            'type'   => $request->type,
            'search' => $request->search['value']
        ];

        $data = $this->get(config('custom.api_routes.users.index'), $param);
        if(!$data['success']){
            return $data;
        }
        return Datatables::of($data['data'])
        // ->addIndexColumn()
        ->addColumn('image', function ($user) {
            return $user["image"] ?? '';
        })
        ->addColumn('name', function ($user) {
            return $user['name'] ?? '';
        })
        ->addColumn('type', function ($user) {
            return __('base.rout_start.users.types.'.$user['type']) ?? '';
        })
        ->addColumn('username', function ($user) {
            return $user['username'] ?? '';
        })
        ->addColumn('phone_number', function ($user) {
            return $user['phone_number'] ?? '';
        })
        ->addColumn('email', function ($user) {
            return $user['email'] ?? '';
        })
        ->addColumn('verification_code', function ($user) {
            return $user['verification_code'] ?? '';
        })
        ->addColumn('status', function ($user) {
            return $user['status'] ?? '';
        })
        ->addColumn('registration_type', function ($user) {
            return $user['registration_type'] ?? '';
        })
        ->addColumn('created_at', function ($user) {
            return $user['created_at'] ?? '';
        })
        ->addColumn('actions', function($user) use($request){
            $actions   = [];
            if($user['deleted_at']) {
                $actions[] = [
                    'id'            => $user['id'],
                    'label'         => __('base.restore'),
                    'type'          => 'icon',
                    'link'          => route('users::restore', ['id' => $user['id'], 'type' => $user['type'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'user_restore_'.$user['id'],
                    'class'         => 'restore-action',
                    'icon'          => 'fas fa-trash-restore'
                ];
                $actions[] = [
                    'id'            => $user['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('users::delete', ['id' => $user['id'], 'type' => $user['type'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'delete_'.$user['id'],
                    'class'         => 'delete-action',
                    'icon'          => 'fas fa-user-times'
                ];
            } else {
                $actions[] = [
                    'id'            => $user['id'],
                    'label'         => __('base.soft_delete'),
                    'type'          => 'icon',
                    'link'          => route('users::soft_delete', ['id' => $user['id'], 'type' => $user['type'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'soft_delete_'.$user['id'],
                    'class'         => 'soft-delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                $actions[] = [
                    'id'            => $user['id'],
                    'label'         => __('base.update'),
                    'type'          => 'icon',
                    'link'          => route('users::edit', ['id' => $user['id'], 'type' => $user['type'] ]),
                    'method'        => 'GET',
                    'request_type'  => 'update_'.$user['id'],
                    'class'         => 'update-action',
                    'icon'          => 'fas fa-edit'
                ];
            }
            return $actions;
        })
        ->rawColumns([])
        ->make(true);
    }
    public function create(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $type = $this->OfType($request->type);
        return view('backend.users.create', [
            'type'          => $type,
            'countries'     => $this->Country(),
            'default'       => $this->default('user'),
        ]);
    }
    public function store(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = $this->post(config('custom.api_routes.users.create'), $request->all());
        if(!$user['success']){
            return $user;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
            'redirect_url'  => route('users', ['type' => $request->type])
        ], 200);
    }
    public function show(Request $request, $id)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = $this->get(config('custom.api_routes.users.edit').'/'.$id);
        if(!$user['success']){
            return $user;
        }
        return view('backend.users.update', [
            'user'           => $user['data'],
            'countries'      => $this->Country(),
            'defaultImage'   => $this->default('user')
        ]);
    }
    public function update(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }
        $user = $this->post(config('custom.api_routes.users.update'), $request->all());
        if(!$user['success']){
            return $user;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
            'redirect_url'  => route('users', ['type' => $request->type])
        ], 200);
    }
    public function softDelete(Request $request, $id)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = $this->post(config('custom.api_routes.users.soft_delete').'/'.$id);
        if(!$user['success']){
            return $user;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
        ], 200);
    }
    public function delete(Request $request, $id)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = $this->post(config('custom.api_routes.users.delete').'/'.$id);
        if(!$user['success']){
            return $user;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
        ], 200);
    }
    public function restore(Request $request, $id)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = $this->post(config('custom.api_routes.users.restore').'/'.$id);
        if(!$user['success']){
            return $user;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
        ], 200);
    }
    public function showOrder(Request $request)
    {
        return view('backend.users.order');
    }
    public function PackingOrder(Request $request)
    {
        $order = $this->get(config('custom.api_routes.packing.order'));
        if(!$order['success']){
            return $order;
        }
        return Datatables::of($order['data'])
        ->addIndexColumn()
        ->addColumn('from_user', function ($order) {
            return $order['order_from_user_id']['name'] ?? '';
        })
        ->addColumn('quantity', function ($order) {
            return $order['quantity'] ?? '';
        })
        ->addColumn('order_status', function ($order) {
            return $order['order_status'] ?? '';
        })
        ->addColumn('created_at', function ($order) {
            return $order['created_at'] ?? '';
        })
        ->addColumn('actions', function($order) use($request){
            $actions   = [];
            if(in_array($this->userType(), ["ROOT", "ADMIN"]))
            {
                $actions[] = [
                    'id'            => $order['id'],
                    'label'         => __('base.aproved'),
                    'type'          => 'icon',
                    'link'          => route('make_operations', ['type' => 'APPROVAL']),
                    'method'        => 'POST',
                    'request_type'  => 'aproved_'.$order['id'],
                    'class'         => 'aproved-action',
                    'icon'          => 'fas fa-check'
                ];
            }
            return $actions;
        })
        ->rawColumns([])
        ->make(true);
    }
    public function UnitsHistory(Request $request)
    {
        return view('backend.users.unit_history');
    }
    public function UnitsHistoryData(Request $request)
    {
        $unit = $this->get(config('custom.api_routes.history.unit'));
        if(!$unit['success']){
            return $unit;
        }
        return Datatables::of($unit['data'])
        ->addIndexColumn()
        ->addColumn('unit_code', function ($unit) {
            return $unit['unit_code'] ?? '';
        })
        ->addColumn('unit_value', function ($unit) {
            return $unit['unit_value'] ?? '';
        })
        ->addColumn('status', function ($unit) {
            return $unit['status'] ?? '';
        })
        ->addColumn('price', function ($unit) {
            return $unit['price'] ?? '';
        })
        ->addColumn('add_by', function ($unit) {
            return $unit['user']['name'] ?? '';
        })
        ->addColumn('unit_type', function ($unit) {
            return $unit['unit_type'][0]['type'] ?? '';
        })
        ->addColumn('created_at', function ($unit) {
            return $unit['created_at'] ?? '';
        })
        ->rawColumns([])
        ->make(true);
    }
    public function MoneyHistory(Request $request)
    {
        return view('backend.users.money_history');
    }
    public function MoneyHistoryData(Request $request)
    {
        $money = $this->get(config('custom.api_routes.history.money'));
        if(!$money['success']){
            return $money;
        }
        return Datatables::of($money['data'])
        ->addIndexColumn()
        ->addColumn('money_code', function ($money) {
            return $money['money_code'] ?? '';
        })
        ->addColumn('transfer_type', function ($money) {
            return $money['transfer_type'] ?? '';
        })
        ->addColumn('amount', function ($money) {
            return $money['amount'] ?? '';
        })
        ->addColumn('status', function ($money) {
            return $money['status'] ?? '';
        })
        ->addColumn('to_user', function ($money) {
            return $money['to_user']['name'] ?? '';
        })
        ->addColumn('from_user', function ($money) {
            return $money['from_user']['name'] ?? '';
        })
        ->addColumn('created_at', function ($money) {
            return $money['created_at'] ?? '';
        })
        ->rawColumns([])
        ->make(true);
    }
    public function UnitsMovement(Request $request)
    {
        return view('backend.users.units_movement');
    }
    public function UnitsMovementDate(Request $request)
    {
        $movement = $this->get(config('custom.api_routes.history.movement'));
        if(!$movement['success']){
            return $movement;
        }
        return Datatables::of($movement['data'])
        ->addIndexColumn()
        ->addColumn('unit_code', function ($movement) {
            return $movement['unit_code'] ?? '';
        })
        ->addColumn('transfer_type', function ($movement) {
            return $movement['transfer_type'] ?? '';
        })
        ->addColumn('quantity', function ($movement) {
            return $movement['quantity'] ?? '';
        })
        ->addColumn('status', function ($movement) {
            return $movement['status'] ?? '';
        })
        ->addColumn('to_user', function ($movement) {
            return $movement['to_user']['name'] ?? '';
        })
        ->addColumn('from_user', function ($movement) {
            return $movement['from_user']['name'] ?? '';
        })
        ->addColumn('created_at', function ($movement) {
            return $movement['created_at'] ?? '';
        })
        ->rawColumns([])
        ->make(true);
    }
    public function CheckOrder()
    {
        return $this->get(config('custom.api_routes.packing.check_orders'));
    }
    public function RefreshData()
    {
       $user = $this->get(config('custom.api_routes.packing.refresh_data'));
       return session()->put('_user', $user);
    }
}
