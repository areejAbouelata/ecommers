<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Flyer extends Model
{

    /**
     * filable fields for the flyer
     * @var array
     * */
    protected $fillable = array(
       'street', 'city', 'zip', 'country', 'states', 'price', 'description'
    );

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User' , 'user_id');
    }

    /**
     * determine if the given user create  the flyer
     * @param User $user
     * @return bool
     */
    public  function ownerBy(User $user)
    {
        return $this->user_id == $user->id ;
    }

    /**
     * @param Builder $query
     * @param $zip
     * @param $street
     * @return Builder
     */
    public static function locatedAt($zip, $street)
    {

        $street = str_replace('-', ' ', $street);

        return static::where(compact('zip', 'street'))->first();

    }

    /**
     * flyer has many photos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
    }


}
