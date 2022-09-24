<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id'
    ];

    public static function postStore($request) {
        $lastInsertId = DB::table('posts')->insertGetId([
            'users_id' => $request->users_id,
            'post_types_id' => $request->post_types,
            'post_title' => $request->post_title,
            'post_short_description' => $request->post_short_description,
            'post_content' => $request->post_content,
            'post_cover_img' => $request->hasFile('post_cover_img') ? $request->post_cover_img_name : '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $published_at = date('Y-m-d H:i:s');
        $archived_at = date('Y-m-d H:i:s');
        $staging = $request->post_statuses === 'staging' ? 1 : 0;

        if ($request->post_statuses === 'published_at') {
            $postStatusesArr = [
                'posts_id' => $lastInsertId,
                'published_at' => $published_at,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        if ($request->post_statuses === 'archived_at') {
            $postStatusesArr = [
                'posts_id' => $lastInsertId,
                'archived_at' => $archived_at,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        if ($request->post_statuses === 'staging') {
            $postStatusesArr = [
                'posts_id' => $lastInsertId,
                'staging' => $staging,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }
        
        DB::table('post_statuses')->insert($postStatusesArr);
    }
}
