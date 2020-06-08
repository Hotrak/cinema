<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Film extends Model
{
    //SELECT t.name FROM types t
    //JOIN film_types ft ON t.id = ft.id_type
    //WHERE ft.id_film = 1;

    public function getType(){
        $types = DB::table('types')
            ->join('film_types','types.id','=','film_types.id_type')
            ->select('name')
            ->where('film_types.id_film','=','1')
            ->get();
        dd($types);
        return $types;
    }
    public function types(){
        return $this->belongsToMany(Type::class);
    }
    public function schedule(){

        return DB::table('schedules')
            ->select(['id','time_start','date_s'])
            ->where('schedules.film_id','=',$this->id)
            ->whereDate('schedules.date_s','>=',now())
            ->orderBy('date_s')
            ->orderBy('time_start')
            ->get();
    }

    public function getTimePositions(){
        $times = DB::table('schedules')
            ->select('time_start')
            ->where('schedules.film_id','=',$this->id)
            ->whereDate('schedules.date_s','>=',now())
            ->orderBy('time_start')
            ->groupBy('time_start')
            ->get();

        $positions = [];
        for($i=0;$i<$times->count();$i++){
            $positions[$times[$i]->time_start] = $i;
        }
        return $positions;
    }

    public function getSchedule(){
        $schedule = $this->schedule();

        if($schedule->count()==0)
            return null;

        $positions = $this->getTimePositions();

        $temp = $schedule[0];
        $count = 0;
//        $result[] = ['date_s'=>$this->getFormatDate($temp->date_s),'info'=>[]];
//        foreach ($schedule as $item){
//            if($temp->date_s != $item->date_s){
//                $result[] = ['date_s'=>$this->getFormatDate($item->date_s),'info'=>[]];
//                $count++;
//            }
//            $result[$count]['info'][] = ['id'=>$item->id,'time_start'=> $this->getFormatTime($item->time_start),'position'=>$positions[$item->time_start]];
//            $temp = $item;
//        }
        $result[] = ['date_s'=>$this->getFormatDate($temp->date_s),'date_unform'=>$temp->date_s,'info'=>[]];
        $testCount = 0;
        for($i=0;$i<count($schedule);$i++){
            if($temp->date_s != $schedule[$i]->date_s){
                $result[] = ['date_s'=>$this->getFormatDate($schedule[$i]->date_s),'date_unform'=>$schedule[$i]->date_s,'info'=>[]];
                $count++;
                $testCount = 0;
            }

            foreach($positions as $key => $value)
            {
                if($key == $schedule[$i]->time_start){
                    $result[$count]['info'][] = ['id'=>$schedule[$i]->id,'time_start'=> $this->getFormatTime($schedule[$i]->time_start),'position'=>$positions[$schedule[$i]->time_start]];
                    break;
                }else
                    if($testCount < $value || count($result[$count]['info']) ==0){
                        $result[$count]['info'][] = [];
                        $testCount++;
                    }
            }
            $temp = $schedule[$i];
        }
        $ttt=['data'=>$result];
        return $ttt;
    }
    public $days =['Понедельник','Вторник','Среда','Четверг','Пятница','Суббота','Воскресение'];
    public $months =['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'];

    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public static function getNames(){
        $all_films = Film::all();
        $films_short = $all_films->map(function ($film) {
            return ['id'=>$film->id,'img'=>$film->img,'name'=>$film->name];
        });;
        return $films_short;
    }

    private function getFormatDate($date){

        $month = (int)date("m",strtotime($date));
        $day = date("d",strtotime($date));
        $day_of_week= (int)date("w",strtotime($date));
        return $day.', '.$this->months[$month-1].', '.$this->days[$day_of_week];
    }
    private function getFormatTime($time){

        $format_time = date("H:i",strtotime($time));

        return $format_time;
    }

}
