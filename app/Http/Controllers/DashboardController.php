<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $latestMood = Mood::where('user_id', $user->id)->latest()->first();
        $moodCount = Mood::where('user_id', $user->id)->count();
        $averageIntensity = Mood::where('user_id', $user->id)->avg('intensity');

        return view('dashboard', [
            'user' => $user,
            'latestMood' => $latestMood,
            'moodCount' => $moodCount,
            'averageIntensity' => $averageIntensity ? round($averageIntensity, 1) : 0,
        ]);
    }

    public function stats()
    {
        $user = Auth::user();
        $moods = Mood::where('user_id', $user->id)->get();

        $labels = $moods->pluck('created_at')->map(fn($date) => $date->format('d/m'))->toArray();
        $scores = $moods->pluck('intensity')->toArray();
        $distribution = $moods->groupBy('mood')->map->count()->toArray();

        return view('stats', [
            'labels' => $labels,
            'scores' => $scores,
            'distribution' => $distribution,
        ]);
    }
}
