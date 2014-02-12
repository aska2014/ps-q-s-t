<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Kareem
 * Date: 2/1/14
 * Time: 2:23 PM
 * To change this template use File | Settings | File Templates.
 */

use Kareem3d\Images\Code;
use Kareem3d\Images\Group;
use Kareem3d\Images\Specification;

class ImageSeeder extends \Illuminate\Database\Seeder {

    /**
     *
     */
    public function run()
    {
        Group::query()->delete();
        Specification::query()->delete();

        $group = Group::create(array(
            'name' => 'Product.Main'
        ));

        $group->specs()->create(array(
            'directory' => 'albums/products/306x202'
        ))->setCode(new Code(array(
                'code' => '$image->grab(306, 202, true); return $image;'
            )));

        $group->specs()->create(array(
            'directory' => 'albums/products/250x188'
        ))->setCode(new Code(array(
                'code' => '$image->grab(250, 188, true); return $image;'
            )));

        $group->specs()->create(array(
            'directory' => 'albums/products/422x288'
        ))->setCode(new Code(array(
                'code' => '$image->grab(422, 288, true); return $image;'
            )));

        $group->specs()->create(array(
            'directory' => 'albums/products/normal'
        ));
    }

}