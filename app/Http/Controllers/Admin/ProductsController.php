<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Session;
use App\Section;
use App\Category;
use App\Brand;
use App\ProductsAttribute;
use App\ProductsImage;
use Image;
use App\AdminsRole;
use Auth;


class ProductsController extends Controller
{
   public function products()
    {
        Session::put('page','products');
        $products = Product::with(['category','section'])->get();
        //$products = json_decode(json_encode($products));
        //echo "<pre>"; print_r($products); die;
        //set role and permission .................................................170...27
        $productsModuleCount = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'products'])->count();
        //dd($productsModuleCount);
        if (Auth::guard('admin')->user()->type=="superadmin") {
            $productsModule['view_access'] = 1;
            $productsModule['edit_access'] = 1;
            $productsModule['full_access'] = 1;
        }else if ($productsModuleCount==0) {
            $message = "This feature is not active for you";
            Session::flash('error_message',$message);
            return redirect('admin/dashboard');
        }else{
            $productsModule = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'products'])->first()->toArray();
             //dd($productsModule);die;
        }
        return view('admin.products.products')->with(compact('products','productsModule'));

    }
    // Update product status....................................................................
    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status']=="Active") {
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id' =>$data['product_id']]);
        }
    }
    // Delete product............................................................................
     public function deleteProduct($id)
    {
        Product::where('id',$id)->delete();
        $message = 'Product has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
    // Add products..............................................................................

    public function addEditProduct(Request $request,$id=null)
    {
        if ($id=="") {
            $title = "Add Product";
            $product = New Product;
            $productdata = array();
            $message = "Product added successully";
        }else{
            $title = "Edit Product";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata),true);
            //echo "<pre>"; print_r($productdata);die;
            $product = Product::find($id);
            $message = "Product Uploded successully";
        }
        //Add product Code
        if ($request->isMethod('post')) {
            $data = $request->all();
           //echo "<pre>"; print_r($data);die;
            //validation............................
            // Product validasion i am having a hard time understanding this 
             $rules = [
            'category_id' => 'required',
            'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'product_code' => 'required|regex:/^[\w-]*$/',
            'product_price' => 'required|numeric',
            'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
            'category_id.required'=>'Category is required',
            'product_name.required' => 'Product Name is required',
            'product_name.regex'=>'valid Name is required',

            'product_code.required' => 'Product Code is required',
            'product_code.regex'=>'valid Code is required',

            'product_price.required' => 'Product Price is required',
            'product_price.numeric'=>'valid Price is required',

            'product_color.required' => 'Product Color is required',
            'product_color.regex'=>'valid Color is required',
            
            
            ];
            $this->validate($request,$rules,$customMessages);

            if (empty($data['is_featured'])) {
                $is_featured = "No";
            }else{
                $is_featured = "Yes";
            }
            //echo $is_featured; die;
            if (empty($data['fabric'])) {
                $data['fabric'] = "";
            }
            // Uplode product Image
           if ($request->hasFile('main_image')) {
               $image_tmp = $request->file('main_image');
               if ($image_tmp->isValid()) {
                   //Uplode images after Resize
                $image_name = $image_tmp->getClientOriginalName();
                $extension = $image_tmp->getClientOriginalExtension();
                $imageName = $image_name.'-'.rand(111, 99999).'.'.$extension;
                $large_image_path = 'images/product_images/large/'.$imageName;
                $medium_image_path = 'images/product_images/medium/'.$imageName;
                $small_image_path = 'images/product_images/small/'.$imageName;
                Image::make($image_tmp)->save($large_image_path);
                Image::make($image_tmp)->resize(500,500)->save($medium_image_path);
                Image::make($image_tmp)->resize(250,250)->save($small_image_path);
                $product->main_image = $imageName;
               }
            }
            //uplode product videos
            if ($request->hasFile('product_video')) {
               $video_tmp = $request->file('product_video');
               if ($video_tmp->isValid()) {
                   //Uplode images after Resize
                $video_name = $video_tmp->getClientOriginalName();
                $extension = $video_tmp->getClientOriginalExtension();
                $videoName = $video_name.'-'.rand().'.'.$extension;
                $video_path = 'videos/product_videos/';
                $video_tmp->move($video_path,$videoName);
                $product->product_video = $videoName;
               }
            }
            //Save Products Dtails in product Table................
            $categoryDetails = Category::find($data['category_id']);
            //echo "<pre>";print_r($categoryDetails);die;
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->group_code = $data['group_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care']; 
            $product->fabric = $data['fabric']; 
            $product->pattern = $data['pattern']; 
            $product->sleeve = $data['sleeve']; 
            $product->fit = $data['fit']; 
            $product->occassion = $data['occassion']; 
            $product->meta_title = $data['meta_title']; 
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();
            session::flash('success_message',$message);
            return redirect('admin/products');
        }
        
        //Product Filter 
        $productFilters = Product::productFilters();
        //echo "<pre>";print_r($productFilters);die;
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occassionArray = $productFilters['occassionArray'];
        //Section with categories and subcategories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);
        //echo "<pre>"; print_r($categories);
        //Get all the active brands.....................................................
        $brands = Brand::where('status',1)->get();
        $brands = json_decode(json_encode($brands),true);
        return view('admin.products.add_edit_product')->with(compact('title','fabricArray','sleeveArray','patternArray','fitArray','occassionArray','categories','productdata','brands'));

   } 
   public function deleteProductImage($id)
    {
        //get Product Image
        $ProductImage = Product::select('main_image')->where('id',$id)->first();

        //Get product Image Path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        //Delete product image from product-images-small folder if exists
        if (file_exists($small_image_path.$ProductImage->main_image)) {
            unlink($small_image_path.$ProductImage->main_image);
        }
        //Delete product image from product-images-medium_image_path folder if exists
        if (file_exists($medium_image_path.$ProductImage->main_image)) {
            unlink($medium_image_path.$ProductImage->main_image);
        }
        //Delete product image from product-images-large_image_path folder if exists
        if (file_exists($large_image_path.$ProductImage->main_image)) {
            unlink($large_image_path.$ProductImage->main_image);
        }
        //Delte product Image product table
        Product::where('id',$id)->update(['main_image'=>'']);
        $message = 'Product image has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }

    public function deleteProductVideo($id)
    {
        //get Product Image
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        //Get Product Image Path
        $product_video_path = 'videos/product_videos/';

        //Delete Product image from category-images folder if exists
        if (file_exists($product_video_path.$productVideo->product_video)) {
            unlink($product_video_path.$productVideo->product_video);
        }

        //Delte Product Image category table
        Product::where('id',$id)->update(['product_video'=>'']);
        $message = 'Product video has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
//Attibute..................................................................................................
    public function addAttributes(Request $request,$id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data);die;
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    //SKU allready exists check
                    $attrCountSKU = ProductsAttribute::where(['sku'=>$value])->count();
                        if ($attrCountSKU>0) {
                            $message = 'SKU allready exist. Please add defferent SKU!';
                            session::flash('error_message',$message);
                            return redirect()->back();
                        }
                    //Size allready exist......................
                    $attrCountSize = ProductsAttribute::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                        if ($attrCountSize>0) {
                            $message = 'Size allready exist. Please add defferent Size!';
                            session::flash('error_message',$message);
                            return redirect()->back();
                        }
                    $attibute = new ProductsAttribute;
                    $attibute->product_id = $id;
                    $attibute->sku = $value;
                    $attibute->size = $data['size'][$key];
                    $attibute->price = $data['price'][$key];
                    $attibute->stock = $data['stock'][$key];
                    $attibute->save();
                }
            }
            $success_message = 'Product attribute has been Add successfully';
            session::flash('success_message',$success_message);
            return redirect()->back();
        }

        $productdata = Product::select('id','product_name','product_code','product_color','main_image')->with('attributes')->find($id);
        //$productdata = Product::with('attributes')->find($id);
        //$productdata = json_decode(json_encode($productdata),true);
        //echo "<pre>"; print_r($productdata);die;
        $productdata = json_decode(json_encode($productdata),true);
        //echo "<pre>"; print_r($productdata); die;
        $title = "Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata','title'));
    }

    public function editAttributes(Request $request,$id)
    {
       if ($request->isMethod('post')) {
           $data = $request->all();
           //echo "<pre>"; print_r($data);die;
           foreach ($data['attrId'] as $key => $attr) {
               if (!empty($attr)) {
                   ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key],'sku'=>$data['sku'][$key]]);
               }
           }
           $message = "Product Attribute has been updated successfully";
            session::flash('success_message',$message);
            return redirect()->back();
           
       }
    }
    //Update ProductAttribute status..................
    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status']=="Active") {
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'attribute_id' =>$data['attribute_id']]);
        }
    }
    // Delete product............................................................................
     public function deleteAttribute($id)
    {
        ProductsAttribute::where('id',$id)->delete();
        $message = 'Product Attribute has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
    //Multiple Images Uploded....................................................................
    public function addImages(Request $request,$id)
    {
        //seve images code.........................///////////////////
        if ($request->isMethod('post')) {
            //$data = $request->all();
            //echo "<pre>";print_r($data);die; {just show data is comming or not}
           // echo "<pre>";print_r($request->hasFile('image'));die; {0 or 1 comming or not for the images}
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                //echo "<pre>";print_r($images);die; 
                foreach ($images as $key => $image) {
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);
                    //echo $orginalName = $image->getClientOriginalName(); die;  {get orginal image name}
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,999999).time().".".$extension;
                    $large_image_path = 'images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/product_images/small/'.$imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();
                }
                $message = 'Product Addisional Images has been uploded successfully!';
                Session::flash('success_message',$message);
                return redirect()->back();
            }
        }
        //<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>?????????????just retrive data code bellow
       //$productdata = Product::find($id);
       $productdata = Product::with('images')->select('id','product_name','product_code','product_color','main_image')->find($id);
       $productdata = json_decode(json_encode($productdata),true);
       //echo "<pre>"; print_r($productdata);
       $title = "Add addisional Images";
       return view('admin.products.add_images')->with(compact('productdata','title'));
    }
    //Addessional Images status uploded..................................
    public function updateImageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status']=="Active") {
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'image_id' =>$data['image_id']]);
        }
    }
    // Delete product Addessional images..................................
     public function deleteImage($id)
    {
        //get Product Image
        $ProductImage = ProductsImage::select('image')->where('id',$id)->first();

        //Get product Image Path
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';

        //Delete product image from product-images-small folder if exists
        if (file_exists($small_image_path.$ProductImage->image)) {
            unlink($small_image_path.$ProductImage->image);
        }
        //Delete product image from product-images-medium_image_path folder if exists
        if (file_exists($medium_image_path.$ProductImage->image)) {
            unlink($medium_image_path.$ProductImage->image);
        }
        //Delete product image from product-images-large_image_path folder if exists
        if (file_exists($large_image_path.$ProductImage->image)) {
            unlink($large_image_path.$ProductImage->image);
        }
        //Delte product Image product table
        ProductsImage::where('id',$id)->delete();
        $message = 'Product images has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}

