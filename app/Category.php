<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories()
    {
    	return $this->hasMany('App\Category','parent_id')->where('status',1);
    }
    public function section()
    {
    	return $this->belongsTo('App\Section','section_id')->select('id','name');
    }

    public function parentcategory()
    {
    	return $this->belongsTo('App\Category','parent_id')->select('id','category_name');
    }
    public static function catDetails($url)
    {
        $catDetails = Category::select('id','parent_id','category_name','url','description')->with(['subcategories'=>function($query){
            $query->select('id','parent_id','category_name','url','description')->where('status',1);
        }])->where('url',$url)->first()->toArray();
        //dd($catDetails); die;
        if ($catDetails['parent_id']==0) {
            //only Show main category in Breadcrumb
            $breadcrumb = '<a href="'.url($catDetails['url']).'">'.$catDetails['category_name'].'</a>';
        }else{
            $parentcategory = Category::select('category_name','url')->where('id',$catDetails['parent_id'])->first()->toArray();
            $breadcrumb = '<a href="'.url($parentcategory['url']).'">'.$parentcategory['category_name'].'</a>&nbsp;<span class="divider">/</span>&nbsp;<a href="'.url($catDetails['url']).'">'.$catDetails['category_name'].'</a>';
        }
        $catIDs = array();
        $catIDs[] = $catDetails['id'];
        foreach ($catDetails['subcategories'] as $key => $subcat) {
            $catIDs[] = $subcat['id'];
        }
        //dd($catIDs);die;
        return array('catIDs'=>$catIDs,'catDetails'=>$catDetails,'breadcrumb'=>$breadcrumb);
    }
}
