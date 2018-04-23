<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Validator;

use App\Schedules;
use App\Bucket;
use App\Trips;


class ScheduleController extends Controller
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
        $sched = Schedules::where('user_id',Auth::id())->paginate(10);
				$bucket =  app('App\Http\Controllers\BucketListController')->showBucketList();
        return view('menu.schedule')->with('schedule',$sched)->with('bucket',$bucket);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

		 public function validationRules($request)
		 {
				 $rules = [
		 					'destination' => 'required',
		 					'checkin' => 'required',
		 					'checkout' => 'required',
		 				];
		 		$validator = Validator::make($request->all(),$rules);
				return $validator;
		 }

    public function createSchedule(Request $request)
    {
			$validator = $this->validationRules($request);
			if($validator->fails())
			{
				 return back()->withErrors($validator);
			}
			else
			{
				$sched = new Schedules;
				$sched->destination = $request->destination;
				$sched->details = $request->details;
				$sched->status = 'drawing';
				$sched->planned_date = $this->dateFormat($request->checkin);
				$sched->checkout_date = $this->dateFormat($request->checkout);
				$sched->user_id = Auth::id();
				$sched->save();
				$request->session()->flash('success','Great! New Schedule Added!');
        return redirect('schedules');
			}
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
    public function editSchedule($id)
    {
			// $filter = ['id' => $id,'user_id' => Auth::id()];
			$sched = Schedules::where('id',$id)
												->where('user_id',Auth::id())
												->first();
			return view('menu.schedule_edit')->with('sched',$sched);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSchedule(Request $request)
    {
			$validator = $this->validationRules($request);
			if($validator->fails())
			{
				 return back()->withErrors($validator);
			}
			else
			{
					DB::table('schedules')->where('id',$request->input('schedule_id'))
																->update([
																						'destination' => $request->input('destination'),
																						'details' => $request->input('details'),
																						'planned_date' => $this->dateFormat($request->input('checkin')),
																						'checkout_date' => $this->dateFormat($request->input('checkout')),
																					]);
					$request->session()->flash('success','Great! Schedule updated.');

          return redirect('schedules');
			}

    }

		public function dateFormat($date)
		{
			return date('Y-m-d H:i:s',strtotime($date));
		}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

		public function removeSchedule(Request $request,$id)
		{
				$sched = Schedules::find($id);
				$sched->delete();
				$request->session()->flash('success','Great! Schedule removed!.');
				return redirect('schedules');
		}

		public function colorSchedule(Request $request,$id)
		{
				$sched = Schedules::find($id);
				$sched->status = 'colored';
				$sched->update();

				$trips = new Trips;
				$trips->schedule_id = $id;
				$trips->story = '';
				$trips->save();

				$request->session()->flash('success','Great! Schedule status updated!.');
				return redirect('schedules');
		}
}
