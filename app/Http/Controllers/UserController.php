<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function uploadFile(){
        Session::remove('all');
        return view('uploadFile');
    }

    public function store(Request $request){
        $request->validate([
                'file' => 'required|file',
            ]);

        $file = $request->file('file');

        $path = $file->storeAs('csv', \Str::random(40) . '.' . $file->getClientOriginalExtension());
        $file = fopen(storage_path('app/'.$path), 'r');
        $all_data = array();
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ){

            $array = $data;
           // dd($data);
            array_push($all_data, $array);
        }
        fclose($file);
        //dd($all_data);
        $all_data = \GuzzleHttp\json_encode($all_data);

        Session::push('all', $all_data);
        return redirect()->route('bar');
    }

    public function circle(Request $request){

        $all = Session::get('all');
        $all = $all[0];

        if($request->ajax()){
            return response()->json(array('all'=>$all));
        }

        return view('circle',compact('all'));
    }

    public function bar(Request $request){

        $all = Session::get('all');
        $all = $all[0];

        if($request->ajax()){
            return response()->json(array('all'=>$all));
        }
        return view('bar',compact('all'));
    }

    public function coordinate(Request $request){

        $all = Session::get('all');
        $all = $all[0];

        if($request->ajax()){
            return response()->json(array('all'=>$all));
        }

        return view('coordinate',compact('all'));
    }

    public function scircle(Request $request){

        $all = Session::get('all');
        $all = $all[0];

        return view('scircle',compact('all'));
    }

    public function sbar(Request $request){

        $all = Session::get('all');
        $all = $all[0];

        return view('sbar',compact('all'));
    }

    public function scoordinate(Request $request){

        $all = Session::get('all');
        $all = $all[0];

        return view('scoordinate',compact('all'));
    }

    public function save(Request $request){
        if($request->ajax()){

            $all = $request->all;
            Session::remove('all');
            $all = \GuzzleHttp\json_encode($all);

            Session::push('all', $all);
            return response()->json(['success' => 1], 200);
        }
        return 1;
    }

    public function updateData(){
        $all = Session::get('all');
        $all = $all[0];
        $all= \GuzzleHttp\json_decode($all);

        return view('updateData',compact('all'));
    }
}
