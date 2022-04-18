<?php
namespace Database\Seeders;

use App\EMS\State\State;
use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    public function run()
    {
        $states = [
            [
                'id'         => 1,
                'name'       => 'Abuja',
                'short_code' => 'FC',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 2,
                'name'       => 'Abia',
                'short_code' => 'AB',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 3,
                'name'       => 'Adamawa',
                'short_code' => 'AD',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 4,
                'name'       => 'Akwa Ibom',
                'short_code' => 'AK',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 5,
                'name'       => 'Anambra',
                'short_code' => 'AN',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 6,
                'name'       => 'Bauchi',
                'short_code' => 'BA',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 7,
                'name'       => 'Bayelsa',
                'short_code' => 'BY',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 8,
                'name'       => 'Benue',
                'short_code' => 'BE',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 9,
                'name'       => 'Borno',
                'short_code' => 'BO',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 10,
                'name'       => 'Cross River',
                'short_code' => 'CR',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 11,
                'name'       => 'Delta',
                'short_code' => 'DE',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 12,
                'name'       => 'Ebonyi',
                'short_code' => 'EB',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 13,
                'name'       => 'Edo',
                'short_code' => 'ED',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 14,
                'name'       => 'Ekiti',
                'short_code' => 'EK',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 15,
                'name'       => 'Enugu',
                'short_code' => 'EN',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 16,
                'name'       => 'Gombe',
                'short_code' => 'GO',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 17,
                'name'       => 'Imo',
                'short_code' => 'IM',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 18,
                'name'       => 'Jigawa',
                'short_code' => 'JI',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 19,
                'name'       => 'Kaduna',
                'short_code' => 'KD',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 20,
                'name'       => 'Kano',
                'short_code' => 'KN',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 21,
                'name'       => 'Katsina',
                'short_code' => 'KT',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 22,
                'name'       => 'Kebbi',
                'short_code' => 'KE',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 23,
                'name'       => 'Kogi',
                'short_code' => 'KO',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 24,
                'name'       => 'Kwara',
                'short_code' => 'KW',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 25,
                'name'       => 'Lagos',
                'short_code' => 'LA',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 26,
                'name'       => 'Nassarawa',
                'short_code' => 'NA',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 27,
                'name'       => 'Niger',
                'short_code' => 'NI',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 28,
                'name'       => 'Ogun',
                'short_code' => 'OG',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 29,
                'name'       => 'Ondo',
                'short_code' => 'ON',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 30,
                'name'       => 'Osun',
                'short_code' => 'OS',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 31,
                'name'       => 'Oyo',
                'short_code' => 'OY',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 32,
                'name'       => 'Plateau',
                'short_code' => 'PL',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 33,
                'name'       => 'Rivers',
                'short_code' => 'RI',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 34,
                'name'       => 'Sokoto',
                'short_code' => 'SO',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 35,
                'name'       => 'Taraba',
                'short_code' => 'TA',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 36,
                'name'       => 'Yobe',
                'short_code' => 'YO',
                'country_id' => 154,
                'status' => 1
            ],
            [
                'id'         => 37,
                'name'       => 'Zamfara',
                'short_code' => 'ZA',
                'country_id' => 154,
                'status' => 1
            ],
        ];

        State::query()->insert($states);
    }
}
