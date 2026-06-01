<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\HomeOfferSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HomeOfferSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homeOfferSliders = HomeOfferSlider::orderBy('sort_index')->where('status', true)->paginate(50);
        return view('backend.admin.home-offer-sliders.index', compact('homeOfferSliders'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'image_url' => 'required|image|mimes:jpg,jpeg,png,webp|max:1024',
                'sort_index' => 'required|integer',
                'title' => 'nullable|string|max:191',
                'url' => 'nullable|url|max:191',
            ],
            [
                'image_url.max' => 'Please Choose image of Maximum 1MB Size..',
                'image_url.required' => 'Please Choose Atleast One Image',
                'image_url.image' => 'Please Choose Only Image',
                'image_url.mimes' => 'Please Choose Only image of type JPG,JPEG,PNG,WEBP..',
                'sort_index.required' => 'Please Enter Slider Position',
                'url.url' => 'Please Enter Proper Url',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Add Home Offer Slider', $validator->errors()->first());
            return redirect(route('admin.home-offer-sliders.all'))->withInput();
        }

        if ($request->hasFile('image_url')) {
            $request['img'] = uniqid() . '.' . pathinfo($request->image_url->getClientOriginalName(), PATHINFO_EXTENSION);
            $request->image_url->storeAs('images/home-offer-sliders', $request->img, 'public');
        }

        HomeOfferSlider::create([
            'image_url' => $request->img,
            'sort_index' => $request->sort_index,
            'status' => true,
            'title' => $request->title,
            'url' => $request->url,
        ]);

        connectify('success', 'Home Offer Slider Added', 'New Slider has been added successfully !');

        return redirect(route('admin.home-offer-sliders.all'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\HomeOfferSlider  $homeOfferSlider
     * @return \Illuminate\Http\Response
     */
    public function show(HomeOfferSlider $homeOfferSlider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\HomeOfferSlider  $homeOfferSlider
     * @return \Illuminate\Http\Response
     */
    public function edit($homeOfferSlider)
    {
        try {
            $homeOfferSlider = HomeOfferSlider::where('id', $homeOfferSlider)->firstOrFail();
            return view('backend.admin.home-offer-sliders.edit', compact('homeOfferSlider'));

        } catch (\Exception $ex) {
            connectify('error', 'Edit Home Offer Slider', 'Whoops, Slider Not Found !');
            return redirect(route('admin.home-offer-sliders.all'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\HomeOfferSlider  $homeOfferSlider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slider)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
                'sort_index' => 'required|integer',
                'title' => 'nullable|string|max:191',
                'url' => 'nullable|url|max:191',
            ],
            [
                'image_url.image' => 'Please Choose Only image..',
                'image_url.mimes' => 'Please Choose Only image of type JPG,JPEG,PNG,WEBP..',
                'image_url.max' => 'Please Choose Only image of Maximum 1MB Size..',
                'sort_index.required' => 'Please Enter Sort Index',
                'url.url' => 'Please Enter Proper Url',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Update Home Offer Slider', $validator->errors()->first());
            return redirect(route('admin.home-offer-sliders.edit', $slider))->withInput();
        }

        $homeOfferSlider = HomeOfferSlider::findOrFail($slider);

        // if ($request->hasFile('image_url')) {
        //     $old_image = "images/home-offer-sliders/" . $homeOfferSlider->image_url;
        //     Storage::disk('public')->delete($old_image);
        //     $request->image_url->storeAs('images/home-offer-sliders', $homeOfferSlider->image_url, 'public');

        // }

        // $homeOfferSlider->update([
        //     'status' => $request->status,
        //     'sort_index' => $request->sort_index,
        //     'title' => $request->title,
        //     'url' => $request->url,
        // ]);

        if ($request->hasFile('image_url')) {
            $old_image = "images/home-offer-sliders/" . $homeOfferSlider->image_url;
            Storage::disk('public')->delete($old_image);

            // Generate a unique name
            $new_image_name = uniqid() . '.' . $request->image_url->getClientOriginalExtension();
            $request->image_url->storeAs('images/home-offer-sliders', $new_image_name, 'public');
            $homeOfferSlider->image_url = $new_image_name;
        }

        $homeOfferSlider->update([
            'status' => $request->status,
            'sort_index' => $request->sort_index,
            'title' => $request->title,
            'url' => $request->url,
            // Save the new image name to the database
            'image_url' => $homeOfferSlider->image_url,
        ]);

        connectify('success', 'Home Offer Slider Updated', 'Slider has been updated successfully !');

        return redirect(route('admin.home-offer-sliders.all'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\HomeOfferSlider  $homeOfferSlider
     * @return \Illuminate\Http\Response
     */
    // public function destroy(HomeOfferSlider $homeOfferSlider)
    // {
    //     $old_image = public_path("/storage/images/home-offer-sliders/" . $homeOfferSlider->image_url);
    //     if (File::exists($old_image)) {
    //         File::delete($old_image);
    //     }

    //     $homeOfferSlider->delete();
    //     return redirect(route('admin.home-offer-sliders.all'))->with('messageSuccess', 'Slider Image has been Deleted successfully !');
    // }
    public function destroy(Request $request)
    {
        try {

            $homeOfferSlider = HomeOfferSlider::where('id', $request->slider_id)->firstOrFail();

            $old_image = public_path("/storage/images/home-offer-sliders/" . $homeOfferSlider->image_url);
            if (File::exists($old_image)) {
                File::delete($old_image);
            }

            $homeOfferSlider->delete();

            connectify('success', 'Home Offer Slider Deleted', 'Home Offer Slider has been Deleted successfully !');

            return redirect(route('admin.home-offer-sliders.all'));
        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Home Offer Slider Delete', 'Whoops, Slider Not Found !');

                return redirect(route('admin.home-offer-sliders.all'));
            }

            Log::error('Delete Home Offer Slider: ' . $ex->getMessage());

            connectify('error', 'Home Offer Slider Delete', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.home-offer-sliders.all'));
        }
    }
}
