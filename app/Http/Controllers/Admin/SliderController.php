<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Slider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('sort_index')->paginate(50);

        return view('backend.admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image_url' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'sort_index' => 'required|integer',
                'title' => 'nullable|string|max:191',
                'subtitle' => 'nullable|string|max:191',
                'description' => 'nullable|string',
                'url' => 'nullable|url|max:191',
                'button_text' => 'nullable|string|max:191',
                'content_position' => 'nullable|string|max:50',
                'text_align' => 'nullable|string|max:50',
            ],
            [
                'image_url.max' => 'Please Choose Desktop Image of Maximum 2MB Size..',
                'image_url.required' => 'Please Choose Desktop Image',
                'image_url.image' => 'Please Choose Only Image for Desktop',
                'mobile_image.max' => 'Please Choose Mobile Image of Maximum 2MB Size..',
                'mobile_image.image' => 'Please Choose Only Image for Mobile',
                'sort_index.required' => 'Please Enter Slider Position',
                'url.url' => 'Please Enter Proper Url',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Add Slider', $validator->errors()->first());

            return redirect(route('admin.sliders.all'))->withInput();
        }

        $desktop_img = null;
        if ($request->hasFile('image_url')) {
            $desktop_img = uniqid() . '.' . pathinfo($request->image_url->getClientOriginalName(), PATHINFO_EXTENSION);
            $request->image_url->storeAs('images/sliders/desktop', $desktop_img, 'public');
        }

        $mobile_img = null;
        if ($request->hasFile('mobile_image')) {
            $mobile_img = uniqid() . '.' . pathinfo($request->mobile_image->getClientOriginalName(), PATHINFO_EXTENSION);
            $request->mobile_image->storeAs('images/sliders/mobile', $mobile_img, 'public');
        }

        Slider::create([
            'image_url' => $desktop_img,
            'mobile_image' => $mobile_img,
            'sort_index' => $request->sort_index,
            'status' => true,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'url' => $request->url,
            'button_text' => $request->button_text,
            'content_position' => $request->content_position ?? 'center-left',
            'text_align' => $request->text_align ?? 'left',
        ]);

        connectify('success', 'Slider Added', 'Slider has been added successfully !');

        return redirect(route('admin.sliders.all'));
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Slider  $slider
     * @return Response
     */
    public function edit($slider)
    {
        try {
            $slider = Slider::where('id', $slider)->firstOrFail();

            return view('backend.admin.sliders.edit', compact('slider'));
        } catch (\Exception $ex) {

            if ($ex instanceof ModelNotFoundException) {

                connectify('error', 'Slider Edit', 'Whoops, Slider Not Found !');

                return redirect(route('admin.sliders.all'));
            }

            Log::error(['Edit Slider' => $ex->getMessage()]);

            connectify('error', 'Slider Update', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.sliders.all'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Slider  $slider
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'mobile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'sort_index' => 'required|integer',
                'title' => 'nullable|string|max:191',
                'subtitle' => 'nullable|string|max:191',
                'description' => 'nullable|string',
                'url' => 'nullable|url|max:191',
                'button_text' => 'nullable|string|max:191',
                'content_position' => 'nullable|string|max:50',
                'text_align' => 'nullable|string|max:50',
            ],
            [
                'image_url.image' => 'Please Choose Only image for Desktop..',
                'image_url.mimes' => 'Please Choose Only image of type JPG, JPEG, PNG, WEBP..',
                'image_url.max' => 'Please Choose Only image of Maximum 2MB Size..',
                'mobile_image.image' => 'Please Choose Only image for Mobile..',
                'mobile_image.mimes' => 'Please Choose Only image of type JPG, JPEG, PNG, WEBP..',
                'mobile_image.max' => 'Please Choose Only image of Maximum 2MB Size..',
                'sort_index.required' => 'Please Enter Sort Index',
                'url.url' => 'Please Enter Proper Url',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Update Slider', $validator->errors()->first());

            return redirect(route('admin.sliders.edit', $id))->withInput();
        }

        try {
            $slider = Slider::where('id', $id)->firstOrFail();

            if ($request->hasFile('image_url')) {
                if ($slider->image_url) {
                    Storage::disk('public')->delete('images/sliders/desktop/' . $slider->image_url);
                    Storage::disk('public')->delete('images/sliders/' . $slider->image_url);
                }

                $new_image_name = uniqid() . '.' . $request->image_url->getClientOriginalExtension();
                $request->image_url->storeAs('images/sliders/desktop', $new_image_name, 'public');
                $slider->image_url = $new_image_name;
            }

            if ($request->hasFile('mobile_image')) {
                if ($slider->mobile_image) {
                    Storage::disk('public')->delete('images/sliders/mobile/' . $slider->mobile_image);
                    Storage::disk('public')->delete('images/sliders/' . $slider->mobile_image);
                }

                $new_mobile_name = uniqid() . '.' . $request->mobile_image->getClientOriginalExtension();
                $request->mobile_image->storeAs('images/sliders/mobile', $new_mobile_name, 'public');
                $slider->mobile_image = $new_mobile_name;
            }

            $slider->update([
                'status' => $request->status,
                'sort_index' => $request->sort_index,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'url' => $request->url,
                'button_text' => $request->button_text,
                'content_position' => $request->content_position ?? 'center-left',
                'text_align' => $request->text_align ?? 'left',
                'description' => $request->description,
                'image_url' => $slider->image_url,
                'mobile_image' => $slider->mobile_image,
            ]);

            connectify('success', 'Slider Updated', 'Slider has been Updated successfully !');

            return redirect(route('admin.sliders.all'));
        } catch (\Exception $ex) {
            if ($ex instanceof ModelNotFoundException) {

                connectify('error', 'Slider Update', 'Whoops, Slider Not Found !');

                return redirect(route('admin.sliders.all'));
            }

            Log::error(['Update Slider' => $ex->getMessage()]);

            connectify('error', 'Slider Update', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.sliders.all'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Slider  $slider
     * @return Response
     */
    public function destroy(Request $request)
    {
        try {
            $slider = Slider::where('id', $request->slider_id)->firstOrFail();

            if ($slider->image_url) {
                Storage::disk('public')->delete('images/sliders/desktop/' . $slider->image_url);
                Storage::disk('public')->delete('images/sliders/' . $slider->image_url);
            }

            if ($slider->mobile_image) {
                Storage::disk('public')->delete('images/sliders/mobile/' . $slider->mobile_image);
                Storage::disk('public')->delete('images/sliders/' . $slider->mobile_image);
            }

            $slider->delete();

            connectify('success', 'Slider Deleted', 'Slider has been Deleted successfully !');

            return redirect(route('admin.sliders.all'));
        } catch (\Exception $ex) {

            if ($ex instanceof ModelNotFoundException) {

                connectify('error', 'Slider Delete', 'Whoops, Slider Not Found !');

                return redirect(route('admin.sliders.all'));
            }

            Log::error(['Delete Slider' => $ex->getMessage()]);

            connectify('error', 'Slider Delete', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.sliders.all'));
        }
    }
}
