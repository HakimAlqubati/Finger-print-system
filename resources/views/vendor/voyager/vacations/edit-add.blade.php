@php
$edit = !is_null($dataTypeContent->getKey());
$add = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' ' .
    $dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' ' . $dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add"
                        action="{{ $edit ? route('voyager.' . $dataType->slug . '.update', $dataTypeContent->getKey()) : route('voyager.' . $dataType->slug . '.store') }}"
                        method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if ($edit)
                            {{ method_field('PUT') }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">


                            @if ($edit)
                                <input type="hidden" name="emp_id" value="{{ $edit ? $dataTypeContent->emp_id : '' }}">
                            @endif


                            <div class="row"
                                style="border: 1px solid #4276a4;  border-radius: 20px; padding-bottom: 20px;">
                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        اسم الموظف
                                    </label>
                                    <input type="text" id="name" class="form-control" id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->user->name : '' }}" readonly />
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        الرقم الوظيفي
                                    </label>
                                    <input type="text" id="name" class="form-control" id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->user->job_number : '' }}" readonly />
                                </div>





                            </div>

                            <div class="row"
                                style="margin-top: 20px;border: 1px solid #4276a4;  border-radius: 20px; padding-bottom: 20px; ">


                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        تاريخ الإجازة
                                    </label>
                                    <input type="text" name="date" id="date" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->date : '' }}"
                                        readonly />
                                </div>


                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        نوع الإجازة
                                    </label>

                                    <input type="text" name="type" id="type" class="form-control"
                                        id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->vacationType->name : '' }}" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        عدد الأيام
                                    </label>

                                    <input type="text" name="no_of_days" id="no_of_days" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->no_of_days : '' }}"
                                        readonly />
                                </div>


                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        من الساعة
                                    </label>

                                    <input type="time" name="from_time" id="from_time" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->from_time : '' }}"
                                        readonly />
                                </div>


                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        إلى الساعة
                                    </label>

                                    <input type="time" name="to_time" id="to_time" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->to_time : '' }}"
                                        readonly />
                                </div>


                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        حالة الإجازة
                                    </label>

                                    <select type="time" name="to_time" id="to_time" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->to_time : '' }}">

                                        <option value="ordered" {{ $edit ? $dataTypeContent->ordered : 'selected' }}>قيد
                                            الطلب</option>
                                        <option value="approved" {{ $edit ? $dataTypeContent->approved : 'selected' }}>
                                            موافقة</option>
                                        <option value="declined" {{ $edit ? $dataTypeContent->declined : 'selected' }}>رفض
                                        </option>
                                        <option value="pending" {{ $edit ? $dataTypeContent->pending : 'selected' }}>معلقة
                                        </option>
                                    </select>

                                </div>

                            </div>

                            <div class="row" style="margin-top: 20px;border: 1px solid #4276a4;  border-radius: 20px;">

                                <div class="col-md-12">
                                    <label for="validationCustom01">
                                        سبب أخذ الإجازة
                                    </label>
                                    <p class="vacation_reason" id="vacation_reason">
                                        {{ $dataTypeContent->vacation_reason }}
                                    </p>
                                </div>
                            </div>


                            <div class="row"
                                style="margin-top: 20px;border: 1px solid #4276a4; padding-top:20px;  border-radius: 20px;">

                                <div class="col-md-12">
                                    <label for="validationCustom01">
                                        إرسال ملاحظات
                                        <br>
                                        (لإرسال ملاحظات للموظف اكتب هنا ثم اضغط على زر إرسال أسفل الفورم)
                                    </label>
                                    <textarea style="width: 100%" name="manager_notes" id="manager_notes" placeholder="..."></textarea>
                                </div>
                            </div>



                        @section('submit-buttons')
                            <button type="submit" class="btn btn-primary save">إرسال</button>
                        @stop
                        @yield('submit-buttons')
                    </div>


                </form>



            </div>
        </div>
    </div>
</div>

<!-- End Delete File Modal -->
@stop

@section('javascript')
<script>
    var params = {};
    var $file;

    function deleteHandler(tag, isMulti) {
        return function() {
            $file = $(this).siblings(tag);

            params = {
                slug: '{{ $dataType->slug }}',
                filename: $file.data('file-name'),
                id: $file.data('id'),
                field: $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
        };
    }

    $('document').ready(function() {
        $('.toggleswitch').bootstrapToggle();

        //Init datepicker for date fields if data-datepicker attribute defined
        //or if browser does not handle date inputs
        $('.form-group input[type=date]').each(function(idx, elt) {
            if (elt.hasAttribute('data-datepicker')) {
                elt.type = 'text';
                $(elt).datetimepicker($(elt).data('datepicker'));
            } else if (elt.type != 'date') {
                elt.type = 'text';
                $(elt).datetimepicker({
                    format: 'L',
                    extraFormats: ['YYYY-MM-DD']
                }).datetimepicker($(elt).data('datepicker'));
            }
        });

        @if ($isModelTranslatable)
            $('.side-body').multilingual({
                "editing": true
            });
        @endif

        $('.side-body input[data-slug-origin]').each(function(i, el) {
            $(el).slugify();
        });

        $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
        $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
        $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
        $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

        $('#confirm_delete').on('click', function() {
            $.post('{{ route('voyager.' . $dataType->slug . '.media.remove') }}', params, function(
                response) {
                if (response &&
                    response.data &&
                    response.data.status &&
                    response.data.status == 200) {

                    toastr.success(response.data.message);
                    $file.parent().fadeOut(300, function() {
                        $(this).remove();
                    })
                } else {
                    toastr.error("Error removing file.");
                }
            });

            $('#confirm_delete_modal').modal('hide');
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop
