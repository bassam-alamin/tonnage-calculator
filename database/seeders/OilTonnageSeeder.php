<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\OilTonnage;

class OilTonnageSeeder extends Seeder
{
    public function run(): void
    {
        $inserted = 0;
        $attempts = 0;

        while ($inserted < 100 && $attempts < 300) {
            // Generate random input values
            $volume = mt_rand(1000, 10000); // in litres
            $density = round(mt_rand(8000, 9200) / 10, 1); // 800.0 to 920.0
            $temperature = round(mt_rand(1000, 5000) / 100, 2); // 10.00°C to 50.00°C

            // Round to match vcftable keys
            $roundedDensity = round($density * 2) / 2; // e.g., 899.6 → 899.5
            $roundedTemp = round($temperature * 4) / 4; // e.g., 31.13 → 31.25

            // Fetch Volume Correction Factor (VCF)
            $vcf = DB::table('table60')
                ->where('density', $roundedDensity)
                ->where('temperature', $roundedTemp)
                ->value('vcf');

            if (!$vcf) {
                $attempts++;
                continue;
            }

            // Calculate tonnage in metric tons (MT)
            $tonnage = ($volume * $density * $vcf) / 1000;

            // Insert into database
            OilTonnage::create([
                'volume' => $volume,
                'density' => $density,
                'temperature' => $temperature,
                'vcf' => $vcf,
                'tonnage' => $tonnage,
            ]);

            $inserted++;
            $attempts++;
        }

        echo "Inserted {$inserted} records into oil_tonnages.\n";
    }
}
