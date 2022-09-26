<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

use App\Models\Post;

class PostController extends Controller
{
    public function archive(Request $request) {

        $validator = Validator::make($request->all(), ['id' => 'required']);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()
            ]);
        }

        Post::archive($request->id);

        return ['success' => true, 'message' => 'Post archived successfully.'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::postAll();
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
                'post_short_description' => 'required|max:255',
                'post_content' => 'required',
                'post_statuses' => 'required',
                'post_cover_img' => 'image|mimes:jpg,jpeg,png,svg|max:2048'
            ]
            : [
                'users_id' => 'required',
                'post_title' => 'required',
                'post_types' => 'required',
                'post_short_description' => 'required|max:255',
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

        $imageName = '';

        if ($request->hasFile('post_cover_img')) {
            $imageName = time() . '.' . $request->file('post_cover_img')->getClientOriginalName();

            $request->file('post_cover_img')->move(public_path('/post_images'), $imageName);

        }

        Post::postStore($request, $imageName);

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
        return Post::showPost($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Post::postEdit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validateArr = $request->hasFile('post_cover_img')
            ? [
                'id' => 'required',
                'post_title' => 'required',
                'post_types' => 'required',
                'post_short_description' => 'required|max:255',
                'post_content' => 'required',
                'post_statuses' => 'required',
                'post_cover_img' => 'image|mimes:jpg,jpeg,png,svg|max:2048'
            ]
            : [
                'id' => 'required',
                'post_title' => 'required',
                'post_types' => 'required',
                'post_short_description' => 'required|max:255',
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

        $imageName = '';

        if ($request->hasFile('post_cover_img')) {
            $imageName = time() . '.' . $request->file('post_cover_img')->getClientOriginalName();

            File::delete('post_images/' . $request->post_cover_img_delete);

            $request->file('post_cover_img')->move(public_path('/post_images'), $imageName);

        }

        Post::postUpdate($request, $imageName);

        return ['success' => true, 'message' => 'Post updated successfully.'];
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
