<?php

namespace App\Http\Controllers\Addresses;

use Illuminate\Routing\Controller as BaseController;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

class AddressController extends BaseController
{
    // use Helper;

    protected $locale = 'ar';

    public function __construct()
    {
        $this->locale = app()->getLocale();
    }
    public function getCountries(Request $request)
    {
        return $this->getCountry($this->locale);
    }
    public function getCities(Request $request)
    {
        $cities = $this->getCitiy($request->country_id, $this->locale);
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
                'selected'    => $request->has('selected') ? $request->selected : (!is_null($cities_first = $cities->first()) ? $cities_first->id : ''),
                'value'       => function($data, $key, $value){ return $value->id; },
                'text'        => function($data, $key, $value){ return $value->{'name_'.$this->locale}; },
                'sub_text'    => function($data, $key, $value){ return $value->country->{'name_'.$this->locale}; },
                'select'      => function($data, $selected, $key, $value){ return $selected == $value->id; },
            ],
            'errors' => new MessageBag
        ]);
    }
    public function getMunicipalites(Request $request)
    {
        $municipalities = $this->getMunicipality($request->city_id, $this->locale);
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
                'selected'    => $request->has('selected') ? $request->selected : (!is_null($municipalities_first = $municipalities->first()) ? $municipalities_first->id : ''),
                'value'       => function($data, $key, $value){ return $value->id; },
                'text'        => function($data, $key, $value){ return $value->{'name_'.$this->locale}; },
                'sub_text'    => function($data, $key, $value){ return $value->city->{'name_'.$this->locale}; },
                'select'      => function($data, $selected, $key, $value){ return $selected == $value->id; },
            ],
            'errors' => new MessageBag
        ]);
    }
    public function getNeighborhoodes(Request $request)
    {
        $neighborhoods = $this->getNeighborhood($request->municipality_id, $this->locale);
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
                'selected'    => $request->has('selected') ? $request->selected : (!is_null($neighborhoods_first = $neighborhoods->first()) ? $neighborhoods_first->id : ''),
                'value'       => function($data, $key, $value){ return $value->id; },
                'text'        => function($data, $key, $value){ return $value->{'name_'.$this->locale}; },
                'sub_text'    => function($data, $key, $value){ return $value->municipality->{'name_'.$this->locale}; },
                'select'      => function($data, $selected, $key, $value){ return $selected == $value->id; },
            ],
            'errors' => new MessageBag
        ]);
    }
}
