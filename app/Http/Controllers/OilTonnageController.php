<?php

// app/Http/Controllers/OilTonnageController.php

namespace App\Http\Controllers;

use App\Models\OilTonnage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OilTonnageController extends Controller
{
    public function index()
    {
        $records = OilTonnage::latest()->paginate(10);
        return view('oil.index', compact('records'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'volume' => 'required|numeric|min:0.01',
            'density' => 'required|numeric|min:0.01',
            'temperature' => 'required|numeric|min:-50|max:150',
        ]);

        $roundedDensity = round($request->density * 2) / 2;
        $roundedTemp = round($request->temperature * 4) / 4;

        $vcf = DB::table('table60b')
            ->where('density', $roundedDensity)
            ->where('temperature', $roundedTemp)
            ->value('vcf');

        if (!$vcf) {
            return back()->withErrors(['msg' => 'No VCF found for provided density and temperature.']);
        }

        $tonnage = ($request->volume * $request->density * $vcf) / 1000;

        $record = OilTonnage::create([
            'volume' => $request->volume,
            'density' => $request->density,
            'temperature' => $request->temperature,
            'vcf' => $vcf,
            'tonnage' => $tonnage,
        ]);

        return redirect()->route('oil.index')->with('success', "Tonnage: {$tonnage} MT, VCF used: {$vcf}");
    }
}
