<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners()
    {
    	Session::put('page','banners');
    	$banners = Banner::get();
    	//$banners = json_decode(json_encode($banners),true);
    	//echo "<pre>"; print_r($banners);
    	return view('admin.banners.banners')->with(compact('banners'));
    }
     public function updateBannerStatus(Request $request)
    {
    	if ($request->ajax()) {
    		$data =  $request->all();
    		//echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status, 'banner_id' =>$data['banner_id']]);
    	}
    }
     public function deleteBanner($id)
    {
        //get Banner Image
        $bannerImage = Banner::select('image')->where('id',$id)->first();

        //Get Banner Image Path
        $banner_image_path = 'images/banner_images/';

        //Delete Product image from category-images folder if exists
        if (file_exists($banner_image_path.$bannerImage->image)) {
            unlink($banner_image_path.$bannerImage->image);
        }

        //Delte Banner Image category table
        Banner::where('id',$id)->delete();
        $message = 'Banner Image has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
    public function addEditBanner(Request $request,$id=null)
    {
    	if ($id=="") {
    		$title = "Add Banner";
    		$banner = new Banner;
    		$message = "Banner added successully";
    	}else{
    		$title = "Edit Banner";
    		$banner = Banner::find($id);
    		$message = "Banner Uploded successully";
    		
    	}
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		//echo "<pre>";print_r($data);die;
    		// Uplode Banner Image
           if ($request->hasFile('image')) {
               $image_tmp = $request->file('image');
               if ($image_tmp->isValid()) {
                   //Uplode images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                //generate New Imag Nmane
                $imageName = $image_name.'-'.rand(111, 99999).'.'.$extension;
                $banner_image_path = 'images/banner_images/'.$imageName;
                //uplode Banner image after resise
                Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);
                //Save banner imag in banners table
                $banner->image = $imageName;
               }
            }
    		$banner->link = $data['link'];
    		$banner->title = $data['title'];
    		$banner->alt = $data['alt'];
    		$banner->save();
    		session::flash('success_message',$message);
            return redirect('admin/banners');
    	}
    	return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }
}
