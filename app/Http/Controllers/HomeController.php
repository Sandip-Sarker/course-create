<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function store(Request $request)
    {

        dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'modules' => 'required|array',
            'modules.*.title' => 'required|string',
            'modules.*.contents' => 'nullable|array',
            'modules.*.contents.*.type' => 'required|string',
            'modules.*.contents.*.content' => 'required|string',
        ]);

        $course = Course::create($validated);

        foreach ($validated['modules'] as $moduleData) {
            $module = $course->modules()->create([
                'title' => $moduleData['title'],
            ]);

            foreach ($moduleData['contents'] ?? [] as $contentData) {
                $module->contents()->create($contentData);
            }
        }

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }
}
