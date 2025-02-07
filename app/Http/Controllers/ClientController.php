<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\CateItems;
use App\Models\Products;
use App\Models\Comments;

class ClientController extends Controller
{
    public function __construct()
    {
        $allCate=Categories::all();
        view()->share('allCate', $allCate);
    }
    public function index()
    {
        $homeTopPr = Products::where('hot','=','1')->limit(3)->get();
        $homeNewPr = Products::orderBy('id','desc')->get();
        $homeSalePr = Products::orderBy('discount','desc')->limit(6)->get();
        return view('client.pages.index',['homeTopPr'=>$homeTopPr,'homeNewPr'=>$homeNewPr,'homeSalePr'=>$homeSalePr]);
    }
    public function contact()
    {
        return view('client.pages.contact');
    }
    public function getProByCate($id)
    {
        $listPro=Categories::find($id)->Products;
        $cti_bar=Categories::find($id)->Cate_items;
        return view('client.pages.category',['listPro'=>$listPro,'cti_bar'=>$cti_bar]);
    }
    public function getProByCateItem($id)
    {
        $listPro=CateItems::find($id)->Products;
        $cti_bar=Categories::find($id)->Cate_items;
        return view('client.pages.category',['listPro'=>$listPro,'cti_bar'=>$cti_bar]);
    }
    public function getProById($id)
    {
        $pro=Products::find($id);
        $images=Products::find($id)->Images;
        return view('client.pages.product',['pro'=>$pro,'images'=>$images]);
    }

    public function getCateItemByCate($id)
    {
        $cateItems=CateItems::where('cate_id','=',$id)->get();
        return $cateItems;
    }
}
