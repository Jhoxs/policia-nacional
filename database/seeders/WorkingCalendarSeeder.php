<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkingCalendar;

class WorkingCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkingCalendar::updateOrCreate([
            'is_active' => true,
            'calendar' => [
                'Monday' => [
                    '09:00 - 10:00',
                    '10:00 - 11:00',
                    '12:00 - 13:00',
                    '14:00 - 15:00',
                    '16:00 - 17:00',
                    '17:00 - 18:00'
                ],
                'Tuesday' => [
                    '09:00 - 10:00',
                    '10:00 - 11:00',
                    '12:00 - 13:00',
                    '14:00 - 15:00',
                    '16:00 - 17:00',
                    '17:00 - 18:00'
                ],
                'Wednesday' => [
                    '09:00 - 10:00',
                    '10:00 - 11:00',
                    '12:00 - 13:00',
                    '14:00 - 15:00',
                    '16:00 - 17:00',
                    '17:00 - 18:00'
                ],
                'Thursday' => [
                    '09:00 - 10:00',
                    '10:00 - 11:00',
                    '12:00 - 13:00',
                    '14:00 - 15:00',
                    '16:00 - 17:00',
                    '17:00 - 18:00'
                ],
                'Friday' => [
                    '09:00 - 10:00',
                    '10:00 - 11:00',
                    '12:00 - 13:00',
                    '14:00 - 15:00',
                    '16:00 - 17:00',
                    '17:00 - 18:00'
                ],
                
            ]
        ]);
    }
}
