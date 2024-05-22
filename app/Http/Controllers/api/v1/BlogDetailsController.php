<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BlogManager;
use App\Models\Admin\GeneralSettings;


class BlogDetailsController extends Controller
{
    public function index(Request $request)
    {
        // echo '<pre>';
        // print_r($request->all());
        // die();
        $checkBlog = BlogManager::where('slug', $request->slug)->first();

        if (empty($checkBlog)) {
            $response = [
                'message' => 'Blog not exists',
                'status' => '0',
            ];
        } else {
            $mediaName = url('/') . "/uploads/blogImage/" . getMediaName($checkBlog['image_id']);
    
            $response = [
                'message' => 'Blog exists',
                'status' => '1',
                'data' => [
                'title' => $checkBlog->title,
                'slug' => $checkBlog->slug,
                'image' => $mediaName,
                'description' => $checkBlog->description,
                'published_on' => $checkBlog->published_on,
                ]
            ];
        }
    
        return response()->json($response, 201);
    }
}
