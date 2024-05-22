<?php
namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BlogManager;
use App\Models\Admin\GeneralSettings;


class BlogPaginationController extends Controller
{
    public function index(Request $request)
    {
        $currentIndex = $request->input('currentIndex');

        $maxRecordsOnPage = GeneralSettings::value('max_records');
        $totalRecords = BlogManager::count();
        $offset = ($currentIndex - 1) * $maxRecordsOnPage;
        $totalPages = ceil($totalRecords / $maxRecordsOnPage);

        $blogs = BlogManager::skip($offset)
            ->take($maxRecordsOnPage)
            ->get();
            // echo '<pre>';
            // print_r($blogs);
            // die();

        $data = [];

        foreach ($blogs as $blog) {
            $mediaName = url('/') . "/uploads/blogImage/" . getMediaName($blog['image_id']);
            $data[] = [
                'id' => $blog['id'],
                'title' => $blog['title'],
                'slug' => $blog['slug'],
                'media_name' => $mediaName,
                'description' => $blog['description']
            ];
        }

        $response = [
            'totalRecords' => $totalRecords,
            'totalPages' => $totalPages,
            'currentPage' => $currentIndex,
            'recordsPerPage' => $maxRecordsOnPage,
            'data' => $data,
        ];

        return response()->json($response);
    }
}
