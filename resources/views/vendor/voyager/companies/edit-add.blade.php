@php
$edit = !is_null($dataTypeContent->getKey());
$add = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        input,
        textarea,
        img {
            border-radius: 15px !important;
        }
    </style>
@stop

@section('page_title', __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' ' .
    $dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>

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
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4" style="text-align: center">
                                <label for="validationCustom01">
                                    الشعار
                                </label>
                                <input type="file" name="avatar" id="avatar" class="form-control"
                                    id="validationCustom01" />

                                @if ($edit)
                                    <img style="margin-top: 15px;" width="155px" height="155px"
                                        src="{{ url('/') . '/storage/' . $dataTypeContent->avatar }}" alt="">
                                @endif
                            </div>

                            <div class="col-md-4">
                            </div>

                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الاسم
                                </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    id="validationCustom01" required value="{{ $edit ? $dataTypeContent->name : '' }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الاسم الإنجليزي
                                </label>
                                <input type="text" name="english_name" id="english_name" class="form-control"
                                    id="validationCustom01" required
                                    value="{{ $edit ? $dataTypeContent->english_name : '' }}" />
                            </div>

                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الايميل
                                </label>
                                <input type="email" name="email" id="email" class="form-control"
                                    id="validationCustom01" value="{{ $edit ? $dataTypeContent->email : '' }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الهاتف
                                </label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    id="validationCustom01" value="{{ $edit ? $dataTypeContent->phone : '' }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    فاكس
                                </label>
                                <input type="text" name="fax" id="fax" class="form-control"
                                    id="validationCustom01" value="{{ $edit ? $dataTypeContent->fax : '' }}" />
                            </div>



                            <div class="col-md-6">
                                <label for="validationCustom01">
                                    الموقع الإلكتروني
                                </label>
                                <input type="text" name="website" id="website" class="form-control"
                                    id="validationCustom01" value="{{ $edit ? $dataTypeContent->website : '' }}" />
                            </div>




                            <div class="col-md-6" style="margin-top: 20px;">
                                <label for="validationCustom01">
                                    عن الشركة (عربي)
                                </label>
                                <textarea type="text" name="about_arabic" id="about_arabic" class="form-control" id="validationCustom01">{{ $edit ? $dataTypeContent->about_arabic : '' }}</textarea>
                            </div>

                            <div class="col-md-6" style="margin-top: 20px;">
                                <label for="validationCustom01">
                                    عن الشركة (إنجليزي)
                                </label>
                                <textarea type="text" name="about_english" id="about_english" class="form-control" id="validationCustom01">{{ $edit ? $dataTypeContent->about_english : '' }}</textarea>
                            </div>


                            <div class="col-md-6" style="margin-top: 20px;">
                                <label for="validationCustom01">
                                    عنوان الشركة (عربي)
                                </label>
                                <textarea type="text" name="address_arabic" id="address_arabic" class="form-control" id="validationCustom01">{{ $edit ? $dataTypeContent->address_arabic : '' }}</textarea>
                            </div>

                            <div class="col-md-6" style="margin-top: 20px;">
                                <label for="validationCustom01">
                                    عنوان الشركة (إنجليزي)
                                </label>
                                <textarea type="text" name="address_english" id="address_english" class="form-control" id="validationCustom01">{{ $edit ? $dataTypeContent->address_english : '' }}</textarea>
                            </div>


                            <div class="col-md-12" style="margin-top: 20px;">
                                <label for="validationCustom01">
                                    تعليمات للدوام
                                </label>
                                <textarea type="text" name="inforation"   class="form-control" id="myTextarea">{{ $edit ? $dataTypeContent->inforation : '' }}</textarea>
                            </div>



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

<script type="text/javascript">
    tinymce.init({
        selector: '#myTextarea',
        height: 300,
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
</script>

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
