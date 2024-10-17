<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'Tripoli', 'name_ar' => 'طرابلس'],
            ['name' => 'Benghazi', 'name_ar' => 'بنغازي'],
            ['name' => 'Misrata', 'name_ar' => 'مصراتة'],
            ['name' => 'Zawiya', 'name_ar' => 'الزاوية'],
            ['name' => 'Zliten', 'name_ar' => 'زليتن'],
            ['name' => 'Bayda', 'name_ar' => 'البيضاء'],
            ['name' => 'Zuwara', 'name_ar' => 'زوارة'],
            ['name' => 'Ajdabiya', 'name_ar' => 'أجدابيا'],
            ['name' => 'Tobruk', 'name_ar' => 'طبرق'],
            ['name' => 'Sabha', 'name_ar' => 'سبها'],
            ['name' => 'Derna', 'name_ar' => 'درنة'],
            ['name' => 'Gharyan', 'name_ar' => 'غريان'],
            ['name' => 'Sabratha', 'name_ar' => 'صبراتة'],
            ['name' => 'Tarhuna', 'name_ar' => 'ترهونة'],
            ['name' => 'Kufra', 'name_ar' => 'الكفرة'],
            ['name' => 'Sirte', 'name_ar' => 'سرت'],
            ['name' => 'Jalu', 'name_ar' => 'جالو'],
            ['name' => 'Brak', 'name_ar' => 'براك'],
            ['name' => 'Ghat', 'name_ar' => 'غات'],
            ['name' => 'Awbari', 'name_ar' => 'أوباري'],
            ['name' => 'Murzuq', 'name_ar' => 'مرزق'],
            ['name' => 'Ghadames', 'name_ar' => 'غدامس'],
            ['name' => 'Nalut', 'name_ar' => 'نالوت'],
            ['name' => 'Yafran', 'name_ar' => 'يفرن'],
            ['name' => 'Shahat', 'name_ar' => 'شحات'],
            ['name' => 'Bani Walid', 'name_ar' => 'بني وليد'],
            ['name' => 'Msallata', 'name_ar' => 'مسلاتة'],
            ['name' => 'Jufra', 'name_ar' => 'الجفرة'],
            ['name' => 'Other', 'name_ar' => 'اخري'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
