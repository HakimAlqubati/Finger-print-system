@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', ' إضافة الفترات')

@section('page_header')
    <h1 class="page-title">
        إضافة الفترات ليوم
        {{ $dayName }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->


                    <form role="form" class="form-edit-add" action="{{ url('/admin/save-work-day-periods/' . $id) }}"
                        method="POST" enctype="multipart/form-data">
                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="form-group" style="padding-right: 20px; padding-left: 20px;">

                            @foreach (\App\Models\Period::where('company_id', Auth::user()->company_id)->get() as $item)
                                <div class="col-md-12">
                                    <label for="validationCustom01">
                                        {{ $item->name }}
                                    </label>
                                    <input type="checkbox" value="{{ $item->id }}" name="periods[]" class="periods"
                                        id="periods">
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-12" style="padding-top: 20px; text-align: center;">
                            <input type="submit" value="Save" class="btn btn-info" />
                        </div>

                    </form>



                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    <script>
        var params = {};
        var $file;
    </script>
@stop
