<?php

namespace App\Http\Controllers;

use App\Models\branches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BranchesController extends Controller
{

    public function index()       // جلب كل البيانات
    {
        $branches = branches::all();

        return view("branches.branches", compact("branches"));
    }

    public function create()
    {
        //
    }


    public function store(Request $request)    //  اضافه الي قاعده البيانات
    {

        $validated = $request->validate([      //  الشروط
            'branch_name' => 'required|unique:branches|max:255',
            'description' => 'required',
        ], [

            'branch_name.required' => 'يجب ادخال اسم القسم',
            'branch_name.unique' => 'اسم القسم موجود مسبقا',
            'description.required' => 'يجب ادخال وصف القسم',
        ]);



        branches::create([
            'branch_name' => $request->branch_name,
            'description' => $request->description,
            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح ');  //  الرسالة
        return redirect('/branches');
    }


    public function show(branches $sections)
    {
        //
    }


    public function edit(Request $sections)
    {
        //
    }


    public function update(Request $request)
    {

        $id = $request->id;

        // تحقق من وجود السجل
        $branch = branches::find($id);
        if (!$branch) {
            return response()->json(['error' => 'السجل غير موجود'], 404);
        }

        // التحقق من صحة المدخلات
        $validated = $request->validate([
            'branch_name' => 'required|unique:branches,branch_name,' . $id . '|max:255',  // استثناء السجل الحالي
            'description' => 'required',
        ], [
            'branch_name.required' => 'يجب ادخال اسم القسم',
            'branch_name.unique' => 'اسم القسم موجود مسبقا',
            'description.required' => 'يجب ادخال وصف القسم',
        ]);


        // تحديث السجل
        $branch->update([
            'branch_name' => $request->branch_name,
            'description' => $request->description,
            'Created_by' => Auth::user()->name,
        ]);



        session()->flash('edit', 'تم التحديث بنجاح');  //  الرسالة
        return redirect('/branches');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $branch = branches::find($id);

        if (!$branch) {
            return redirect('/branches')->with('error', 'القسم غير موجود');
        }

        $branch->delete();

        session()->flash('delete', 'تم الحذف بنجاح');
        return redirect('/branches');
    }
}
