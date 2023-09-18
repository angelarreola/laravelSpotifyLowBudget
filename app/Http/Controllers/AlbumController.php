<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    function index() {
        $albums = Album::all();
        if ($albums->count() > 0) {
            $data = [
                'status' => 200,
                'albums' =>$albums
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
            'name' => 'required|string|max:100',
            'artist_id' => 'required|integer',
            'publication_date' => 'required|date',
            'numberOfSongs' => 'required|integer',
            'urlPicture' => 'string',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages() 
            ],422);
        } else {
            $album = Album::create([
                'name' => $request->name,
                'artist_id' => $request->artist_id,
                'publication_date' => $request->publication_date,
                'numberOfSongs' => $request->numberOfSongs,
                'urlPicture' => $request->urlPicture
            ]);

            if ($album) {
                return response()->json([
                    'status'=> 200,
                    'message' => 'Album Created Successfully'
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
        $album = Album::find($id);
        if ($album) {
            return response()->json([
                'status'=> 200,
                'album' => $album
            ],200);
        } else {
            return response()->json([
                'status'=> 500,
                'message' => 'No Album Found!'
            ],500);
        }
    }

    public function update(Request $request, int $id) 
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:100',
            'artist_id' => 'required|integer',
            'publication_date' => 'required|date',
            'numberOfSongs' => 'required|integer',
            'urlPicture' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages() 
            ],422);
        } else {
            //? Find the Album
            $album = Album::find($id);
            if ($album) {
                //? Then update it
                $album->update([
                    'name' => $request->name,
                    'artist_id' => $request->artist_id,
                    'publication_date' => $request->publication_date,
                    'numberOfSongs' => $request->numberOfSongs,
                    'urlPicture' => $request->urlPicture
                ]);

                return response()->json([
                    'status'=> 200,
                    'message' => 'Album Updated Successfully'
                ],200);
            } else {
                return response()->json([
                    'status'=> 404,
                    'message' => 'No such Album found :('
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $album = Album::find($id);
        if ($album) {
            $album->delete();
            return response()->json([
                'status'=> 200,
                'message' => 'Album Deleted Successfully'
            ],200);

        } else {
            return response()->json([
                'status'=> 404,
                'message' => 'No such Album found :('
            ],500);
        }
    }
}
