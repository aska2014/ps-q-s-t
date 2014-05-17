<?php namespace Website;

use GeoLocation;


class ContactUs {

    /**
     * @var GeoLocation
     */
    protected $geoLocation;

    /**
     * @param GeoLocation $geoLocation
     */
    public function __construct(GeoLocation $geoLocation)
    {
        $this->geoLocation = $geoLocation;
    }

    /**
     * @return string
     */
    public function getEmailAddress()
    {
        return 'support@qbrando.com';
    }

    /**
     * @return string
     */
    public function getMobileNumber()
    {
        if($this->geoLocation->isEgypt())
        {
            return '00201001337501';
        }

        return '+97470010560';
    }

}