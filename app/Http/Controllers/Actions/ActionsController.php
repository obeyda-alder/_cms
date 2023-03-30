<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DataTables;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Helpers\HttpRequests;
use App\Traits\CmsTrait;
use \Illuminate\Support\Str;

class ActionsController extends Controller
{
    use Helper, CmsTrait, HttpRequests;

    public function __construct()
    {
        //
    }
    public function index(Request $request, $type)
    {
        if(!in_array($this->userType(), ["ADMIN","EMPLOYEE","MASTER_AGENT","SUB_AGENT"]))
        {
            return response()->json([
                'success'     => false,
                'type'        => 'permission_denied',
                'title'       => __('base.permission_denied.title'),
                'description' => __('base.permission_denied.description'),
            ], 402);
        }

        $actions    = collect($this->actions());
        $operations = $actions->where('relation_type', $type)->first();
        $all_user   = $this->get(config('custom.api_routes.users.index'), ['type'   => Str::after($type, '_TO_')]);
        $currencies  = $this->get(config('custom.api_routes.config.global.index'), ['type' => 'currencies']);
        return view('backend.actions.index', [
            'operations' => $operations,
            'user'       => $this->user(),
            'all_user'   => $all_user,
            'type'       => $type,
            'currencies' => $currencies['data']
        ]);
    }
    public function make_operations(Request $request)
    {
        $data = $request->all();
        $action = $this->post(config('custom.api_routes.operations.make').'/'.$request->operations , $data);
        if(!$action['success']){
            return $action;
        }
        return response()->json([
            'success'     => true,
            'type'        => 'success',
            'title'       => __('base.msg.success_message.title'),
            'description' => __('base.msg.success_message.description'),
            'redirect_url'  => route("actions", ["type" => $request->type])
        ], 200);
    }
}
