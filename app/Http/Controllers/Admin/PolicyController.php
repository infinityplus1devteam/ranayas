<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PolicyController extends Controller
{
    /**
     * Show the form for editing the specified policy.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        try {
            $policy = Policy::where('slug', $slug)->firstOrFail();
            return view('backend.admin.policies.edit', compact('policy'));
        } catch (\Exception $ex) {
            connectify('error', 'Policy Management', 'Policy page not found.');
            return redirect()->route('admin.dashboard');
        }
    }

    /**
     * Update the specified policy in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:191',
            'content' => 'required|string',
        ], [
            'title.required' => 'Please Enter Policy Title',
            'content.required' => 'Please Enter Policy Content',
        ]);

        if ($validator->fails()) {
            connectify('error', 'Update Policy', $validator->errors()->first());
            return redirect()->route('admin.policies.edit', $slug)->withInput();
        }

        try {
            $policy = Policy::where('slug', $slug)->firstOrFail();
            
            $policy->update([
                'title' => $request->title,
                'content' => $request->content,
            ]);

            connectify('success', 'Updated Policy', 'Policy has been updated successfully');
            return redirect()->route('admin.policies.edit', $slug);

        } catch (\Exception $ex) {
            Log::error(['Update Policy' => $ex->getMessage()]);
            connectify('error', 'Update Policy', 'Whoops, Something Went Wrong from our end!');
            return redirect()->route('admin.policies.edit', $slug)->withInput();
        }
    }
}
