<?php

namespace App\UseCases\Adverts;


use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Advert\Photo;
use App\Entity\Adverts\Advert\Value;
use App\Entity\Adverts\Attribute;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Entity\User;
use App\Http\Requests\Adverts\PhotosRequest;
use App\Http\Requests\Adverts\Rejectrequest;
use App\Jobs\DeletePhotosAdvert;
use App\Notifications\ModeratedAdvert;
use Carbon\Carbon;
use App\Http\Requests\Adverts\EditRequest;

class AdvertService
{
    private function getAdvert($id): Advert
    {
        return Advert::findOrFail($id);
    }

    public function create($userId, $categoryId, $regionId, $request)
    {
        /** @var User $user */
        $user = User::findOrFail($userId);
        /** @var Category $category */
        $category = Category::findOrFail($categoryId);
        /** @var Region $region */
        $region = $regionId ? Region::findOrFail($regionId) : null;

        $advert = \DB::transaction(function() use ($user, $category, $region, $request){

        $advert =  Advert::make(
            [
             'title' => $request['title'],
             'content' => $request['content'],
             'price' => $request['price'],
             'address' => $request['address'],
             'status' => Advert::STATUS_DRAFT
            ]
        );
        $advert->user()->associate($user);
        $advert->category()->associate($category);
        $advert->region()->associate($region);
        $advert->saveOrFail();

        foreach ($request['attributes'] as $attribute=>$value)
        {

            $atrr = new Value();
            $atrr->attribute_id = (int)$attribute;
            $atrr->value = $value;
            $advert->values()->save($atrr);
        }

        return $advert;
        });
        return $advert;
    }

    public function addPhotos($id, PhotosRequest $request): void
    {
        $advert = $this->getAdvert($id);
        \DB::transaction(function () use ($request, $advert) {
            foreach ($request['files'] as $file) {
                $photo =  new Photo();
                $photo->file = $file->store('images/adverts', 'public_public');
                $photo->advert_id = $advert->id;
                $photo->save();
            }
            $advert->update();
        });
    }

    public function edit($id, EditRequest $request): void
    {
        $advert = $this->getAdvert($id);
        $advert->update($request->only([
            'title',
            'content',
            'price',
            'address',
        ]));
    }

    public function sendToModeration($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->sendToModeration();
    }

    public function moderate($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->moderate(Carbon::now());
        $advert->user->notify(new ModeratedAdvert($advert));
    }

    public function reject($id, Rejectrequest $request): void
    {
        $advert = $this->getAdvert($id);
        $advert->reject($request['reason']);
    }
    public function editAttributes($id, $request): void
    {
        $advert = $this->getAdvert($id);
        \DB::transaction(function () use ($request, $advert, $id) {
            $advert->values()->delete();
            foreach ($advert->category->allAttributes() as $attributes) {
                foreach($attributes as $attribute){
                    $value = $request['attributes'][$attribute['id']] ?? null;
                    if (!empty($value)) {
                        $val = new Value();
                        $val->attribute_id = $attribute['id'];
                        $val->value = $value;
                        $advert->values()->save($val);
                    }
                }
            }
            $advert->updated_at = Carbon::now();
            $advert->save();
        });
    }

    public function expire(Advert $advert): void
    {
        $advert->expire();
    }

    public function close($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->close();
    }

    public function remove($id): void
    {
        $advert = $this->getAdvert($id);
        $advert->delete();
    }
}
