<?php

namespace App\Http\Controllers\Categories;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Helpers\Helper;
use App\Helpers\HttpRequests;

class CategoriesController extends Controller
{
    use Helper, HttpRequests;

    public function __construct()
    {
        //
    }
    public function index(Request $request)
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
        return view('backend.categories.index');
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

        $data = $this->get(config('custom.api_routes.categories.index'), [ 'search' => $request->search['value'] ]);
        if(!$data['success']){
            return $data;
        }
        return Datatables::of($data['data'])
        ->addIndexColumn()
        ->addColumn('name', function ($category) {
            return $category['name'] ?? '';
        })
        ->addColumn('code', function ($category) {
            return $category['code'] ?? '';
        })
        ->addColumn('unit_min_limit', function ($category) {
            return $category['unit_min_limit'] ?? '';
        })
        ->addColumn('unit_max_limit', function ($category) {
            return $category['unit_max_limit'] ?? '';
        })
        ->addColumn('value_in_price', function ($category) {
            return $category['value_in_price'] ?? '';
        })
        ->addColumn('status', function ($category) {
            return $category['status'] ?? '';
        })
        ->addColumn('percentage', function ($category) {
            return $category['percentage'] . ' %' ?? '';
        })
        ->addColumn('add_by_user_id', function ($category) {
            return $category['user']['name'] ?? '';
        })
        ->addColumn('created_at', function ($category) {
            return $category['created_at'] ?? '';
        })
        ->addColumn('actions', function($category) use($request){
            $actions   = [];
            if($category['deleted_at']) {
                $actions[] = [
                    'id'            => $category['id'],
                    'label'         => __('base.restore'),
                    'type'          => 'icon',
                    'link'          => route('categories::restore', ['id' => $category['id'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'category_restore_'.$category['id'],
                    'class'         => 'restore-action',
                    'icon'          => 'fas fa-trash-restore'
                ];
                $actions[] = [
                    'id'            => $category['id'],
                    'label'         => __('base.delete'),
                    'type'          => 'icon',
                    'link'          => route('categories::delete', ['id' => $category['id'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'delete_'.$category['id'],
                    'class'         => 'delete-action',
                    'icon'          => 'fas fa-user-times'
                ];
            } else {
                $actions[] = [
                    'id'            => $category['id'],
                    'label'         => __('base.soft_delete'),
                    'type'          => 'icon',
                    'link'          => route('categories::soft_delete', ['id' => $category['id'] ]),
                    'method'        => 'POST',
                    'request_type'  => 'soft_delete_'.$category['id'],
                    'class'         => 'soft-delete-action',
                    'icon'          => 'fas fa-trash'
                ];
                $actions[] = [
                    'id'            => $category['id'],
                    'label'         => __('base.update'),
                    'type'          => 'icon',
                    'link'          => route('categories::edit', ['id' => $category['id'] ]),
                    'method'        => 'GET',
                    'request_type'  => 'update_'.$category['id'],
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

        return view('backend.categories.create');
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
        $category = $this->post(config('custom.api_routes.categories.create'), $request->all());
        if(!$category['success']){
            return $category;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
            'redirect_url'  => route('categories')
        ], 200);
    }
    public function edit(Request $request, $id)
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
        $category = $this->get(config('custom.api_routes.categories.edit').'/'.$id);
        if(!$category['success']){
            return $category;
        }
        return view('backend.categories.update', ['category' => $category['data'] ]);
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
        $category = $this->post(config('custom.api_routes.categories.update').'/'.$request->cat_id, $request->all());
        if(!$category['success']){
            return $category;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
            'redirect_url'  => route('categories')
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

        $category = $this->post(config('custom.api_routes.categories.soft_delete').'/'.$id);
        if(!$category['success']){
            return $category;
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

        $category = $this->post(config('custom.api_routes.categories.delete').'/'.$id);
        if(!$category['success']){
            return $category;
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

        $category = $this->post(config('custom.api_routes.categories.restore').'/'.$id);
        if(!$category['success']){
            return $category;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
        ], 200);
    }
}
