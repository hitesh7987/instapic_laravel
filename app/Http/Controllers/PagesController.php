<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index($numb, $numb2){
        $data['num1'] = $numb;
        $data['num2'] = $numb2;
        //return $numb. "Whose index is this ?" .$numb2;
    return view('pages.some',$data);
    }
    public function services(){
        $data['service']=['PHP','JAVA','JAVASCRIPT','CSS'];
        return view('pages.services',$data);
    }
}
