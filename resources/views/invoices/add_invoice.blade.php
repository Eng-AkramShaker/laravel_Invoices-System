use App\Models\branches;

@extends('layouts.master')

@section('title')
المنتجات
@endsection

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection


@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                قائمة الفواتير</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->


<!-- عرض التنبيهات -->

@if (session()->has('Add'))
<div class="alert alert-success text-center" role="alert" id="auto-dismiss-alert"
    style="display: inline-block; padding: 5px; margin: 10px auto;">
    <strong>{{ session()->get('Add') }}</strong>
</div>
@endif

@if (session()->has('delete'))
<div class="alert alert-success text-center" role="alert" id="auto-dismiss-alert"
    style="display: inline-block; padding: 5px; margin: 10px auto;">
    <strong>{{ session()->get('delete') }}</strong>
</div>
@endif

@if (session()->has('edit'))
<div class="alert alert-success text-center" role="alert" id="auto-dismiss-alert"
    style="display: inline-block; padding: 5px; margin: 10px auto;">
    <strong>{{ session()->get('edit') }}</strong>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger text-center" role="alert" id="auto-dismiss-alert"
    style="display: inline-block; padding: 5px; margin: 10px auto;">
    <strong>{{ session()->get('error') }}</strong>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>



@endif


<!--  التنبيهات -->


<!-- row -->

<div class="row">



    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    {{ csrf_field() }}

                    {{-- 1 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">رقم الفاتورة</label>
                            <input type="text" class="form-control" id="inputName" name="invoice_number"
                                title="يرجي ادخال رقم الفاتورة" required>
                        </div>

                        <div class="col">
                            <label>تاريخ الفاتورة</label>
                            <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                type="text" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col">
                            <label>تاريخ الاستحقاق</label>
                            <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                type="text" required>
                        </div>

                    </div>

                    {{-- 2 --}}

                    <div class="row">
                        <div class="col">
                            <label for="Branches" class="control-label">القسم</label>
                            <select id="Branches" name="Branches" class="form-control SlectBox">
                                <!-- Placeholder -->
                                <option value="" selected disabled>حدد القسم</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="product" class="control-label">المنتج</label>
                            <select id="product" name="product" class="form-control">
                                <option value="" selected disabled>حدد المنتج</option>

                                @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                @endforeach



                            </select>
                        </div>

                        <div class="col">
                            <label for="Amount_collection" class="control-label">مبلغ التحصيل</label>
                            <input type="text" class="form-control" id="Amount_collection" name="Amount_collection"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                    </div>



                    {{-- 3 --}}

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">مبلغ العمولة</label>
                            <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                name="Amount_Commission" title="يرجي ادخال مبلغ العمولة "
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الخصم</label>
                            <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                title="يرجي ادخال مبلغ الخصم "
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value=0 required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                            <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()">
                                <!--placeholder-->
                                <option value="" selected disabled>حدد نسبة الضريبة</option>
                                <option value=" 5%">5%</option>
                                <option value="10%">10%</option>
                            </select>
                        </div>

                    </div>

                    {{-- 4 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                            <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                            <input type="text" class="form-control" id="Total" name="Total" readonly>
                        </div>
                    </div>

                    {{-- 5 --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">ملاحظات</label>
                            <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                        </div>
                    </div><br>

                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                    <h5 class="card-title">المرفقات</h5>

                    <div class="col-sm-12 col-md-12">
                        <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                            data-height="70" />
                    </div><br>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">حفظ البيانات</button>
                    </div>


                </form>
            </div>
        </div>
    </div>

</div>




@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>

<!--Internal Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<!-- Internal Prism js-->
<script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
<!--Internal Datepicker js -->
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<!-- Internal Select2 js-->
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>


<!-- عرض الداتا داخل الفورم -->

<script>
    $('#modaldemo8').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var branch_name = button.data('branch_id')
        var description = button.data('description')

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #branch_id').val(branch_id);
        modal.find('.modal-body #description').val(description);

    })
</script>



<!-- فلترة-->

<script>
    document.getElementById('Branches').addEventListener('change', function() {
        let branchId = this.value;
        let productSelect = document.getElementById('product');

        // تأكد من تفريغ القائمة
        productSelect.innerHTML = '<option value="" selected disabled>حدد المنتج</option>';

        // طلب AJAX للحصول على المنتجات بناءً على القسم المختار
        if (branchId) {
            fetch(`/get-products/${branchId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.products.length > 0) {
                        data.products.forEach(product => {
                            let option = document.createElement('option');
                            option.value = product.id;
                            option.textContent = product.product_name;
                            productSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching products:', error));
        }
    });
</script>







<script>
    const alertText = document.querySelector('#auto-dismiss-alert').innerText;
    setTimeout(() => {
        const alert = document.getElementById('auto-dismiss-alert');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        }
    }, 8000);
</script>








@endsection