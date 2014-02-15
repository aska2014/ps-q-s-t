<?php

use Location\Country;

class CountrySeeder extends \Illuminate\Database\Seeder {

    /**
     * Seed country and cities
     */
    public function run()
    {
        $country = Country::create(array('name' => 'Qatar'));

        $municipalities = 'al^doha al^rayyan al^khor al^wakrah al^shamal umm^salal al^daayen';

        foreach(explode(' ', $municipalities) as $municipality)
        {
            if(strpos($municipality, '^') !== false)
            {
                $municipality = ucwords(str_replace('^', ' ', $municipality));
            }

            $country->cities()->create(array(
                'name' => $municipality
            ));
        }
    }

}