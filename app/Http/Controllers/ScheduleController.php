<?php

namespace App\Http\Controllers;

use App\Place;
use App\Reservation;
use App\ReservationPlace;
use App\Schedule;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    private $columns = 8;
    private $rows = 18;

    public function getReservation(Request $request){

        $price = DB::table('schedules')
            ->select('schedules.price')
            ->where('schedules.id','=',$request->id_schedule)//$request->id_schedule
            ->first();

        $result = DB::table('reservations')
            ->select(['places.row','places.column'])
            ->join('reservation_places','reservation_places.reservation_id','=','reservations.id')
            ->join('places','places.id','=','reservation_places.place_id')
            ->where('reservations.schedule_id','=',$request->id_schedule)//$request->id_schedule
            ->get();
        $temp = ['places'=>$result,'price'=>$price];

        $places = [];
        for ($i = 0; $i< $this->columns;$i++){
            $places[$i] = [];
            for ($j = 0; $j< $this->rows;$j++){
                $isSet = false;
                $places[$i][$j] = [];
                for($k = 0;$k < count($result);$k++){
                    if($result[$k]->column== $j+1 && $result[$k]->row  == $i+1){
                        $places[$i][$j]['blocked'] = true;
                        $isSet =true;
                        break;
                    }
                }
                if(!$isSet)
                    $places[$i][$j]['blocked'] = false;
                $places[$i][$j]['select'] = false;
            }
        }
        $temp = ['places'=>$places,'price'=>$price];
        return json_encode($temp);
    }
    public function store(Request $request){
        $rowsArray = json_decode($request->rows, true);
        $columnsArray = json_decode($request->columns, true);

        $reservation = new Reservation;
        if($request->user_id){
            $reservation->user_id = $request->user_id;

        }
        $reservation->schedule_id = $request->id_schedule;
        $reservation->kod = rand(1000,10000).''.rand(1000,10000);
        $reservation->phone = $request->phone;
        $reservation->email = $request->email;
        $reservation->save();

        for ($i =0;$i< count($rowsArray);$i++){
            $place = new Place;
            $place->row = $rowsArray[$i];
            $place->column = $columnsArray[$i];
            $place->save();

            $reservation_places = new ReservationPlace;
            $reservation_places->reservation_id = $reservation->id;
            $reservation_places->place_id = $place->id;
            $reservation_places->save();
        }
        return $reservation->kod;
    }

    public function scheduleAdd(Request $request){

        $oldSchedule = Schedule::where('schedules.date_s','=',$request->date)
            ->where('schedules.time_start','<=',$request->time_start)
            ->where('schedules.time_end','>=',$request->time_start)
            ->where('schedules.time_start','<=',$request->time_end)
            ->where('schedules.time_end','>=',$request->time_end)
            ->get();

        if(count($oldSchedule) !=0 )
            return response(['error_message'=>'Сеанс занят'],422);

        $schedule = new Schedule;
        $schedule->film_id = $request->film_id;
        $schedule->date_s = $request->date;
        $schedule->time_start = $request->time_start;
        $schedule->time_end = $request->time_end;
        $schedule->price = $request->price;
        $schedule->save();
        return response(['message'=>$oldSchedule]);
    }

    public function delete($id){
        $schedule = Schedule::find($id);
        $schedule->delete();

        return response('OK');
    }
}
