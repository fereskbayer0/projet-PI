<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $latestMood = Mood::where('user_id', $user->id)->latest()->first();
        $moodCount = Mood::where('user_id', $user->id)->count();
        $averageIntensity = Mood::where('user_id', $user->id)->avg('intensity');

        // Les cinq derniers enregistrements alimentent le journal du tableau de bord
        $recentMoods = Mood::where('user_id', $user->id)->latest()->take(5)->get();

        // Serie des 14 derniers jours : une valeur par jour (null si rien note)
        $depuis = Carbon::today()->subDays(13);
        $parJour = Mood::where('user_id', $user->id)
            ->where('created_at', '>=', $depuis)
            ->get()
            ->groupBy(fn ($mood) => $mood->created_at->format('Y-m-d'));

        $trendLabels = [];
        $trendScores = [];

        for ($i = 0; $i < 14; $i++) {
            $jour = $depuis->copy()->addDays($i);
            $cle = $jour->format('Y-m-d');

            $trendLabels[] = $jour->format('d/m');
            $trendScores[] = isset($parJour[$cle])
                ? round($parJour[$cle]->avg('intensity'), 1)
                : null;
        }

        return view('dashboard', [
            'user' => $user,
            'latestMood' => $latestMood,
            'moodCount' => $moodCount,
            'averageIntensity' => $averageIntensity ? round($averageIntensity, 1) : 0,
            'recentMoods' => $recentMoods,
            'trendLabels' => $trendLabels,
            'trendScores' => $trendScores,
            'joursSuivis' => $parJour->count(),
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
