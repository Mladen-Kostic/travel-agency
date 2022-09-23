<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Post;

class PostController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateArr = $request->hasFile('post_cover_img')
            ? [
                'users_id' => 'required',
                'post_title' => 'required',
                'post_types' => 'required',
                'post_short_description' => 'required',
                'post_content' => 'required',
                'post_statuses' => 'required',
                'post_cover_img' => 'image|mimes:jpg,jpeg,png,svg|max:2048'
            ]
            : [
                'users_id' => 'required',
                'post_title' => 'required',
                'post_types' => 'required',
                'post_short_description' => 'required',
                'post_content' => 'required',
                'post_statuses' => 'required'
            ];

        $validator = Validator::make($request->all(), $validateArr);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ]);
        }

        if ($request->hasFile('post_cover_img')) {
            $imageName = time() . '.' . $request->file('post_cover_img')->getClientOriginalName();

            $request->file('post_cover_img')->move(public_path('/post_images', $imageName));
        }

        Post::postStore($request);

        return ['success' => true, 'message' => 'Post is created successfully.'];
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
    public function update(Request $request, $id)
    {
        //
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
}
