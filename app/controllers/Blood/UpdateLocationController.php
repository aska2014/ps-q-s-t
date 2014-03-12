<?php namespace Blood;

use Illuminate\Support\Facades\Input;

class UpdateLocationController extends \BaseController {

    /**
     * Website service to update location on the database
     */
    public function getUpdateLocation()
    {
        $lat = Input::get('gps_latitude');
        $lon = Input::get('gps_longitude');
        $mobile = Input::get('mobile_number');

        // Check if all inputs are not empty
        if($lat && $lon && $mobile)
        {
            // Sql statement to update latitude and longitude depending on the mobile number
            DB::connection('akmo')->update(
                'Update donor
                SET gps_latitude = "'.$lat.'", gps_longitude = "'.$lon.'"
                WHERE donor_id IN
                (
                    SELECT x.donor_id FROM (
                        SELECT donor.donor_id FROM donor
                        INNER JOIN donor_contact ON donor_contact.donor_id = donor.donor_id
                        WHERE content = "'.$mobile.'"
                    ) AS x
                )'
            );
        }
    }

} 