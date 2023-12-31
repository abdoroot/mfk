<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Insert UAE cities in both English and Arabic
        $uaeCities = [
            ['en' => 'Dubai', 'ar' => 'دبي'],
            ['en' => 'Abu Dhabi', 'ar' => 'أبو ظبي'],
            ['en' => 'Sharjah', 'ar' => 'الشارقة'],
            ['en' => 'Ajman', 'ar' => 'عجمان'],
            ['en' => 'Fujairah', 'ar' => 'الفجيرة'],
            ['en' => 'Ras Al Khaimah', 'ar' => 'رأس الخيمة'],
            ['en' => 'Umm Al Quwain', 'ar' => 'أم القيوين'],
            // Add more UAE cities as needed
        ];

        $stateId = 1; // Assuming the state_id for UAE

        foreach ($uaeCities as $city) {
            \DB::table('cities')->insert([
                'name' => json_encode($city),
                'state_id' => $stateId,
            ]);
        }
    }
}