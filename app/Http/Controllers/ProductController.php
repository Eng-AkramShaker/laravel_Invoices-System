<?php

namespace App\Http\Controllers;

use App\Models\branches;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
        $products = product::all();
        $branches = branches::all();

        return view("products.products", compact("products", "branches"));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

        $validated = $request->validate([      //  الشروط
            'product_name' => 'required|unique:products|max:255',
            'branch_id' => 'required',
            'description' => 'required',
        ], [
            'product_name.required' => 'يجب ادخال اسم القسم',
            'branch_id.required' => 'يجب ادخال القسم',
            'description.required' => 'يجب ادخال وصف القسم',
        ]);

        product::create([
            'product_name' => $request->product_name,
            'branch_id' => $request->branch_id,
            'description' => $request->description,

            'Created_by' => (Auth::user()->name),
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح ');          //  الرسالة
        return redirect('/products');
    }



    public function show(product $product)
    {
        //
    }


    public function edit(product $product)
    {
        //
    }



    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'branch_id' => 'required',
            'description' => 'required',
        ], [
            'product_name.required' => 'يجب إدخال اسم المنتج',
            'branch_id.required' => 'يجب تحديد القسم',
            'description.required' => 'يجب إدخال ملاحظات',
        ]);

        $product = Product::find($request->id);

        if (!$product) {
            return redirect()->back()->with('error', 'المنتج غير موجود');
        }

        $product->update([
            'product_name' => $request->product_name,
            'branch_id' => $request->branch_id,
            'description' => $request->description,
        ]);

        session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }



    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->delete();

        session()->flash('delete', 'تم حذف المنتج بنجاح.');
        return redirect('products');
    }


    public function getProducts($branch_id)
    {
        $products = Product::where('branch_id', $branch_id)->get();

        return response()->json([
            'products' => $products
        ]);
    }
}