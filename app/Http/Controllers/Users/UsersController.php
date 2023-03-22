<?php

namespace App\Http\Controllers\Users;

use Illuminate\Contracts\Support\Renderable;
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
        $types = config('custom.users_type'); //
        if(in_array($type, $types)){
            return $type;
        }
    }
    public function index(Request $request)
    {
        $type = $this->OfType($request->type);
        return view('backend.users.index', [
            'type' => $type
        ]);
    }
    public function data(Request $request)
    {
        $data = $this->get('users/u/all_users_data', ['type' => $request->type]);

        return Datatables::of($data['data'])
        ->filter(function($query) use ($request) {
            if(!is_null($request->search['value']))
            {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search['value']}%")
                    ->orWhere('email', 'like', "%{$request->search['value']}%")
                    ->orWhere('type', 'like', "%{$request->search['value']}%");
                });
            }
        })
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
                    'link'          => route('users::restore', ['id' => $user['id'], 'type' => $request['type'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'user_restore_'.$user['id'],
                    'class'         => 'restore-action',
                    'icon'          => 'fas fa-trash-restore'
                ];
                $actions[] = [
                    'id'            => $user['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('users::delete', ['id' => $user['id'], 'type' => $request['type'] ]),
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
                    'link'          => route('users::soft_delete', ['id' => $user['id'], 'type' => $request['type'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'soft_delete_'.$user['id'],
                    'class'         => 'soft-delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                $actions[] = [
                    'id'            => $user['id'],
                    'label'         => __('base.update'),
                    'type'          => 'icon',
                    'link'          => route('users::edit', ['id' => $user['id'], 'type' => $request['type'] ]),
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
        if(!in_array(auth()->user()->type, ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $type = $this->OfType($request->type);
        $countries = $this->getCountry(app()->getLocale());
        $defaultImage = $this->getImageDefaultByType('user');
        return view('backend.users.create', [
            'type'          => $type,
            'countries'     => $countries,
            'defaultImage'  => $defaultImage
        ]);
    }
    public function store(Request $request)
    {
        if(!in_array(auth()->user()->type, ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }
        $userValidator = [
            'name'               => 'required|string|max:255',
            'email'              => 'required|unique:users|email',
            'password'           => 'required|string|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'confirm_password'   => 'required|same:password',
            'type'               => 'required|in:ADMINS,EMPLOYEES,CUSTOMERS,AGENCIES',
        ];

        // dd($request->image);

        $validator = Validator::make($request->all(), $userValidator);
        if(!$validator->fails())
        {
            try{
                DB::transaction(function() use ($request) {
                    $user = User::create([
                        'name'             => $request->name,
                        'email'            => $request->email,
                        'type'             => $request->type,
                        'username'         => $request->username,
                        'phone_number'     => $request->phone_number,
                        'country_id'       => $request->country_id,
                        'city_id'          => $request->city_id,
                        'municipality_id'  => $request->municipality_id,
                        'neighborhood_id'  => $request->neighborhood_id,
                        'password'         => Hash::make($request->password),
                    ]);

                    if($request->has('image')){
                        $this->UploadResizeImage($request);
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
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
            'redirect_url'  => route('users', ['type' => $request->type])
        ], 200);
    }
    public function show(Request $request, $id)
    {
        if(!in_array(auth()->user()->type, ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }
        $user = User::find($id);
        $defaultImage = $this->getImageDefaultByType('user');
        $countries = $this->getCountry(app()->getLocale());
        return view('backend.users.update', [
            'user'           => $user,
            'countries'      => $countries,
            'defaultImage'  => $defaultImage
        ]);
    }
    public function update(Request $request)
    {
        dd($request->file('logo'));

        if(!in_array(auth()->user()->type, ["ROOT", "ADMIN"]))
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
        if(!in_array(auth()->user()->type, ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = User::withTrashed()->find($id);
        if(!is_null($user)){
            $user->delete();
        } else {
            return response()->json([
                'success'     => false,
                'type'        => 'error',
                'title'       => __('base.msg.error_message.title'),
                'description' => __('base.msg.error_message.description'),
            ], 500);
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
        if(!in_array(auth()->user()->type, ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = User::withTrashed()->find($id);
        if(!is_null($user)){
            $user->forceDelete();
        } else {
            return response()->json([
                'success'     => false,
                'type'        => 'error',
                'title'       => __('base.msg.error_message.title'),
                'description' => __('base.msg.error_message.description'),
            ], 500);
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
        if(!in_array(auth()->user()->type, ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $user = User::withTrashed()->find($id);
        if(!is_null($user)){
            $user->restore();
        } else {
            return response()->json([
                'success'     => false,
                'type'        => 'error',
                'title'       => __('base.msg.error_message.title'),
                'description' => __('base.msg.error_message.description'),
            ], 500);
        }

        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
        ], 200);
    }
}
