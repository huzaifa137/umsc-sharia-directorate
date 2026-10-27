<?php

namespace App\Http\Controllers;

use App\Models\Mosque;
use App\Models\User;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function regions()
    {
        $regions = Mosque::query()->select('region')
            ->union(User::query()->select('region'))
            ->whereNotNull('region')
            ->get()
            ->pluck('region')
            ->unique()
            ->sort()
            ->values();

        return response()->json($regions);
    }

    public function districts()
    {
        $districts = Mosque::query()->select('district')
            ->union(User::query()->select('district'))
            ->whereNotNull('district')
            ->get()
            ->pluck('district')
            ->unique()
            ->sort()
            ->values();

        return response()->json($districts);
    }

    public function counties(Request $request)
    {
        $request->validate(['district' => 'required|string']);

        $counties = Mosque::where('district', $request->district)->select('county')
            ->union(User::where('district', $request->district)->select('county'))
            ->whereNotNull('county')
            ->get()
            ->pluck('county')
            ->unique()
            ->sort()
            ->values();

        return response()->json($counties);
    }

    public function mosques(Request $request)
    {
        $request->validate([
            'district' => 'required|string',
            'county' => 'required|string',
        ]);

        $mosques = Mosque::where('district', $request->district)
            ->where('county', $request->county)
            ->orderBy('name')
            ->get(['id', 'name', 'imaam_name', 'imaam_user_id']);

        return response()->json($mosques);
    }
}
