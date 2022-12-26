<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends Controller
{
    public function brands()
    {
    	Session::put('page','brands');
    	$brands = Brand::get();
    	//echo "<pre>"; print_r($brands);die;
    	return view('admin.brands.brands')->with(compact('brands'));
    }
    //Update status brand................................................................
    public function updateBrandStatus(Request $request)
    {
    	if ($request->ajax()) {
    		$data =  $request->all();
    		//echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status, 'brand_id' =>$data['brand_id']]);
    	}
    }
 	//save Brand...........................................................................
    public function addEditBrand(Request $request,$id=null)
    {
        if ($id=="") {
            $title = "Add Brand";
            $brand = New Brand;
            $branddata = array();
            $message = "Brand added successully";
        }else{
            $title = "Edit Brand";
            $branddata = Brand::find($id);
            //$branddata = json_decode(json_encode($branddata),true);
            //echo "<pre>"; print_r($productdata);die;
            $brand = Brand::find($id);
            $message = "Brand Uploded successully";
        }
        //Add product Code
        if ($request->isMethod('post')) {
            $data = $request->all();
           //echo "<pre>"; print_r($data);die;
            $brand->name = $data['name'];
            $brand->save();
            session::flash('success_message',$message);
            return redirect('admin/brands');
    }
    return view('admin.brands.add_edit_brand')->with(compact('title','branddata'));
}
//Delete Brand.................................................................................
 public function deleteBrand($id)
    {
        Brand::where('id',$id)->delete();
        $message = 'Brand has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
