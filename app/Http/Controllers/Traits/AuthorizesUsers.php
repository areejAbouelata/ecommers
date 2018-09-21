<?php


namespace  App\Http\Controllers\Traits;
use  App\Http\Requests;
use App\Flyer;
trait AuthorizesUsers {


    protected  function  unauthorized(Request $request)
    {
        if ($request->ajax()){
            return response(['message' => 'no way'] , 403) ;
        }
        flash('No way') ;
        return redirect('/');
    }
    protected  function userCreatedFlyer(Request $request)
    {
        return Flyer::where([
            'zip' =>$request->zip ,
            'street' => $request->street,
            'user_id' => $request->user->id
        ])->exists() ;
    }


}
