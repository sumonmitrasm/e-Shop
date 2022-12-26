<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use App\Category;
use Session;
use Image;
use App\AdminsRole;
use Auth;
class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page','categories');
    	$categories = Category::with(['section','parentcategory'])->get();
    	//$categories = json_encode(json_encode($categories));
    	//echo "<pre>"; print_r($categories); die;
        //set role and permission .................................................170...27
        $categoryModuleCount = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'categories'])->count();
        //dd($categoryModuleCount);
        if (Auth::guard('admin')->user()->type=="superadmin") {
            $categoryModule['view_access'] = 1;
            $categoryModule['edit_access'] = 1;
            $categoryModule['full_access'] = 1;
        }else if ($categoryModuleCount==0) {
            $message = "This feature is not active for you";
            Session::flash('error_message',$message);
            return redirect('admin/dashboard');
        }else{
            $categoryModule = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'categories'])->first()->toArray();
             //dd($categoryModule);die;
        }
    	return view('admin.categories.categories')->with(compact('categories','categoryModule'));
    }
     public function updateCategoryStatus(Request $request)
    {
    	if ($request->ajax()) {
    		$data =  $request->all();
    		//echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Category::where('id',$data['category_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status, 'category_id' =>$data['category_id']]);
    	}
    }
    public function addEditCategory(Request $request, $id=null)
    {
        if ($id=="") {
        //add category Functionality
            $title = "Add Category";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "Category added successfully";
        }else{
            $title = "Edit Category";
            $categorydata = Category::where('id',$id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);
            //echo "<pre>"; print_r($categorydata);die;
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            //echo "<pre>"; print_r($getCategories);die;
            $category = Category::find($id);
            $message = "Category has been update successfully";
        }


        if ($request->isMethod('post')) {
            $data=$request->all(); 
            //echo "<pre>"; print_r($data); die;

            // Category validasion i am having a hard time understanding this 
             $rules = [
            'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'section_id' => 'required',
            'url' => 'required',
            'category_image' => 'image',
            ];

            $customMessages = [
            'category_name.required' => 'Category Name is required',
            'category_name.regex'=>'valid Name is required',
            'section_id.required'=>'Section is required',
            'url.required'=>'Category Url is required',
            'category_image.image'=>'Valid Category image is required',
            ];
            $this->validate($request,$rules,$customMessages);
            // Uplode category Image
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    # get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image
                    $imageName = rand(111, 99999).'.'.$extension;
                    $imagePath = 'images/category_images/'.$imageName;
                    //Uplode the Image
                    Image::make($image_tmp)->save($imagePath);
                    //Save Category Image
                    $category->category_image = $imageName;
                }
            }
            if (empty($data['category_discount'])) {
                $data['category_discount']="";
            }
            if (empty($data['description'])) {
                $data['description']="";
            }
            if (empty($data['meta_description'])) {
                $data['meta_description']="";
            }
            if (empty($data['meta_keywords'])) {
                $data['meta_keywords']="";
            }



            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();
            Session::flash('success_message',$message);
            return redirect('admin/categories');
        }

        // Get all the section..............................
        $getSections = Section::get();
        return view('admin.categories.add_edit_category')->with(compact('title','getSections','categorydata','getCategories'));
    }
    public function appendCategoryLevel(Request $request)
    {
        if ($request->ajax()) {
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,'status'=>1])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            //echo "<pre>"; print_r($getCategories);die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategoryImage($id)
    {
        //get Category Image
        $categoryImage = Category::select('category_image')->where('id',$id)->first();

        //Get Category Image Path
        $category_image_path = 'images/category_image/';

        //Delete Category image from category-images folder if exists
        if (file_exists($category_image_path.$categoryImage->category_image)) {
            unlink($category_image_path.$categoryImage->category_image);
        }

        //Delte Category Image category table
        Category::where('id',$id)->update(['category_image'=>'']);
        $message = 'Category image has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteCategory($id)
    {
        Category::where('id',$id)->delete();
        $message = 'Category has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
