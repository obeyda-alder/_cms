<?php

namespace App\Http\Controllers\Configurations;

use Illuminate\Routing\Controller as BaseController;
use App\Helpers\HttpRequests;
use App\Traits\CmsTrait;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use DataTables;

class ConfigurationsController extends BaseController
{
    use CmsTrait, Helper, HttpRequests;

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

        return view('backend.configurations.index', ['type' => $type]);
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

        $config_type = $this->get(config('custom.api_routes.'.$request->type.'.index'), $data);
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
                return $config['relation'][0]['relation_type'] ?? '';
            })
            ->addColumn('user_type', function ($config) {
                return $config['relation'][0]['user_type'] ?? '';
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
            ->addColumn('operation_en', function ($config) {
                return $config['operation'][0]['type_en'] ?? '';
            })
            ->addColumn('operation_ar', function ($config) {
                return $config['operation'][0]['type_ar'] ?? '';
            })
            ->addColumn('relation_type', function ($config) {
                return $config['relation'][0]['relation_type'] ?? '';
            })
            ->addColumn('user_type', function ($config) {
                return $config['relation'][0]['user_type'] ?? '';
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
        dd($request->all());
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

        $config = $this->post(config('custom.api_routes.'.$request->type.'.delete').'/'.$request->id);
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
}
