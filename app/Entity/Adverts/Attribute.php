<?php

namespace App\Entity\Adverts;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Advert\Attribute
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $category_id
 * @property int $required
 * @property array $variants
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Attribute whereVariants($value)
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    //
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';
    public const TYPE_SLIDER = 'slider';

    protected $table = 'advert_attributes';
    public $timestamps = false;

    protected $guarded = '';
    protected $casts = ['variants'=>'array'];

    public static function typeList():array
    {
        return [
            self::TYPE_STRING => 'string',
            self::TYPE_INTEGER => 'integer',
            self::TYPE_FLOAT => 'float',
            self::TYPE_SLIDER =>'slider'
        ];
    }

    public function isString():bool
    {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger():bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat():bool
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public function isNumber(): bool
    {
        return $this->isInteger() || $this->isFloat();
    }
    public function isSelect(): bool
    {
       if(is_array($this->variants) and count($this->variants) and $this->variants[0] and $this->type !== 'slider'){
           return count($this->variants) > 0;
       }
       return false;
    }
    public function isSlider(): bool
    {
        if(is_array($this->variants) and $this->type == 'slider'){
            return count($this->variants) > 0;
        }
        return false;
    }
}
