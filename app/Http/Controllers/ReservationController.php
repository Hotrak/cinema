<?php

namespace App\Http\Controllers;

use App\Film;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(){
        $films = Film::all();
        return view('my_orders',['films'=>$films]);
    }

    public function show($id){

        $reservation = DB::table('reservations')
            ->where('reservations.id','=',$id)
            ->join('schedules','schedules.id','=','reservations.schedule_id')
            ->join('films','films.id','=','schedules.film_id')
            ->join('reservation_places','reservation_places.reservation_id','=','reservations.id')
            ->join('places','places.id','=','reservation_places.place_id')
            ->select('films.name',
                DB::raw('TIME_FORMAT(schedules.time_start, \'%H:%i\') as time_start'),
                'schedules.date_s',
                'schedules.price',
                'reservations.kod',
                'places.row',
                'places.column'
            )
            ->groupBy('films.name',
                'schedules.time_start',
                'schedules.date_s',
                'schedules.price',
                'reservations.kod',
                'places.row',
                'places.column')
            ->get();
//        dd($reservation);
        return $reservation;
    }

    public function userOrders($userId){

        $user = Auth::user();
        $reservation = new Reservation();

        if(isset($user)){
            if($user->hasRole('admin')){
                 return $reservation->index();
            }
        }
        return $reservation->getByUserId($userId);
    }

    public function delete($id){
        $reservation = Reservation::find($id);
        $reservation->delete();
    }
}
