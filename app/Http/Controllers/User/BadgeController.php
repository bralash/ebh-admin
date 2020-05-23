<?php

namespace App\Http\Controllers\User;

use App\Models\User\Badge;
use Illuminate\Http\Request;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;

class BadgeController extends Controller
{
	use ReturnsApiResponse;

	public function index()
	{
		$badges = Badge::all();
		$this->response->addCollection($badges->all(), 'badges', ['name', 'points']);

		return $this->response->ok();
	}
}
