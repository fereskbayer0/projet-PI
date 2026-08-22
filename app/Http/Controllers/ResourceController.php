<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

/**
 * Bibliotheque de ressources de bien-etre.
 *
 * Lecture ouverte a tout compte connecte ; creation, modification et
 * suppression sont reservees aux administrateurs par le middleware "admin"
 * applique dans routes/web.php.
 */
class ResourceController extends Controller
{
    public function index()
    {
        return view('resources', [
            'resources' => Resource::orderBy('category')->orderBy('title')->get(),
        ]);
    }

    public function create()
    {
        // Un modele vide : la meme vue sert a creer et a modifier
        return view('resource-form', [
            'resource' => new Resource(),
        ]);
    }

    public function store(Request $request)
    {
        Resource::create($this->validated($request));

        return redirect()->route('resources.index')->with('success', 'Ressource ajoutée.');
    }

    public function edit(Resource $resource)
    {
        return view('resource-form', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $resource->update($this->validated($request));

        return redirect()->route('resources.index')->with('success', 'Ressource mise à jour.');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return back()->with('success', 'Ressource supprimée.');
    }

    /** Regles partagees par la creation et la modification. */
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
