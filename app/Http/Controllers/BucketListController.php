<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Validator;

use App\Bucket;

class BucketListController extends Controller
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
		$bucket = $this->showBucketList();
        return view('menu.bucket')->with('bucket',$bucket);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	public function showBucketList()
	{
		$bucket = Bucket::where('user_id',Auth::id())->paginate(10);
		return $bucket;
	}
	 
    public function createBucket(Request $request)
    {
		 $rules = [
					'destination'=>'required',
					'details'=>'required',
					];
		
		$validator = Validator::make($request->all(),$rules);

        if($validator->fails()){

            return back()->withErrors($validator);

        }else{

            $bucket = new Bucket;
            $bucket->destination = $request->input('destination');
            $bucket->details = $request->input('details');
            $bucket->user_id =  Auth::id();
            $bucket->save();

            $request->session()->flash('success','Great! New Destination Added!');

            return redirect('bucket_list');

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
    public function editBucket(Request $request)
    {
        $rules = [
					'destination'=>'required',
					'details'=>'required',
					'bucket_id' => 'required | int',
        ];

        $validator = Validator::make($request->all(),$rules);
		

        if($validator->fails()){

            return back()->withErrors($validator);

        }else{

            DB::table('buckets')->where('id',$request->input('bucket_id'))->update([
                'destination'=>$request->input('destination'),
                'details'=>$request->input('details'),
            ]);

            $request->session()->flash('success','Great! Destination updated.');

            return redirect('bucket_list');

        }
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
	
	public function bucketData($id)
	{
		 $bucket = Bucket::find($id);
		 return view('menu.bucket_edit')->with('bucket',$bucket);
	}
	
	public function removeDestination(Request $request,$id){
        $bucket = Bucket::find($id);
        $bucket->delete();
        $request->session()->flash('success','Great! Destination removed!.');
        return back();

    }
	
}
