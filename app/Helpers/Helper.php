<?php

namespace App\Helpers;
use App\Traits\CmsTrait;
use App\Helpers\HttpRequests;

trait Helper {

    use HttpRequests;

    protected $const;

    public function Country($id = null)
    {
        return $this->get(config('custom.api_routes.addresses.Countries', [ 'id' => $id]));
    }
    public function Citiy($country_id = null)
    {
        return $this->get(config('custom.api_routes.addresses.Cities', [ 'country_id' => $country_id] ));
    }
    public function Municipality($city_id = null)
    {
        return $this->get(config('custom.api_routes.addresses.Municipalites', ['city_id' => $city_id]));
    }
    public function Neighborhood($municipality_id = null)
    {
        return $this->get(config('custom.api_routes.addresses.Neighborhoodes', ['municipality_id' => $municipality_id]));
    }
    public function default($file)
    {
        return $this->get(config('custom.api_routes.users.default').'/'.$file, [], true);
    }
}
