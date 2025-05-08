<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {

        $enclosuresCount = Enclosure::count();
        $animalsCount = Animal::count();

        $userId = Auth::id();

        $feedings = DB::table('enclosures')
            ->join('enclosure_user', 'enclosures.id', '=', 'enclosure_user.enclosure_id')
            ->where('enclosure_user.user_id', $userId)
            ->orderBy('enclosures.feeding_at')
            ->select('enclosures.*')
            ->get()
            ->filter(function ($enclosure) {
                $feedingTime = Carbon::createFromFormat('H:i', $enclosure->feeding_at);

                $nowTime = Carbon::createFromFormat('H:i', Carbon::now()->format('H:i'));

                return $feedingTime->greaterThan($nowTime);
            });

        return view('dashboard', compact('enclosuresCount', 'animalsCount', 'feedings'));
    }
}
