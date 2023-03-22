<?php
namespace App\Traits;


trait CmsTrait
{
    protected $user;
    protected $token;

    protected function user()
    {
        return $this->user = session()->get('_user');
    }
    protected function token()
    {
        return $this->token = session()->get('_token');
    }
}
