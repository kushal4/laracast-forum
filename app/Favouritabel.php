<?php


namespace App;


trait Favouritabel
{

    protected  static  function  bootFavouritabel(){
        static::deleting(function($model){
            $model->favourites->each->delete();
        });
    }
    public function favourites(){
        return $this->morphMany(Favourite::class,'favourited');
    }

    public function favourite(){

        $attributes=['user_id'=>auth()->id()];
        // dd($attributes);
        if(!($this->favourites()->where($attributes))->exists()){
            $this->favourites()->create($attributes);
        }

    }

    public function unfavourite(){
        $attributes=['user_id'=>auth()->id()];
      //  $this->favourites()->where($attributes)->delete();
//        $this->favourites()->where($attributes)->get()->each(function($favourite){
//                $favourite->delete();
//        });
        $this->favourites()->where($attributes)->get()->each->delete();
    }

    public function  isFavourited(){

        return!! $this->favourites->where('user_id',auth()->id())->count();
    }

    public function getIsFavouritedAttribute(){
        return $this->isFavourited();
    }

    public function getFavouritesCountAttribute(){
        return $this->favourites->count();
    }
}