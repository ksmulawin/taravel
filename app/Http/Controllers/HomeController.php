<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Storage;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    public function showAvatar($filename)
    {
      return view('home');
    }

    public function changeAvatar(Request $request)
    {

        $name = time().'_'. Auth::id(). '.'.$request->avatar->getClientOriginalExtension();
        $content = file_get_contents($request->avatar->getRealPath());

        Storage::disk('local')->put('avatar/'.$name, $content);

        DB::table('users')->where('id','=',Auth::id())->update([
                                                                    'avatar' => $name,
                                                              ]);


        return redirect()->back();



    }

}
