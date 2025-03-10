<?php

namespace App\Http\Controllers;

use App\DataTables\FoodsDataTable;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index(FoodsDataTable $dataTable){
        return $dataTable->render('yajra.index');
        // return view('yajra.index');
    }
}
