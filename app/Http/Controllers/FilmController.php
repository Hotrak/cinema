<?php

namespace App\Http\Controllers;

use App\Film;
use App\FilmType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::all();

        $schedule = DB::select('
        SELECT films.name,films.img_b,schedules.id,schedules.date_s,TIME_FORMAT(schedules.time_start , \'%H:%i\') as time_start,
        schedules.time_start as time_s
  FROM films
       
       JOIN schedules ON schedules.film_id = films.id 
        WHERE schedules.id = 
  (SELECT schedules.id 
  FROM schedules 
  WHERE schedules.film_id = films.id  
  AND schedules.date_s >= DATE(NOW())
    
  ORDER BY schedules.date_s,schedules.time_start 
  LIMIT 1 )
        ');

        return view('main',['films'=>$films,'schedule'=> $schedule]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file('img')->store('uploads','public');
        $path_b = $request->file('img_b')->store('uploads','public');

        $film = new Film;
        $film->name = $request->name;
        $film->year = $request->year;
        $film->time = $request->time;
        $film->description = $request->description;
        $film->video_url = $request->videoUrl;
        $film->img = $path;
        $film->img_b = $path_b;
        $film->save();

        $types = json_decode($request->types);
        for($i=0;$i<count($types);$i++){
           $filmType = new FilmType;
           $filmType->film_id = $film->id;
           $filmType->type_id = $types[$i];
           $filmType->save();
        }

        return $types;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::find($id);
        $film->types;
        $films = Film::all();
        return view('film',['film'=>$film,'films'=>$films]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $film = Film::find($id);

        if($request['is_new_img']=='true'){
            $path = $request->file('img')->store('uploads','public');
            $film->img = $path;
        }
        if($request['is_new_img_b']=='true'){
            $path_b = $request->file('img_b')->store('uploads','public');
            $film->img_b = $path_b;
        }

        $film->name = $request->name;
        $film->year = $request->year;
        $film->time = $request->time;
        $film->description = $request->description;
        $film->video_url = $request->videoUrl;
        $film->save();

        FilmType::where('film_id','=',$film->id)->delete();

        $types = json_decode($request->types);
        for($i=0;$i<count($types);$i++){
            $filmType = new FilmType;
            $filmType->film_id = $film->id;
            $filmType->type_id = $types[$i];
            $filmType->save();
        }
    }

    public function filmTypes($filmId){
        $film = Film::find($filmId);
        $types = $film->types;

        return $types;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);
        $film->delete();
    }
}
