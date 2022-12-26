<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CmsPage;
use Session;
use Validator;

class CmsController extends Controller
{
    public function cmsPages()
    {
        Session::put('page','cms_page');
        $cms_pages = CmsPage::get()->toArray();
        //dd($cms_pages);
        return view('admin.pages.cms_pages')->with(compact('cms_pages'));
    }

    public function updateCmsPagesStatus(Request $request)
    {
        if ($request->ajax()) {
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status']=="Active") {
                $status = 0;
            }else{
                $status = 1;
            }
            CmsPage::where('id',$data['cms_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'cms_id' =>$data['cms_id']]);
        }
    }
    public function addEditCmsPage(Request $request,$id=null)
    {
        if ($id=="") {
            $title = "Add Cms page";
            $cmspage = New CmsPage;
            //$cmspage = array();
            $message = "Cms page added successully";
        }else{
            $title = "Edit CmsPage";
            $cmspage = CmsPage::find($id);
            //$cmspage = json_decode(json_encode($cmspage),true);
            //echo "<pre>"; print_r($productdata);die;
            //$cmspage = CmsPage::find($id);
            $message = "Cms page Uploded successully";
        }
        //Add product Code
        if ($request->isMethod('post')) {
            $data = $request->all();
           //echo "<pre>"; print_r($data);die;
            $rules = [
            'title' => 'required',
            'description' => 'required',
            'url' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            ];

            $customMessages = [
            'title.required' => 'Title is required',
            'description.required' => 'Description is required',
            'url.required' => 'Url is required',
            'meta_title.required' => 'Meta_title is required',
            'meta_description.required' => 'Meta_description is required',
            'meta_keywords.image'=>'Meta_keywords is required',
            ];
            $this->validate($request,$rules,$customMessages);
            $cmspage->title = $data['title'];
            $cmspage->description = $data['description'];
            $cmspage->url = $data['url'];
            $cmspage->meta_title = $data['meta_title'];
            $cmspage->meta_description = $data['meta_description'];
            $cmspage->meta_keywords = $data['meta_keywords'];
            $cmspage->save();
            session::flash('success_message',$message);
            return redirect('admin/cms-pages');
     }
     return view('admin.pages.add-edit-cms-page')->with(compact('title','cmspage'));
    }

    public function deleteCmspage($id)
    {
        CmsPage::where('id',$id)->delete();
        $message = 'Cms page has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
