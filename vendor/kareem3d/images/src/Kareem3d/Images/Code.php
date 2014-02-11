<?php namespace Kareem3d\Images;

use Kareem3d\Eloquent\Model;

class Code extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ka_codes';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return string
     */
    public function getReadyCode()
    {
        return $this->code;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function evaluate( array $parameters = array() )
    {
        extract($parameters);

        return eval($this->getReadyCode());
    }
}