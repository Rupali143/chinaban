<?php

namespace App\Repositories\Admin;
use App\Model\Admin;
use App\Repositories\User\AdminInterface as AdminInterface;
use Illuminate\Support\Facades\Validator;

class AdminRepository implements AdminInterface{

	public $user;

    function __construct(User $user) {
	$this->user = $user;
	}
}