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
            <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                المنتجات</span>
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

    <!--div-->

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">

                <!-- Add Button -->
                <div>
                    <a class="btn ripple btn-primary" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
                </div>
                <!-- List Items -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم المنتج</th>
                                <th class="border-bottom-0">اسم القسم</th>
                                <th class="border-bottom-0">الوصف</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $x)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $x->product_name }}</td>


                                @foreach ($branches as $branch)

                                @if ($branch->id == $x->branch_id)
                                <td>{{$branch-> branch_name }}</td>
                                @endif

                                @endforeach


                                <td>{{ $x->description }}</td>

                                <td>
                                    <!-- زر التعديل -->
                                    <button class="btn btn-outline-success btn-sm" data-toggle="modal"
                                        data-target="#modaldemo12" data-id="{{ $x->id }}"
                                        data-product_name="{{ $x->product_name }}" data-branch_id="{{ $x->branch_id }}"
                                        data-description="{{ $x->description }}"
                                        data-target="#edit_Product">تعديل</button>
                                    </button>


                                    <!-- زر الحذف -->
                                    <button class="btn btn-outline-danger btn-sm " data-effect="effect-scale"
                                        data-id="{{ $x->id }}" data-product_name="{{ $x->product_name }}"
                                        data-toggle="modal" href="#modaldemo9" data-target="#modaldemo9">حذف</button>

                                    </button>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- Add Form -->

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة منتج</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">


                    <form action="{{ route('products.store') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="product_name">اسم المنتج</label>
                            <input type="text" id="product_name" class="form-control" name="product_name"
                                value="{{ old('product_name') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="branch_id">القسم</label>
                            <select name="branch_id" id="branch_id" class="form-control" required>
                                <option value="" selected disabled> --حدد القسم--</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">ملاحظات</label>
                            <textarea id="description" class="form-control" name="description" rows="3"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تأكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- edit Form -->

    <div class="modal" id="modaldemo12">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">تعديل منتج</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">


                    <form action="products/update" method="post" autocomplete="off">

                        <!-- ارسال الداتا -->
                        {{ method_field('PUT') }}
                        <!-- ارسال الداتا -->

                        <!-- ارسال id الي controller -->
                        <input type="hidden" name="id" id="id" value="{{ old('id') }}">
                        <!-- ارسال id الي controller -->

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="product_name">اسم المنتج</label>
                            <input type="text" id="product_name" class="form-control" name="product_name"
                                value="{{ old('product_name') }}">

                        </div>

                        <div class="form-group">
                            <label for="branch_id">القسم</label>
                            <select name="branch_id" id="branch_id" class="form-control" required>
                                <option value="" selected disabled> --حدد القسم--</option>
                                @foreach ($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">ملاحظات</label>
                            <textarea id="description" class="form-control" name="description" rows="3"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تأكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- delete Form -->

    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف القسم</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="products/destroy" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-c
ontent closed -->
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



<!-- عرض الداتا داخل الفورم -->

<script>
$('#modaldemo12').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var product_name = button.data('product_name');
    var branch_id = button.data('branch_id');
    var description = button.data('description');

    var modal = $(this);
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #product_name').val(product_name);
    modal.find('.modal-body #branch_id').val(branch_id);
    modal.find('.modal-body #description').val(description);
});
</script>


<!-- عرض الداتا داخل الفورم -->

<script>
$('#modaldemo9').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var product_name = button.data('product_name');

    var modal = $(this);
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #product_name').val(product_name);
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