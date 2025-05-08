<?php

namespace App\Http\Controllers;
use App\Models\Enclosure;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class EnclosuresController extends Controller
{

    public function index(){

        if (Auth::check() && Auth::user()->admin) {
            $enclosures = Enclosure::withCount('animals')->orderBy('name')->paginate(5);
        } else {
            $enclosures = Auth::user()->enclosures()->withCount('animals')->orderBy('name')->paginate(5);
        }
        return view('list', compact('enclosures'));
    }

    public function create()
    {
        return view('addEnclosure');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'limit' => 'required|integer|min:1',
            'feeding_at' => 'required|date_format:H:i',
        ]);
            Enclosure::create($validated);
            return redirect()->route('list.index')->with('success', 'A kifutó sikeresen létrehozva!');

    }

    public function edit($id){
        $enclosure = Enclosure::findOrFail($id);

        $caretakerId = DB::table('enclosure_user')
            ->where('enclosure_id', $id)
            ->value('user_id');

        return view('editEnclosure', compact('enclosure', 'caretakerId'));
    }

    public function update(Request $request, $id){

        $enclosure = Enclosure::findOrFail($id);
        $animalCount = $enclosure->animals()->count();

        $request->validate([
            'name' => 'required|string|max:100',
            'limit' => "required|integer|min:$animalCount",
            'feeding_at' => 'nullable|date_format:H:i',
            'caretaker_id' => 'required|exists:users,id',
        ]);

        $enclosure->name = $request->input('name');
        $enclosure->limit = $request->input('limit');
        $enclosure->feeding_at = $request->input('feeding_at');
        $enclosure->save();

        DB::table('enclosure_user')->updateOrInsert(
            ['enclosure_id' => $enclosure->id],
            ['user_id' => $request->input('caretaker_id')]
        );

        return redirect()->route('list.index')->with('success', 'Enclosure updated successfully!');
    }

    public function delete($id)
    {
        $animalCount = Enclosure::findOrFail($id)->animals()->count();
        if ($animalCount > 0) {
            return redirect()->back()->with('error', 'A kifutóban állatok találhatóak, így nem törölhető!');
        }
        $enclosure = Enclosure::findOrFail($id);
        $enclosure->users()->detach();
        $enclosure->delete();
        return redirect()->back()->with('success', 'A kifutó sikeresen törölve');

    }

    public function show($id)
    {
    $enclosure = Enclosure::findOrFail($id);

        if (!Auth::user()->admin && !Auth::user()->enclosures->contains($enclosure->id)) {
        abort(403, 'Nincs jogosultsága ennek a kifutónak a megtekintéséhez.');
    }

    $animals = Animal::where('enclosure_id', $id)
        ->whereNull('deleted_at')
        ->orderBy('species')
        ->orderBy('born_at')
        ->get();

    $hasPredators = $animals->contains('is_predator', true);

    return view('enclosureDetail', [
        'enclosure' => $enclosure,
        'animals' => $animals,
        'hasPredators' => $hasPredators
    ]);
}

}
