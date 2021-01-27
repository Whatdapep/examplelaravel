<?php

namespace App\Http\Controllers;

use App\Models\VisiterCounter;
use App\Models\www_data;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    //

    public function index()
    {


        // dd($this->AddVisitor());
        $this->AddVisitor();
        $data = www_data::limit(12)->get();
        $data_news = www_data::where('Category', '=', 'news')->orderBy('No', 'desc')->limit(15)->get();
        // dd(csrf_token());
        // return response()->json(['data'=>$data]);
        // dd(request()->ip());
        return view('info.home', compact('data', 'data_news'));
    }

    private function AddVisitor()
    {
        $GetCurrentIP = VisiterCounter::where('ip_address', '=', request()->ip())
            ->where('visit_date', '=', date('Y-m-d'))
            ->first();

        if (empty($GetCurrentIP)) {
            $storeVisitor = new VisiterCounter;
            $storeVisitor->ip_address = request()->ip();
            $storeVisitor->visit_date = date('Y-m-d');
            $storeVisitor->visit_time = date('H:i:s');
            $storeVisitor->session_id = csrf_token();
            if ($storeVisitor->save()) {
                return true;
            }
        } else {
            if ($GetCurrentIP->session_id == csrf_token()) {
                return true;
            } else {
                $storeVisitor = new VisiterCounter;
                $storeVisitor->ip_address = request()->ip();
                $storeVisitor->visit_date = date('Y-m-d');
                $storeVisitor->visit_time = date('H:i:s');
                $storeVisitor->session_id = csrf_token();
                if ($storeVisitor->save()) {
                    return true;
                }
            }
        }
    }
}
