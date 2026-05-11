<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $moods = Mood::where('user_id', $user->id)->latest()->get();

        return view('mood', [
            'moods' => $moods,
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'mood' => ['required', 'string', 'max:50'],
            'intensity' => ['required', 'integer', 'min:1', 'max:5'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        Mood::create([
            'user_id' => Auth::id(),
            'mood' => $attributes['mood'],
            'intensity' => $attributes['intensity'],
            'note' => $attributes['note'] ?? null,
        ]);

        return back()->with('success', 'Votre humeur a été enregistrée avec succès.');
    }

    public function edit(Mood $mood)
    {
        abort_if($mood->user_id !== Auth::id(), 403);

        return view('mood-edit', [
            'mood' => $mood,
        ]);
    }

    public function update(Request $request, Mood $mood)
    {
        abort_if($mood->user_id !== Auth::id(), 403);

        $attributes = $request->validate([
            'mood' => ['required', 'string', 'max:50'],
            'intensity' => ['required', 'integer', 'min:1', 'max:5'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        $mood->update($attributes);

        return redirect()->route('moods.index')->with('success', 'Humeur mise à jour.');
    }

    public function destroy(Mood $mood)
    {
        abort_if($mood->user_id !== Auth::id(), 403);

        $mood->delete();

        return back()->with('success', 'Humeur supprimée.');
    }
}
