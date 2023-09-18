<?php

namespace App\Http\Controllers;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtistController extends Controller
{
    function index() {
        $artists = Artist::all();
        if ($artists->count() > 0) {
            $data = [
                'status' => 200,
                'artists' =>$artists
            ];
    
            return response()->json($data, 200);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'No Records Found'
            ], 404);
        }
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'genre' => 'required|string|max:50',
            'description' => 'required|string|max:250',
            'urlPicture' => 'string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages() 
            ],422);
        } else {
            $artist = Artist::create([
                'name' => $request->name,
                'genre' => $request->genre,
                'description' => $request->description,
                'urlPicture' => $request->urlPicture
            ]);

            if ($artist) {
                return response()->json([
                    'status'=> 200,
                    'message' => 'Artist Created Successfully'
                ],200);
            } else {
                return response()->json([
                    'status'=> 500,
                    'message' => 'Something went wrong :('
                ],500);
            }
        }
    }

    public function show($id) 
    {
        $artist = Artist::find($id);
        if ($artist) {
            return response()->json([
                'status'=> 200,
                'artist' => $artist
            ],200);
        } else {
            return response()->json([
                'status'=> 500,
                'message' => 'No Artist Found!'
            ],500);
        }
    }

    public function update(Request $request, int $id) 
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:191',
            'genre' => 'required|string|max:50',
            'description' => 'required|string|max:250',
            'urlPicture' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages() 
            ],422);
        } else {
            //? Find the Artist
            $artist = Artist::find($id);
            if ($artist) {
                //? Then update it
                $artist->update([
                    'name' => $request->name,
                    'genre' => $request->genre,
                    'description' => $request->description,
                    'urlPicture' => $request->urlPicture
                ]);

                return response()->json([
                    'status'=> 200,
                    'message' => 'Artist Updated Successfully'
                ],200);
            } else {
                return response()->json([
                    'status'=> 404,
                    'message' => 'No such Artist found :('
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $artist = Artist::find($id);
        if ($artist) {
            $artist->delete();
            return response()->json([
                'status'=> 200,
                'message' => 'Artist Deleted Successfully'
            ],200);

        } else {
            return response()->json([
                'status'=> 404,
                'message' => 'No such Artist found :('
            ],500);
        }
    }
}
