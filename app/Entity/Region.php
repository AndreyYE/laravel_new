<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Static_;

/**
 * App\Entity\Region
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Region[] $children
 * @property-read \App\Entity\Region $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Region whereUpdatedAt($value)
 * @method \Illuminate\Database\Eloquent\Builder roots()
 * @mixin \Eloquent
 */
class Region extends Model
{
    //
    protected $table = 'regions';
    protected $guarded = '';
    public static $allParent = [];
    public static $allChildren = [];


    public function getPath(): string
    {
        return ($this->parent ? $this->parent->getPath() . '/' : '') . $this->slug;
    }

    public function parent()
    {
       return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function getAllParent()
    {
//        $get_parent =  $this->belongsTo(static::class, 'parent_id', 'id')->get()->toArray();
//        if($get_parent){
//            array_push(static::$allParent, $get_parent[0]);
//            Region::findOrFail($get_parent[0]['id'])->getAllParent();
//        }
//        return array_reverse(static::$allParent);
        $get_parent =  $this->belongsTo(static::class, 'parent_id', 'id')->get()->toArray();
        return ($get_parent ?  Region::findOrFail($get_parent[0]['id'])->getAllParent() : '').','.$this->id;

    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    public function allChildren()
    {
//        $get_children =  $this->hasMany(static::class, 'parent_id', 'id')->pluck('id')->toArray();
//        if($get_children){
//            foreach ($get_children as $val){
//                //array_push(static::$allChildren, $val);
//                var_dump($val);
//                 Region::findOrFail($val)->allChildren();
//            }
//        }
////        $array = array_merge([],  static::$allChildren);
////        static::$allChildren = [];
//
//            return $this->id;
        $get_children =  $this->hasMany(static::class, 'parent_id', 'id')->pluck('id')->toArray();
        return $get_children ? array_map(function ($val){return Region::findOrFail($val)->allChildren()[0];}, $get_children) :  [$this->id];
    }

    public function getAddress(): string
    {
        return ($this->parent_id ? $this->find($this->parent_id)->getAddress() : ''). $this->name. ',';
    }
    public function scopeRoots(Builder $query)
    {
        return $query->where('parent_id', null);
    }
}
