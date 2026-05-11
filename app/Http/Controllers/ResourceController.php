<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Resource::orderBy('category')->orderBy('title')->get();

        return view('resources', compact('resources'));
    }

    public function create()
    {
        abort_if(!Auth::user() || !Auth::user()->estAdmin(), 403);

        return view('resource-form', [
            'resource' => new Resource(),
        ]);
    }

    public function store(Request $request)
    {
        abort_if(!Auth::user() || !Auth::user()->estAdmin(), 403);

        $attributes = $this->validated($request);

        Resource::create($attributes);

        return redirect()->route('resources.index')->with('success', 'Ressource ajoutée.');
    }

    public function edit(Resource $resource)
    {
        abort_if(!Auth::user() || !Auth::user()->estAdmin(), 403);

        return view('resource-form', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        abort_if(!Auth::user() || !Auth::user()->estAdmin(), 403);

        $attributes = $this->validated($request);

        $resource->update($attributes);

        return redirect()->route('resources.index')->with('success', 'Ressource mise à jour.');
    }

    public function destroy(Resource $resource)
    {
        abort_if(!Auth::user() || !Auth::user()->estAdmin(), 403);

        $resource->delete();

        return back()->with('success', 'Ressource supprimée.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:1000'],
            'category' => ['nullable', 'string', 'max:50'],
            'url' => ['nullable', 'url', 'max:255'],
        ]);
    }
}
