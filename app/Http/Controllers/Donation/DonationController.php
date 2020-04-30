<?php

namespace App\Http\Controllers\Donation;

use Illuminate\Http\Request;
use App\Models\Donation\Donation;
use App\Traits\ReturnsApiResponse;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    use ReturnsApiResponse;

    private $repo;

    public function construct()
    {
        $this->repo = Donation::class;
    }

    public function index(Request $request)
    {
        if ($request->user->isAdmin) {
            $collection = $this->repo->all();
        }

        dd($collection);
    }
}
