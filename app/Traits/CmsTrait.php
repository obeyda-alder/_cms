<?php
namespace App\Traits;


trait CmsTrait
{
    protected $user;
    protected $token;

    protected function user()
    {
        return session()->get('_user');
    }
    protected function userType()
    {
        return $this->user()['type'];
    }
    protected function cite()
    {
        return $this->user()['cite'];
    }
    protected function unit()
    {
        return $this->user()['unit'];
    }
    protected function money()
    {
        return $this->user()['money'];
    }
    protected function user_units()
    {
        return $this->user()['user_units'];
    }
    protected function type_unit_type()
    {
        return $this->user()['type_unit_type'];
    }
    protected function actions()
    {
        return $this->user()['actions'];
    }
    protected function token()
    {
        return session()->get('_token');
    }
}
