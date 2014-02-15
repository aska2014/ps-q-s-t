<?php

class MassOfferSeeder extends \Illuminate\Database\Seeder {

    public function run()
    {
        \Offers\MassOffer::create(array(
            'title' => '20% Discount',
            'description' => 'Buy more than two products and get 20% discount. Try it and put two products in your cart.',
            'start_quantity' => 2,
            'discount_percentage' => 20,
            'from_date' => new DateTime(),
            'to_date' => new DateTime('+7 days')
        ));
    }

}