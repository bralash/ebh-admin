<?php

namespace App\Http\Controllers;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Models\Donation\Donor;
use App\Models\Donation\Donation;
use App\Models\Blood\BloodRequest;
use App\Traits\ReturnsApiResponse;

class AppController extends Controller
{
    use ReturnsApiResponse;

	public function app()
	{
		return view('app.index');
	}

	public function stats()
	{
		$stat = array();

		$stat['users'] = [
			'id' => 1,
			'name' => 'Users',
			'value' => User::count()
		];

		$stat['donors'] = [
			'id' => 2,
			'name' => 'Donors',
			'value' => Donor::count()
		];

		$stat['opened_request'] = [
			'id' => 3,
			'name' => 'Opened Requests',
			'value' => BloodRequest::where('closed_at', NULL)->count()
		];

		$stat['donations'] = [
			'id' => 4,
			'name' => 'Donations made',
			'value' => Donation::count(),
		];


		$this->response->addCollection($stat, 'stats', ['name', 'value']);

		return $this->response->ok();
	}
}
