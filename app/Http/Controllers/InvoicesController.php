<?php

namespace App\Http\Controllers;

use App\Models\branches;
use App\Models\invoices;
use App\Models\product;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("invoices.invoices");
    }


    public function create()
    {

        $branches = branches::all();
        $products = product::all();

        return view("invoices.add_invoice", compact("branches", "products"));
    }


    public function store(Request $request)
    {
        //
    }


    public function show(invoices $invoices)
    {
        //
    }


    public function edit(invoices $invoices)
    {
        //
    }


    public function update(Request $request, invoices $invoices)
    {
        //
    }


    public function destroy(invoices $invoices)
    {
        //
    }
}