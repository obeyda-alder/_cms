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

        return Datatables::of($data['data'])
        ->addIndexColumn()
        ->addColumn('name', function ($user) {
            return $user['name'] ?? '';
        })
        ->addColumn('type', function ($user) {
            return $user['type'] ?? '';
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

        $user = $this->post(config('custom.api_routes.users.edit').'/'.$id);
        if(!$user['success']){
            return $user;
        }
        return view('backend.users.update', [
            'user'           => $user,
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

        $UpdateUserValidator = [
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,id,'.$request->user_id,
            'password'           => 'nullable|string|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
        ];
        $validator = Validator::make($request->all(), $UpdateUserValidator);
        if(!$validator->fails())
        {
            try{
                DB::transaction(function() use ($request) {
                    $user                   = User::find($request->user_id);
                    $user->name             = $request->name;
                    $user->email            = $request->email;
                    $user->username         = $request->username;
                    $user->phone_number     = $request->phone_number;
                    $user->country_id       = $request->country_id;
                    $user->city_id          = $request->city_id;
                    $user->municipality_id  = $request->municipality_id;
                    $user->neighborhood_id  = $request->neighborhood_id;
                    if($request->has('password') && !is_null($request->password)) {
                        $user->password  = Hash::make($request->password);
                    }
                    $user->save();
                });
            }catch (Exception $e){
                return response()->json([
                    'success'     => false,
                    'type'        => 'error',
                    'title'       => __('base.msg.error_message.title'),
                    'description' => __('base.msg.error_message.description'),
                    'errors'      => '['. $e->getMessage() .']'
                ], 500);
            }
        }else {
            return response()->json([
                'success'     => false,
                'type'        => 'error',
                'title'       => __('base.msg.validation_error.title'),
                'description' => __('base.msg.validation_error.description'),
                'errors'      => $validator->getMessageBag()->toArray()
            ], 402);
        }
        return response()->json([
            'success'       => true,
            'type'          => 'success',
            'title'         => __('base.msg.success_message.title'),
            'description'   => __('base.msg.success_message.description'),
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
}
