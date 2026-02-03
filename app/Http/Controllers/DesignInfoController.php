<?php
namespace App\Http\Controllers;

use App\Models\DesignInfo;
use Illuminate\Support\Str;
use App\Helpers\DesignHelper;
use App\Models\MaterialSetup;
use App\Http\Requests\DesignRequest;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;


class DesignInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designs = DesignInfo::latest()->paginate(10);
        return view('raw-store.design-info.index', compact('designs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $designNo = DesignHelper::generateDesignNo();
        $allMaterial = MaterialSetup::all();
        return view('raw-store.design-info.create', compact('designNo','allMaterial'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DesignRequest $request)
    {

        $designNo = DesignHelper::generateDesignNo();

        $data = $request->validated();
        $data['design_no'] = $designNo;
        $data['user_id'] = Auth::user()->id;

        // AUTO SLUG DESIGN CODE
        $data['design_code'] = Str::slug(
            $request->product_name . '-' .
            $request->design_name . '-' .
            strtolower(str_replace('-', '', $designNo))
        );

        if ($request->hasFile('design_image')) {
            $data['design_image'] = $this->optimizeImage($request->file('design_image'));
        }

        DesignInfo::create($data);

        $notification = array('message'=>'Design Information successfully', 'alert-type' => 'success');

        return redirect()->route('design-info.index')->with($notification);

        // return redirect()->route('design-info.index')
        //     ->with('success', 'Design Information successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(DesignInfo $designInfo)
    {
        return view('raw-store.design-info.show', compact('designInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DesignInfo $designInfo)
    {
         $allMaterial = MaterialSetup::all();
         return view('raw-store.design-info.edit', compact('designInfo','allMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DesignRequest $request, DesignInfo $designInfo)
    {
        $data = $request->validated();

        $data['design_code'] = Str::slug(
            $request->product_name . '-' .
            $request->design_name . '-' .
            strtolower(str_replace('-', '', $designInfo->design_no))
        );

        if ($request->hasFile('design_image')) {
            if ($designInfo->design_image) {
                Storage::delete($designInfo->design_image);
            }
            $data['design_image'] = $this->optimizeImage($request->file('design_image'));
        }

        $designInfo->update($data);

        $notification = array('message'=>'Design Information updated successfully', 'alert-type' => 'success');

        return redirect()->route('design-info.index')->with($notification);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DesignInfo $designInfo)
    {
         if ($designInfo->design_image) {
            Storage::delete($designInfo->design_image);
        }

        $designInfo->delete();

        $notification = ['message' => 'Design Information deleted', 'alert-type' => 'success'];
            
        return redirect()->back()->with($notification);
        //return back()->with('success', 'Design Information deleted');
    }

    private function optimizeImage($image): string
    {
        $manager = new ImageManager(new Driver());

        $img = $manager->read($image)
            ->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->toJpeg(70);

        $path = 'designs/' . uniqid() . '.jpg';

        Storage::disk('public')->put($path, $img);
        //Storage::disk('public')->put('designs/'.$filename, $img);


        return $path;
    }

}
