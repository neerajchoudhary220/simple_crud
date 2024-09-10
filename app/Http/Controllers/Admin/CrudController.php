<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrudFormRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class CrudController extends Controller
{
   

    public function index(){
        return view('crud.index');
    }
    public function list(Request $request){
        if($request->ajax()){
            $_order = request('order');
            $_columns = request('columns');
            $order_by = $_columns[$_order[0]['column']]['name'];
            $order_dir = $_order[0]['dir'];
            $search = request('search');
            $skip = request('start');
            $take = request('length');

            $query = Student::query();
            if (isset($search['value'])) {
                $query->where('name', 'like', '%' . $search['value'] . '%');
            };

            $data = $query->orderBy($order_by, $order_dir)->skip($skip)->take($take)->get();
            $recordsTotal = $query->count();

            $recordsFiltered = $query->count();
            $i=1;
            foreach ($data as $d) {
                $image=($d->image)? Storage::url($d->image):asset('assets/images/placeholder.webp');
                $d->name="<div class=''><img src='$image' alt='userImg' width='25%' height='25%' class='mr-3' />$d->name</div>";

                $d->index_column =$i;
                $i++;
                $d->action =view('crud.action',compact('d'))->render();

            }

            return [
                "draw" => request('draw'),
                "recordsTotal" => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                "data" => $data,
            ];
        
    }

    }
    public function add(){
        $form_route= route('crud.store');
        $form_title ="Add New Enter";
        return view('crud.form',compact('form_route','form_title'));
    }

    public function store(CrudFormRequest $request){
        try {
            DB::beginTransaction();
            $inputs = $request->only('name','email');
            if($request->hasFile('image')){
                $inputs['image']= $request->file('image')->store('images');
            }
            Student::create($inputs);
            DB::commit();
            return redirect()->route('crud')->with('success','New Entery added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
        
    }

    public function  edit(Student $student)  {
        $form_route= route('crud.update',compact('student'));
        $form_title ="Edit Entery";
        return view('crud.form',compact('form_route','form_title','student'));

    }

    public function update(CrudFormRequest  $request,Student $student) {
        try {
            DB::beginTransaction();
            $inputs = $request->only('name','email');
            if($request->hasFile('image')){
                $this->deleteImage($student);  // delete previous image if exists.
                $inputs['image']= $request->file('image')->store('images');
            }
            $student->update($inputs);
            DB::commit();
            return redirect()->route('crud')->with('success','Entery updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function delete(Student $student) {
        try {
            DB::beginTransaction();
            $this->deleteImage($student);
            $student->delete();
            DB::commit();
            return redirect()->route('crud')->with('success','Entery deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',$e->getMessage());
        }
        
    }

    public function  details(Student $student) {
        return view('crud.details',compact('student'));

    }

    public function deleteImage($model){
        if($model->image){
            Storage::delete($model->image);
        }
    }

}
