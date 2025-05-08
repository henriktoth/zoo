<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Enclosure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
    public function create()
    {
        $enclosures = Enclosure::all();
        return view('createAnimal', compact('enclosures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'species' => 'required|string|max:100',
            'is_predator' => 'required|boolean',
            'born_at' => 'required|date|before_or_equal:today',
            'enclosure_id' => 'required|exists:enclosures,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $enclosure = Enclosure::findOrFail($request->enclosure_id);
        $existingAnimals = $enclosure->animals()->whereNull('deleted_at')->get();

        if ($existingAnimals->count() > 0) {
            $hasPredators = $existingAnimals->contains('is_predator', true);
            $wantToAddPredator = $request->is_predator == 1;

            if ($hasPredators != $wantToAddPredator) {
                return redirect()->back()->withInput()->with('error', 'Ragadozó és nem ragadozó állat nem kerülhet ugyanabba a kifutóba!');
            }
        }

        if ($existingAnimals->count() >= $enclosure->limit) {
            return redirect()->back()->withInput()->with('error', 'A kifutó elérte a maximális állat limitet!');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('animal_images', 'public');
        }

        Animal::create([
            'name' => $request->name,
            'species' => $request->species,
            'is_predator' => $request->is_predator,
            'born_at' => $request->born_at,
            'enclosure_id' => $request->enclosure_id,
            'image' => $imagePath ? Storage::url($imagePath) : null,
        ]);

        return redirect()->route('list.index')->with('success', 'Állat sikeresen létrehozva!');
    }

    public function edit($id)
    {
        $animal = Animal::findOrFail($id);
        $enclosures = Enclosure::all();
        return view('editAnimal', compact('animal', 'enclosures'));
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'species' => 'required|string|max:100',
            'is_predator' => 'required|boolean',
            'born_at' => 'required|date|before_or_equal:today',
            'enclosure_id' => 'required|exists:enclosures,id',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $newEnclosureId = $request->enclosure_id;
        $newIsPredator = $request->is_predator == 1;
        $oldIsPredator = $animal->is_predator;

        if ($animal->enclosure_id != $newEnclosureId || $oldIsPredator != $newIsPredator) {
            $enclosure = $animal->enclosure_id != $newEnclosureId
                ? Enclosure::findOrFail($newEnclosureId)
                : Enclosure::findOrFail($animal->enclosure_id);

            $otherAnimals = $enclosure->animals()
                ->whereNull('deleted_at')
                ->where('id', '!=', $animal->id)
                ->get();

            if ($otherAnimals->count() > 0) {
                $hasPredators = $otherAnimals->contains('is_predator', true);

                if ($hasPredators != $newIsPredator) {
                    return redirect()->back()->withInput()->with('error',
                        'Ragadozó és nem ragadozó állat nem kerülhet ugyanabba a kifutóba!');
                }
            }

            if ($animal->enclosure_id != $newEnclosureId && $otherAnimals->count() >= $enclosure->limit) {
                return redirect()->back()->withInput()->with('error',
                    'A kifutó elérte a maximális állat limitet!');
            }
        }

        if ($request->hasFile('image')) {
            if ($animal->image) {
                $oldPath = str_replace('/storage/', '/public/', $animal->image);
                Storage::delete($oldPath);
            }
            $imagePath = $request->file('image')->store('animal_images', 'public');
            $animal->image = Storage::url($imagePath);
        }

        $animal->name = $request->name;
        $animal->species = $request->species;
        $animal->is_predator = $request->is_predator;
        $animal->born_at = $request->born_at;
        $animal->enclosure_id = $request->enclosure_id;
        $animal->save();

        return redirect()->route('enclosures.show', $animal->enclosure_id)->with('success', 'Állat sikeresen frissítve!');
    }

    public function archive($id)
    {
        $animal = Animal::findOrFail($id);
        $enclosureId = $animal->enclosure_id;

        $animal->enclosure_id = null;
        $animal->save();
        $animal->delete();

        return redirect()->route('enclosures.show', $enclosureId)
            ->with('success', 'Állat sikeresen archiválva!');
        }

    public function archived(){
        $animals = Animal::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        $enclosures = Enclosure::all();

        return view('archivedAnimals', compact('animals', 'enclosures'));
    }

    public function restore(Request $request, $id)
    {

        $request->validate([
            'enclosure_id' => 'required|exists:enclosures,id',
        ]);

        $animal = Animal::onlyTrashed()->findOrFail($id);

        $enclosure = Enclosure::findOrFail($request->enclosure_id);
        $existingAnimals = $enclosure->animals()->whereNull('deleted_at')->get();

        if ($existingAnimals->count() > 0) {
            $hasPredators = $existingAnimals->contains('is_predator', true);
            if ($hasPredators != $animal->is_predator) {
                return redirect()->back()->with('error',
                    'Ragadozó és nem ragadozó állat nem kerülhet ugyanabba a kifutóba!');
            }
        }

        if ($existingAnimals->count() >= $enclosure->limit) {
            return redirect()->back()->with('error',
                'A kifutó elérte a maximális állat limitet!');
        }

        $animal->enclosure_id = $request->enclosure_id;
        $animal->save();
        $animal->restore();

        return redirect()->route('enclosures.show', $animal->enclosure_id)
            ->with('success', 'Állat sikeresen visszaállítva!');
    }
}
