<?php

namespace App\Entity\Adverts\Advert;

use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Entity\Advert\Advert\Photo
 *
 * @property int $id
 * @property int $advert_id
 * @property string $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo whereAdvertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Advert\Photo whereId($value)
 * @mixin \Eloquent
 */
class Photo extends Model
{
   protected $table = 'advert_advert_photos';
   public $timestamps = false;
   protected $guarded = '';
}
