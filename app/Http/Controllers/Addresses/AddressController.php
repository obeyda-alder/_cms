<?php

namespace App\Http\Controllers\Addresses;

use Illuminate\Routing\Controller as BaseController;
use App\Helpers\HttpRequests;
use App\Traits\CmsTrait;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class AddressController extends BaseController
{
    use CmsTrait, Helper, HttpRequests;

    public function getCountries(Request $request)
    {
        return $this->Country();
    }
    public function getCities(Request $request)
    {
        $cities = $this->Citiy($request->country_id);
        $nullable = false; if($request->nullable){ $nullable = true; }
        return view('backend.includes.inputs.select', [
            'options' => [
                'id'          => 'cities_selector',
                'nullable'    => $nullable,
                'name'        => $request->name,
                'label'       => $request->label,
                'placeholder' => $request->placeholder,
                'help'        => $request->help,
                'data'        => $cities,
                'selected'    => $request->has('selected') ? $request->selected : null, //(!is_null($cities_first = $cities->first()) ? $cities_first->id : ''),
                'value'       => function($data, $key, $value){ return $value['id']; },
                'text'        => function($data, $key, $value){ return $value['name_'.app()->getLocale()]; },
                'sub_text'    => function($data, $key, $value){ return $value['country']['name_'.app()->getLocale()]; },
                'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
            ],
            'errors' => new MessageBag
        ]);
    }
    public function getMunicipalites(Request $request)
    {
        $municipalities = $this->Municipality($request->city_id);
        $nullable = false; if($request->nullable){ $nullable = true; }
        return view('backend.includes.inputs.select', [
            'options' => [
                'id'          => 'municipalities_selector',
                'nullable'    => $nullable,
                'name'        => $request->name,
                'label'       => $request->label,
                'placeholder' => $request->placeholder,
                'help'        => $request->help,
                'data'        => $municipalities,
                'selected'    => $request->has('selected') ? $request->selected : null, // (!is_null($municipalities_first = $municipalities->first()) ? $municipalities_first->id : ''),
                'value'       => function($data, $key, $value){ return $value['id']; },
                'text'        => function($data, $key, $value){ return $value['name_'.app()->getLocale()]; },
                'sub_text'    => function($data, $key, $value){ return $value['city']['name_'.app()->getLocale()]; },
                'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
            ],
            'errors' => new MessageBag
        ]);
    }
    public function getNeighborhoodes(Request $request)
    {
        $neighborhoods = $this->Neighborhood($request->municipality_id);
        $nullable = false; if($request->nullable){ $nullable = true; }
        return view('backend.includes.inputs.select', [
            'options' => [
                'id'          => 'neighborhoodes_selector',
                'nullable'    => $nullable,
                'name'        => $request->name,
                'label'       => $request->label,
                'placeholder' => $request->placeholder,
                'help'        => $request->help,
                'data'        => $neighborhoods,
                'selected'    => $request->has('selected') ? $request->selected : null, // (!is_null($neighborhoods_first = $neighborhoods->first()) ? $neighborhoods_first->id : ''),
                'value'       => function($data, $key, $value){ return $value['id']; },
                'text'        => function($data, $key, $value){
                     $er = strlen($value['name_'.app()->getLocale()]) > 0 ?
                                    $value['name_'.app()->getLocale()] . ' - ' . ($value['municipality']['name_'.app()->getLocale()] ?? '') :
                                    $value['name_ar'] . ' - ' . ($value['municipality']['name_'.app()->getLocale()] ?? '');
                     return $er;
                     },
                'sub_text'    => function($data, $key, $value){ return $value['municipality']['name_'.app()->getLocale()] ?? ''; },
                'select'      => function($data, $selected, $key, $value){ return $selected == $value['id']; },
            ],
            'errors' => new MessageBag
        ]);
    }
}
