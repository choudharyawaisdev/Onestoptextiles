<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addon;
use App\Models\Menu;

class AddOnsController extends Controller
{
    public function index()
    {
        $adons = Addon::all();
        return view('admin.addons.index', compact('adons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Addon::create([
            'title' => $request->title,
            'price' => $request->price,
        ]);

        return redirect()->route('addons.index')->with('success', 'Add-on created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $adon = Addon::findOrFail($id);
        $adon->update([
            'title' => $request->title,
            'price' => $request->price,
        ]);

        return redirect()->route('addons.index')->with('success', 'Add-on updated successfully.');
    }

    public function destroy(string $id)
    {
        $adon = Addon::findOrFail($id);
        $adon->delete();

        return redirect()->route('adminaddons.index')->with('success', 'Add-on deleted successfully.');
    }
}
