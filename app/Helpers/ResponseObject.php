<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class ResponseObject
{
	public $object;
	public $error_source = [];
	public $errors = [];
	public $status_code;
}
