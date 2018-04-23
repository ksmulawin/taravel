<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;

use App\Trips;
use App\Schedules;

class TripsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trips = DB::table('trips')
                    ->select(
                                DB::raw("
                                            trips.id,
                                            destination,
                                            DATE_FORMAT(schedules.planned_date, '%M %d, %Y') as checkin_date,
                                            DATE_FORMAT(schedules.planned_date, '%M %d, %Y') checkout_date,
                                            details,story
                                          ")

                            )
                    ->leftjoin('schedules','schedules.id','=','trips.schedule_id')
                    ->where('schedules.user_id','=',Auth::id())
                    ->orderBy('schedules.planned_date')
                    ->get();

        return view('menu.trip')->with('trips',$trips);
    }


    function editTrip($id)
    {
        $trips = Trips::where('trips.id','=',$id)
                      ->select(DB::raw("trips.id,
                                        destination,
                                        DATE_FORMAT(schedules.planned_date, '%M %d, %Y') as checkin_date,
                                        DATE_FORMAT(schedules.planned_date, '%M %d, %Y') checkout_date,
                                        details,story"))
                      ->leftjoin('schedules','schedules.id','=','trips.schedule_id')
                      ->first();
        return view('menu.trip_edit')->with('trips',$trips);
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

    function createStory(Request $request)
    {
      $rules = [
                 'story' => 'required',
                 'trip_id' => 'required'
               ];
       $validator = Validator::make($request->all(),$rules);
       if($validator->fails())
       {
          return back()->withErrors($validator);
       }

       Trips::where('id','=',$request->trip_id)->update([
                                                            'story' => $request->story
                                                        ]);
      // $request->session('flash')->success('')
      return redirect('trips');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
