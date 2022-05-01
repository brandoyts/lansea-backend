<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $jobs = Job::with('user')->get();

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'success',
            'data' => $jobs
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $job = Job::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'user_id' => auth()->user()->id
        ]);

          return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Job successfully created',
            'data' => $job
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $fields = $request->validate([
            'id' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $job = auth()->user()->listing->find($fields['id']);

        if (!$job) {
             return response()->json([
            'status' => 404,
            'success' => false,
            'message' => 'Job not found',
            ], 404);
        }

        $job->update([
            'title' => $fields['title'],
            'description' => $fields['description'],
        ]);


         return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Job successfully updated',
            'data' => $job
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        auth()->user()->listing->find($job->id);

        return response()->json([
            'status' => 204,
            'success' => true,
            'message' => 'Job successfully deleted',
        ], 204);
    }

    // clear all current user's listings
    public function clearAll()
    {
        $userId = auth()->user()->id;

        Job::where('user_id', $userId)->delete();

        return response()->json([
            'status' => 204,
            'success' => true,
            'message' => 'Job successfully deleted',
        ], 204);
    }
}
