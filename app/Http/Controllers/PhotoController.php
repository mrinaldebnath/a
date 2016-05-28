<?php

namespace App\Http\Controllers;

use App\Picture;
use App\notify;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Image;

use Auth;

class PhotoController extends Controller
{
    public function showPictureList()
    {
        $pictures = Picture::all();
        return view('picturelist')->with('pictures', $pictures);
    }

    public function addPicture()
    {
        if(Auth::check()){
       

        return view('3Add');
    	}
    	return Redirect('/auth/register');
    }

    public function savePicture(Request $request)
    {

    	 $user=Auth::user();
         $user->id;
         $file = Input::file('pic');
         $img = Image::make($file);
         Response::make($img->encode('jpeg'));

         $picture = new Picture;
         $picture->user_id=$user->id;
         $picture->email = $request->get('email');
         $picture->contact = $request->get('contact');
         $picture->division = $request->get('division');
         $picture->district = $request->get('district');
         $picture->thana = $request->get('thana');
         $picture->description = $request->get('description');
         $picture->tag = $request->get('tag');
         $picture->price = $request->get('price');
         $picture->pic = $img;
         $picture->save();


         return Redirect::to('list');
    }
    public function edit($id)
    {
        //
        if(Auth::check()){
        $any_variable2=Picture::findOrFail($id);
         $user=Auth::user();
         $user->email;
         $user->name;
       


        $Notify = new notify;
       
         $Notify->email = $user->email;
         $Notify->name =  $user->name;
         
        
         $Notify->not_id=$any_variable2->user_id;
         $Notify->district = $any_variable2->district;
         $Notify->thana = $any_variable2->thana;
         $Notify->description = $any_variable2->description;
         
         $Notify->save();
        

     	}
     	return Redirect('/auth/register');

       
    }

    /*
     * Extracts picture's data from DB and makes an image 
     */
    public function showPicture($id)
    {
        $picture = Picture::findOrFail($id);
        $pic = Image::make($picture->pic);
        $response = Response::make($pic->encode('jpeg'));

        //setting content-type
        $response->header('Content-Type', 'image/jpeg');

        return $response;
    }
}