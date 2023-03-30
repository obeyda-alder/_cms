<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Routing\Controller as BaseController;
use App\Helpers\HttpRequests;
use App\Traits\CmsTrait;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use DataTables;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;

class ConfigurationsController extends BaseController
{
    use CmsTrait, Helper, HttpRequests;

    public function config(Request $request, $lang)
    {
        App::setLocale($lang);
        session()->put('current_lang', $lang);
        if($lang == "ar"){
            session()->put('lang_direction', 'rtl');
        }
        return redirect()->route('dashboard');
    }
    public function index(Request $request, $type)
    {
        if(!in_array($this->userType(), ["ROOT"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }

        $relations_type  = $this->get(config('custom.api_routes.config.relations_type.index'));
        $unit_type       = $this->get(config('custom.api_routes.config.unit_type.index'));
        $operations      = $this->get(config('custom.api_routes.config.operations.index'));
        return view('backend.configurations.index', [
            'type'           => $type,
            'relations_type' => $relations_type['data'],
            'unit_type'      => $unit_type['data'],
            'operations'     => $operations['data'],
        ]);
    }
    public function data(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }

        $data = [
            'type'   => $request->type,
            'search' => $request->search['value']
        ];

        $config_type = $this->get(config('custom.api_routes.config.'.$request->type.'.index'), $data);
        if(!$config_type['success']){
            return $config_type;
        }
        if($request->type == "relations_type"){
            return  Datatables::of($config_type['data'])
            ->addColumn('relation_type', function ($config) {
                return $config['relation_type'] ?? '';
            })
            ->addColumn('user_type', function ($config) {
                return $config['user_type'] ?? '';
            })
            ->addColumn('actions', function($config) use ($request) {
                $actions   = [];
                $actions[] = [
                    'id'            => $config['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('configurations::delete', ['id' => $config['id'] , 'type' => $request->type ]),
                    'method'        => 'POST',
                    'request_type'  => 'delete_'.$config['id'],
                    'class'         => 'delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                return $actions;
            })
            ->rawColumns([])
            ->make(true);
        }else if($request->type == "operations"){
            return  Datatables::of($config_type['data'])
            ->addColumn('type_en', function ($config) {
                return $config['type_en'] ?? '';
            })
            ->addColumn('type_ar', function ($config) {
                return $config['type_ar'] ?? '';
            })
            ->addColumn('relation', function ($config) {
                return $config['relation']['relation_type'] ?? '';
            })
            ->addColumn('user_type', function ($config) {
                return $config['relation']['user_type'] ?? '';
            })
            ->addColumn('actions', function($config) use ($request) {
                $actions   = [];
                $actions[] = [
                    'id'            => $config['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('configurations::delete', ['id' => $config['id'] , 'type' => $request->type ]),
                    'method'        => 'POST',
                    'request_type'  => 'delete_'.$config['id'],
                    'class'         => 'delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                return $actions;
            })
            ->rawColumns([])
            ->make(true);
        }else if($request->type == "unit_type"){
            return  Datatables::of($config_type['data'])
            ->addColumn('type', function ($config) {
                return $config['type'] ?? '';
            })
            ->addColumn('continued', function ($config) {
                return $config['continued'] ?? '';
            })
            ->addColumn('actions', function($config) use ($request) {
                $actions   = [];
                $actions[] = [
                    'id'            => $config['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('configurations::delete', ['id' => $config['id'] , 'type' => $request->type ]),
                    'method'        => 'POST',
                    'request_type'  => 'delete_'.$config['id'],
                    'class'         => 'delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                return $actions;
            })
            ->rawColumns([])
            ->make(true);
        }else if($request->type == "relation_unit_type_with_operations"){
            return  Datatables::of($config_type['data'])
            ->addColumn('relation_type', function ($config) {
                return $config['operation']['relation']['relation_type'] ?? '';
            })
            ->addColumn('user_type', function ($config) {
                return $config['operation']['relation']['user_type'] ?? '';
            })
            ->addColumn('operation_en', function ($config) {
                return $config['operation']['type_en'] ?? '';
            })
            ->addColumn('operation_ar', function ($config) {
                return $config['operation']['type_ar'] ?? '';
            })
            ->addColumn('from_unit_type', function ($config) {
                return $config['from_unit_type']['type'] ?? '';
            })
            ->addColumn('from_continued', function ($config) {
                return $config['from_unit_type']['continued'] ?? '';
            })
            ->addColumn('to_unit_type', function ($config) {
                return $config['to_unit_type']['type'] ?? '';
            })
            ->addColumn('to_continued', function ($config) {
                return $config['to_unit_type']['continued'] ?? '';
            })
            ->addColumn('actions', function($config) use ($request) {
                $actions   = [];
                $actions[] = [
                    'id'            => $config['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('configurations::delete', ['id' => $config['id'] , 'type' => $request->type  ]),
                    'method'        => 'POST',
                    'request_type'  => 'delete_'.$config['id'],
                    'class'         => 'delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                return $actions;
            })
            ->rawColumns([])
            ->make(true);
        }
    }
    public function create(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }
        $data = [];
        if ($request->type == "relations_type"){
            $data['relation_type'] = $request->from_users_type.'_to_'.$request->to_user_type;
            $data['user_type']     = $request->user_type;
        }elseif($request->type == "operations"){
            $data['type_en']     = $request->type_en;
            $data['type_ar']     = $request->type_ar;
            $data['relation_id'] = $request->relation_id;
        }elseif($request->type == "unit_type"){
            $data['type']      = $request->type;
            $data['continued'] = $request->continued;
        }elseif($request->type == "relation_unit_type_with_operations"){
            $data['from_unit_type_id']  = $request->from_unit_type_id;
            $data['to_unit_type_id']    = $request->to_unit_type_id;
            $data['operation_id']       = $request->operation_id;
        }

        $config_type = $this->post(config('custom.api_routes.config.'.$request->type.'.create'), $data);
        if(!$config_type['success']){
            return $config_type;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
        ], 200);
    }
    public function delete(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }

        $config = $this->post(config('custom.api_routes.config.'.$request->type.'.delete').'/'.$request->id);
        if(!$config['success']){
            return $config;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
        ], 200);
    }
    public function global(Request $request, $type)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }
        $global  = $this->get(config('custom.api_routes.config.global.index'), ['type' => $type]);
        $country = collect($this->Country());

        return view('backend.configurations.global', [
            'type'           => $type,
            'global'         => $global['data'],
            'currency'       => $country->where('currency', '!=', '₧')
        ]);
    }
    public function GlobalData(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }
        $data = [
            'type'   => $request->type,
            'search' => $request->search['value']
        ];

        $global = $this->get(config('custom.api_routes.config.global.index'), $data);
        if(!$global['success']){
            return $global;
        }
        if($request->type == "currencies"){
            return  Datatables::of($global['data'])
            ->addColumn('flag', function ($global) {
                return '<img class="cur_flag" src="'.$global['flag'].'" />' ?? '';
            })
            ->addColumn('name', function ($global) {
                return $global['name'] ?? '';
            })
            ->addColumn('currency', function ($global) {
                return $global['currency'] ?? '';
            })
            ->addColumn('price', function ($global) {
                return $global['price'] ?? '';
            })
            ->addColumn('created_at', function ($global) {
                return $global['created_at'] ?? '';
            })
            ->addColumn('actions', function($global) use ($request) {
                $actions   = [];
                $actions[] = [
                    'id'            => $global['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('global::delete', ['id' => $global['id'] , 'type' => $request->type ]),
                    'method'        => 'POST',
                    'request_type'  => 'delete_'.$global['id'],
                    'class'         => 'delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                return $actions;
            })
            ->rawColumns(['flag'])
            ->make(true);
        }
    }
    public function GlobalCreate(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }

        $data = [];
        if ($request->type == "currencies"){
            $data['type']         = $request->type;
            $data['currency_id']  = $request->currency;
            $data['price']        = $request->price;
        }

        $global = $this->post(config('custom.api_routes.config.global.create'), $data);
        if(!$global['success']){
            return $global;
        }
        return response()->json([
            'success'      => true,
            'type'         => 'success',
            'title'        => __('base.msg.success_message.title'),
            'description'  => __('base.msg.success_message.description'),
            'redirect_url' => route('global', ['type' => $request->type])
        ], 200);
    }
    public function GlobalDelete(Request $request)
    {
        if(!in_array($this->userType(), ["ROOT", "ADMIN"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 500);
        }

        $global = $this->post(config('custom.api_routes.config.global.delete').'/'.$request->id);
        if(!$global['success']){
            return $global;
        }
        return response()->json([
            'success'      => true,
            'type'         => 'success',
            'title'        => __('base.msg.success_message.title'),
            'description'  => __('base.msg.success_message.description'),
            'redirect_url' => route('global', ['type' => $request->type])
        ], 200);
    }
    public function get_flag(Request $request)
    {
        $country = collect($this->Country());
        return $country->where('id', $request->cur_id)->first();
    }
}
