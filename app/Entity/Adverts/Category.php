<?php

namespace App\Entity\Adverts;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use mysql_xdevapi\Collection;

/**
 * App\Entity\Advert\Category
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $_lft
 * @property int $_rgt
 * @property int|null $parent_id
 * @property-read \Kalnoy\Nestedset\Collection|\App\Entity\Adverts\Category[] $children
 * @property-read \App\Entity\Adverts\Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category d()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Adverts\Category newModelQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Adverts\Category newQuery()
 * @method static \Kalnoy\Nestedset\QueryBuilder|\App\Entity\Adverts\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereLft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereRgt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Adverts\Category whereSlug($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Adverts\Attribute[] $attributes
 */
class Category extends Model
{
    //
    use NodeTrait;
    public $timestamps = false;
    protected $table = 'advert_categories';
    protected $fillable = ['name', 'slug', 'parent_id'];

    public function getPath(): string
    {
        return implode('/', array_merge($this->ancestors()->defaultOrder()->pluck('slug')->toArray(), [$this->slug]));
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class,'category_id','id');
    }

    public function parentAttributes()
    {
        $allAttritutes = [];
        foreach ($this->ancestors as $per){
            array_push($allAttritutes, Category::findOrFail($per['id'])->attributes()->orderBy('sort')->get());
        }
        return $allAttritutes;
    }

    public function AllAttributes()
    {
        $arr = $this->parentAttributes();
        array_push($arr, collect($this->attributes()->get()->toArray()));
        return $arr;
    }
    public function getChildren()
    {

    }

}
