@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing') . ' ' . $dataType->getTranslatedAttribute('display_name_plural'))

@php
$dataTypeContent = \App\Models\Company::find(Auth::user()->company_id);
@endphp

@section('page_header')
    <div class="container-fluid">



    </div>
@stop

@section('content')




    <div class="panel-body">

        <div class="col-md-12">
            <div class="col-md-4">
                <h1 class="page-title">
                    بيانات الشركة
                </h1>
            </div>
            <div class="col-md-4" style="text-align: center">




                <img style="margin-top: 15px;" width="155px" height="155px"
                    src="{{ url('/') . '/storage/' . $dataTypeContent->avatar }}" alt="">

            </div>

            <div class="col-md-4" style="height: 100px; padding-top: 5%; text-align: center;">
                <a href="{{ url('/') . '/admin/companies/' . $dataTypeContent->id . '/edit' }}" class="btn btn-primary">
                    <i class="voyager-edit"></i> تعديل البيانات</span>
                </a>
            </div>
        </div>

        <div class="col-md-6">
            <label for="validationCustom01">
                الاسم
            </label>
            <input readonly type="text" name="name" id="name" class="form-control" id="validationCustom01"
                required value="{{ $dataTypeContent->name }}" />
        </div>

        <div class="col-md-6">
            <label for="validationCustom01">
                الاسم الإنجليزي
            </label>
            <input readonly type="text" name="english_name" id="english_name" class="form-control"
                id="validationCustom01" required value="{{ $dataTypeContent->english_name }}" />
        </div>

        <div class="col-md-6">
            <label for="validationCustom01">
                الايميل
            </label>
            <input readonly type="email" name="email" id="email" class="form-control" id="validationCustom01"
                value="{{ $dataTypeContent->email }}" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom01">
                الهاتف
            </label>
            <input readonly type="text" name="phone" id="phone" class="form-control" id="validationCustom01"
                value="{{ $dataTypeContent->phone }}" />
        </div>
        <div class="col-md-6">
            <label for="validationCustom01">
                فاكس
            </label>
            <input readonly type="text" name="fax" id="fax" class="form-control" id="validationCustom01"
                value="{{ $dataTypeContent->fax }}" />
        </div>



        <div class="col-md-6">
            <label for="validationCustom01">
                الموقع الإلكتروني
            </label>
            <input readonly type="text" name="website" id="website" class="form-control" id="validationCustom01"
                value="{{ $dataTypeContent->website }}" />
        </div>




        <div class="col-md-6" style="margin-top: 20px;">
            <label for="validationCustom01">
                عن الشركة (عربي)
            </label>
            <textarea readonly type="text" name="about_arabic" id="about_arabic" class="form-control" id="validationCustom01">{{ $dataTypeContent->about_arabic }}</textarea>
        </div>

        <div class="col-md-6" style="margin-top: 20px;">
            <label for="validationCustom01">
                عن الشركة (إنجليزي)
            </label>
            <textarea readonly type="text" name="about_english" id="about_english" class="form-control" id="validationCustom01">{{ $dataTypeContent->about_english }}</textarea>
        </div>


        <div class="col-md-6" style="margin-top: 20px;">
            <label for="validationCustom01">
                عنوان الشركة (عربي)
            </label>
            <textarea readonly type="text" name="address_arabic" id="address_arabic" class="form-control"
                id="validationCustom01">{{ $dataTypeContent->address_arabic }}</textarea>
        </div>

        <div class="col-md-6" style="margin-top: 20px;">
            <label for="validationCustom01">
                عنوان الشركة (إنجليزي)
            </label>
            <textarea readonly type="text" name="address_english" id="address_english" class="form-control"
                id="validationCustom01">{{ $dataTypeContent->address_english }}</textarea>
        </div>




    </div>


@stop

@section('css')
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
    @endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if (!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function() {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge(
                        [
                            'order' => $orderColumn,
                            'language' => __('voyager::datatable'),
                            'columnDefs' => [['targets' => 'dt-not-orderable', 'searchable' => false, 'orderable' => false]],
                        ],
                        config('voyager.dashboard.data_tables', []),
                    ),
                    true,
                ) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function() {
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function(e) {
            $('#delete_form')[0].action = '{{ route('voyager.' . $dataType->slug . '.destroy', '__id') }}'.replace(
                '__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if ($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before(
                            '<a id="redir" href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 1]), true) }}"></a>'
                        );
                    } else {
                        $('#dataTable').before(
                            '<a id="redir" href="{{ route('voyager.' . $dataType->slug . '.index', array_merge($params, ['showSoftDeleted' => 0]), true) }}"></a>'
                        );
                    }

                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function() {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });
    </script>
@stop
