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
                    <form autocomplete="off" role="form" class="form-edit-add"
                        action="{{ $edit ? route('voyager.' . $dataType->slug . '.update', $dataTypeContent->getKey()) : route('voyager.' . $dataType->slug . '.store') }}"
                        method="POST" enctype="multipart/form-data">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        <!-- PUT Method if we are editing -->
                        @if ($edit)
                            {{ method_field('PUT') }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الاسم
                                </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    id="validationCustom01" required
                                    value="{{ $edit ? \App\Models\User::find($dataTypeContent->getKey())->name : '' }}"
                                    autocomplete="false" />
                            </div>


                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الفرع
                                </label>
                                <select type="select" name="branch_id" id="branch_id" class="form-control">
                                    <option>-إختر-</option>
                                    @foreach (\App\Models\Branch::where('company_id', Auth::user()->company_id)->get() as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $edit && $dataTypeContent->branch_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} </option>
                                    @endforeach
                                </select>


                            </div>
                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    كلمة السر
                                </label>
                                <input type="password" name="password" id="password" class="form-control"
                                    id="validationCustom01" {{ $add ? 'required' : '' }} autocomplete="new-password" />
                            </div>


                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الرقم الوظيفي
                                </label>
                                <input type="text" name="job_number" id="job_number" class="form-control"
                                    id="validationCustom01"
                                    value="{{ $edit ? \App\Models\User::find($dataTypeContent->getKey())->job_number : '' }}" />
                            </div>


                            @if ($edit && $dataTypeContent->role_id == 3)
                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        رقم الهاتف
                                    </label>
                                    <input type="text" name="phone_no" id="phone_no" class="form-control"
                                        id="validationCustom01"
                                        value="{{ $edit ? \App\Models\User::find($dataTypeContent->getKey())->phone_no : '' }}" />
                                </div>


                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        الايميل
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        id="validationCustom01"
                                        value="{{ $edit ? \App\Models\User::find($dataTypeContent->getKey())->email : '' }}"
                                        autocomplete="off" />
                                </div>








                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        عدد الساعات المطلوبة في الشهر
                                    </label>
                                    <input type="text" name="number_of_hours" id="number_of_hours" class="form-control"
                                        id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->number_of_hours : '' }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        الراتب الأساسي
                                    </label>
                                    <input type="text" name="salary" id="salary" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->salary : '' }}" />
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        رقم الحساب البنكي
                                    </label>
                                    <input type="text" name="bank_account_number" id="bank_account_number"
                                        class="form-control" id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->bank_account_number : '' }}" />
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        الجنسية
                                    </label>
                                    <input type="text" name="nationality" id="nationality" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->nationality : '' }}" />
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        الجنس
                                    </label>

                                    <select class="form-control" name="gender" id="gender">
                                        <option>-إختر-</option>
                                        <option value="male"
                                            {{ $edit && $dataTypeContent->gender == 'male' ? 'selected' : '' }}>ذكر
                                        </option>
                                        <option value="female"
                                            {{ $edit && $dataTypeContent->gender == 'female' ? 'selected' : '' }}>أنثى
                                        </option>
                                        <option value="other"
                                            {{ $edit && $dataTypeContent->gender == 'other' ? 'selected' : '' }}>غير ذلك
                                        </option>
                                    </select>
                                </div>


                                <div class="col-md-6">
                                    <label for="validationCustom01">
                                        رقم الهوية
                                    </label>
                                    <input type="text" name="identity_number" id="identity_number"
                                        class="form-control" id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->identity_number : '' }}" />
                                </div>
                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        تاريخ انتهاء الهوية
                                    </label>
                                    <input type="date" name="id_expiration_date" id="id_expiration_date"
                                        class="form-control" id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->id_expiration_date : '' }}" />
                                </div>






                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        رقم الرخصة
                                    </label>
                                    <input type="text" name="licence_number" id="licence_number" class="form-control"
                                        id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->licence_number : '' }}" />
                                </div>


                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        تاريخ انتهاء الرخصة
                                    </label>
                                    <input type="date" name="licence_expiration_date" id="licence_expiration_date"
                                        class="form-control" id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->licence_expiration_date : '' }}" />
                                </div>



                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        صورة الرخصة
                                    </label>
                                    <input type="file" name="licence_image" id="licence_image" class="form-control"
                                        id="validationCustom01"
                                        value="{{ $edit ? $dataTypeContent->licence_image : '' }}" />
                                </div>


                                <div class="col-md-4">
                                    <label for="validationCustom01">
                                        صورة الهوية
                                    </label>
                                    <input type="file" name="id_image" id="id_image" class="form-control"
                                        id="validationCustom01" value="{{ $edit ? $dataTypeContent->id_image : '' }}" />
                                </div>


                                <div class="col-md-12"
                                    style="padding: 20px; border: 1px solid #d1cccc;  margin-top: 20px; border-radius: 20px;">
                                    <div class="col-md-4">
                                        <label for="validationCustom01">
                                            فعال؟
                                        </label>
                                        <input type="checkbox" name="active" id="active" id="validationCustom01"
                                            {{ $dataTypeContent->active == 1 ? 'checked' : '' }} />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="validationCustom01">
                                            عدم تتبع التأخير؟
                                        </label>
                                        <input type="checkbox" name="no_attendance_tracking" id="no_attendance_tracking"
                                            id="validationCustom01"
                                            {{ $dataTypeContent->no_attendance_tracking == 1 ? 'checked' : '' }} />
                                    </div>

                                    <div class="col-md-4">
                                        <label for="validationCustom01">
                                            عدم تتبع البصمة؟
                                        </label>
                                        <input type="checkbox" name="no_fingerprint_tracking"
                                            id="no_fingerprint_tracking" id="validationCustom01"
                                            {{ $dataTypeContent->no_fingerprint_tracking == 1 ? 'checked' : '' }} />
                                    </div>

                               

                                </div>
                            @endif




                            @if ($edit)
                                <input type="hidden" name="role_id" value="{{ $dataTypeContent->role_id }}">
                            @endif


                        </div>

                        <div class="panel-footer">
                        @section('submit-buttons')
                            <button type="submit"
                                class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        @stop
                        @yield('submit-buttons')
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-danger" id="confirm_delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}
                </h4>
            </div>

            <div class="modal-body">
                <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                <button type="button" class="btn btn-danger"
                    id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
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
