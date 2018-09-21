<?php
namespace App\Http\Controllers;

use App\Flyer;
use App\Http\Requests\ChangeFlyerRequest;
use App\Photo;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\FlyerRequest;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Auth;

class FlyersController extends Controller
{

    use AuthenticatesUsers ;
    /**
     * FlyersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('flyers.create');
    }


    public function store( User $user , FlyerRequest $request)
    {
        $request->user()->flyer()->create($request->all());
        session()->flash('message', 'thanks for your adv');
        return redirect('/');

    }


    /**
     * @param $zip
     * @param $street
         * @param ChangeFlyerRequest $request
     */
    public function addPhoto($zip, $street, ChangeFlyerRequest $request)
    {
            $photo = Photo::fromFile($request->file('file'));

             Flyer::locatedAt($zip, $street)->addPhoto($photo);

    }
    /**
     * @param UploadedFile $file
     * @return static
     */
    protected function makePhoto(UploadedFile $file)
    {
        return Photo::named($file->getClientOriginalName())->move($file);
    }



    public function show($zip, $street)
    {
        $flyer = Flyer::locatedAt($zip, $street);
        return view('flyers.show', compact('flyer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
