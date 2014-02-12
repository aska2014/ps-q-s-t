<?php namespace Kareem3d\Images;

use Illuminate\Support\Facades\DB;
use Kareem3d\Eloquent\Model;
use Kareem3d\PathManager\Path;
use Kareem3d\PathManager\PathException;

class Version extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ka_versions';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Validations rules
     *
     * @var array
     */
    protected $rules = array(
        'image_id' => 'required|exists:images,id',
        'url' => 'required|url',
        'width' => 'required|integer',
        'height' => 'required|integer'
    );

    /**
     * For factoryMuff package to be able to fill attributes.
     *
     * @var array
     */
    public static $factory = array(
        'url' => 'http://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/187793_431846433497472_1192504853_q.jpg',
        'width' => 50,
        'image_id' => 'factory|Gallery\Image\Image',
        'height' => 50
    );

    /**
     * @param $query
     * @param Image $image
     */
    public function scopeByImage($query, Image $image)
    {
        return $query->where('image_id', $image->id);
    }

    /**
     * @param $query
     * @param $width
     * @param $height
     * @param bool $lowerSize
     */
    public function scopeNearestDim($query, $width, $height, $lowerSize = false)
    {
        $query = $query->where(function ($query) use($width, $height) {

            $query->where('width', '>=', $width)->where('height', '>=', $height);

        });

        if ($lowerSize)
        {
            $query->orWhere(function ($query) use($width, $height) {

                $query->where('width', '<=', $width)->where('height', '<=', $height);
            });
        }

        if ($width)  $query->orderBy(DB::raw('ABS(width - ' . $width . ')'), 'ASC');
        if ($height) $query->orderBy(DB::raw('ABS(height - ' . $height . ')'), 'ASC');

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeSmallestDim($query)
    {
        return $query->orderBy('width', 'ASC')->orderBy('height', 'ASC');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeLargestDim($query)
    {
        return $query->orderBy('width', 'DESC')->orderBy('height', 'DESC');
    }

    /**
     * Generate version dimensions.
     *
     * @param  string $url
     * @return Version|null
     */
    public static function generate($url)
    {
        if (!$imageInfo = @getimagesize($url)) return null;

        return new Version(array(
            'url' => $url,
            'width' => $imageInfo[0],
            'height' => $imageInfo[1],
        ));
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get image for this image.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function image()
    {
        return $this->belongsTo(App::make('Kareem3d\Images\Image')->getClass());
    }

    /**
     * @return bool
     */
    public function delete()
    {
        try {
            $this->getServerPath()->delete();

        } catch (PathException $e) {
        }

        return parent::delete();
    }

    /**
     * @return Path
     */
    public function getServerPath()
    {
        return Path::make($this->url);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->url;
    }
}