<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function store(Request $request)
    {

       
        $request->validate([
            'title'                             => 'required|string',
            'category'                          => 'required|string',
            'modules'                           => 'required|array',
            'modules.*.title'                   => 'required|string',
            'modules.*.contents'                => 'required|array',
            'modules.*.contents.*.title'        => 'required|string',
            
        ]);
       
        $course                 = new Course();
        $course->title          = $request->title;
        $course->description    = $request->description;
        $course->category       = $request->category;
        $course->save();

        $course_id = $course->id;

        foreach ($request->modules as $moduleData) {
            $module             = new Module();
            $module->title      = $moduleData['title'];
            $module->course_id  = $course_id;
            $module->save();

            foreach ($moduleData['contents'] as $contentData) {
                $content                    = new Content();
                $content->title             = $contentData['title'];
                $content->video_source_type = $contentData['video_type'];
                $content->video_length      = $contentData['video_length'];
                $content->video_source_url  = $contentData['video_url'];
                $content->module_id         = $module->id;

                // Handle file upload
                if (isset($contentData['image']) && file_exists($contentData['image'])) {
                    $imageName = time() . '_' . $contentData['image']->getClientOriginalName();
                    $contentData['image']->move(public_path('uploads/content-images'), $imageName);
                    $content->image = 'images/' . $imageName;
                } else {
                    $content->image = null;
                }
                $content->save();
            }
        }

         // Redirect to the course index page with a success message

        return redirect()->route('home')->with('success', 'Course created successfully.');
    }
}
