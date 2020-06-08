<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reservation extends Model
{
    public function places(){
        return $this->belongsToMany(Place::class);
    }

    public function film(){
        return $this->hasOne(Film::class);
    }

    public function getByUserId($id){
        $orders =  DB::select('SELECT r.id,round((COUNT(rp.id)/2)) as count_place,f.img,f.name,f.id as film_id,
          s.date_s, TIME_FORMAT(s.time_start, \'%k:%i\') as time_start,r.kod
          FROM reservations r
          JOIN reservation_places rp ON rp.reservation_id = r.id
          JOIN schedules s ON s.id = r.schedule_id
          JOIN films f ON f.id = s.film_id
          WHERE r.user_id = :id
          GROUP BY f.img,f.name,r.id',['id'=>$id]);
        return $orders;
    }

    public function index(){
        $orders =  DB::select('SELECT r.id,round((COUNT(rp.id)/2)) as count_place,f.img,f.name,f.id as film_id,
          s.date_s, TIME_FORMAT(s.time_start, \'%k:%i\') as time_start,r.kod
          FROM reservations r
          JOIN reservation_places rp ON rp.reservation_id = r.id
          JOIN schedules s ON s.id = r.schedule_id
          JOIN films f ON f.id = s.film_id
          
          GROUP BY f.img,f.name,r.id');
        return $orders;
    }

}
