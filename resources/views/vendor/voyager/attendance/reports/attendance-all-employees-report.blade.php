@extends('voyager::master')

@php
$companyData = \App\Models\Company::find(Auth::user()->company_id);
$branch = \App\Models\Branch::find(Auth::user()->company_id);
@endphp


@php
$companyData = \App\Models\Company::find(Auth::user()->company_id);
$branch = \App\Models\Branch::find(Auth::user()->company_id);
@endphp

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        th {
            background-color: #ededd5 !important;
            font-weight: bold;
        }

        @media print {



            .no-print,
            .no-print * {
                display: none !important;
            }

            .table-bordered {
                width: 100%;
                color: red;
                background: red;
            }

            [dir="rtl"] .app-container.expanded .side-body {
                margin-right: 0px !important;
            }
        }

        p {
            font-weight: bold;
        }
    </style>


@stop



@section('page_header')

    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">

        <div style="box-shadow: none;border: 1px solid #1865a0;
        border-radius: 20px; "class="row">

            <div
                style="box-shadow: none;text-align: right; padding-top: 20px;padding-right: 30px;"class="col-md-3 col-sm-3 col-xs-3">
                <p>{{ $companyData->name }}</p>
                <p>
                    فرع:
                    {{ $branch->name }}
                </p>
                <p>هاتف:
                    {{ $branch->phone_number }}</p>
                <p>فاكس:
                    {{ $branch->fax }}</p>
            </div>

            <div style="box-shadow: none; text-align: center;"class="col-md-6 col-sm-6 col-xs-6">

                <img style="margin-top: 15px;" width="155px" height="155px"
                    src="{{ url('/') . '/storage/' . $companyData->avatar }}" alt="">
            </div>

            <div
                style="box-shadow: none; padding-top: 20px;text-align: left;padding-left: 30px;"class="col-md-3 col-sm-3 col-xs-3">
                <p>{{ $companyData->english_name }}</p>
                <p>Branch: {{ $branch->english_name }}</p>
                <p>Phone: {{ $branch->phone_number }}</p>
                <p>Fax: {{ $branch->fax }}</p>
            </div>
        </div>
        <div style="text-align: center;">


            <h3 class="page-title">
                تقرير الحضور الموظفين
                بتاريخ({{ $date }})
            </h3>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">


                    <form class="form-inline form-filter no-print" method="GET"
                        action="<?php echo url('/'); ?>/admin/all-employees-report">



                        <div class="form-group">
                            <label for="status">
                                الفرع
                                :</label>
                            <select class="form-control" name="branch_id" id="branch_id">
                                <option value="">-الكل-</option>
                                @foreach (\App\Models\Branch::where('company_id', Auth::user()->company_id)->get() as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>




                        <div class="form-group">



                            <label for="status"> التاريخ:</label>
                            <input type="date" name="date" type="date" class="form-control">

                        </div>


                        <input class="form-control btn btn-primary" type="submit" value="بحث">
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="4">

                                </th>
                                <th colspan="6" style="text-align: center;">
                                    فترة صباحية
                                </th>
                                <th colspan="6" style="text-align: center;">
                                    فترة مسائية
                                </th>

                            </tr>

                            <tr>
                                <th>م</th>
                                <th>اسم الموظف</th>
                                <th>اليوم</th>
                                <th>التاريخ</th>

                                <th>حضور</th>
                                <th>انصراف</th>
                                <th>ساعات العمل</th>
                                <th>تأخير</th>
                                <th>خروج مبكر</th>
                                <th>الحالة</th>

                                <th>حضور</th>
                                <th>انصراف</th>
                                <th>ساعات العمل</th>
                                <th>تأخير</th>
                                <th>خروج مبكر</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($result as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td> <strong>{{ $item['emp_name'] }}</strong> </td>
                                    <td>


                                        @php
                                            $day = null;
                                            if ($item['day'] == 'Monday') {
                                                $day = 'الإثنين';
                                            } elseif ($item['day'] == 'Tuesday') {
                                                $day = 'الثلاثاء';
                                            } elseif ($item['day'] == 'Wednesday') {
                                                $day = 'الاربعاء';
                                            } elseif ($item['day'] == 'Thursday') {
                                                $day = 'الخميس';
                                            } elseif ($item['day'] == 'Friday') {
                                                $day = 'الجمعة';
                                            } elseif ($item['day'] == 'Saturday') {
                                                $day = 'السبت';
                                            } elseif ($item['day'] == 'Sunday') {
                                                $day = 'الأحد';
                                            }
                                            echo $day;
                                        @endphp
                                    </td>
                                    <td>
                                        {{ $item['date'] }}
                                    </td>
                                    <td>
                                        {{ count($item['attendance']) > 0 ? $item['attendance'][$item['date']][0]->attendance_time : '' }}
                                    </td>

                                    <td>
                                        {{ count($item['attendance']) > 1 ? $item['attendance'][$item['date']][1]->attendance_time : '' }}
                                    </td>

                                    <td>
                                        {{ $item['second_period_hours_count'] }}
                                    </td>



                                    <td>
                                        {{ count($item['attendance']) > 1 ? $item['attendance'][$item['date']][1]->early_leaving : '' }}
                                    </td>



                                    <td>
                                        {{ count($item['attendance']) > 1 ? $item['attendance'][$item['date']][1]->early_leaving : '' }}
                                    </td>

                                    <td>
                                        @php
                                            $status = null;
                                            if (count($item['attendance']) > 0) {
                                                if ($item['attendance'][$item['date']][0]->status == 'present') {
                                                    $status = 'حاضر';
                                                } elseif ($item['attendance'][$item['date']][0]->status == 'absent') {
                                                    $status = 'غائب';
                                                } elseif ($item['attendance'][$item['date']][0]->status == 'on_vocation') {
                                                    $status = 'في إجازة';
                                                } elseif ($item['attendance'][$item['date']][0]->status == 'late') {
                                                    $status = 'متأخر';
                                                } elseif ($item['attendance'][$item['date']][0]->status == 'early') {
                                                    $status = 'مبكر';
                                                }
                                                echo $status;
                                            } else {
                                                echo 'غائب';
                                            }
                                        @endphp

                                    </td>
                                    <td>
                                        {{ count($item['attendance']) > 2 ? $item['attendance'][$item['date']][2]->attendance_time : '' }}
                                    </td>
                                    <td>
                                        {{ count($item['attendance']) > 3 ? $item['attendance'][$item['date']][3]->attendance_time : '' }}
                                    </td>
                                    <td>
                                        {{ $item['second_period_hours_count'] }}
                                    </td>
                                    <td>
                                        {{ count($item['attendance']) > 2 ? $item['attendance'][$item['date']][2]->delay_duration : '' }}
                                    </td>
                                    <td>

                                        {{ count($item['attendance']) > 3 ? $item['attendance'][$item['date']][3]->early_leaving : '' }}
                                    </td>
                                    <td>
                                        @php
                                            $status = null;
                                            if (count($item['attendance']) > 3) {
                                                if ($item['attendance'][$item['date']][2]->status == 'present') {
                                                    $status = 'حاضر';
                                                } elseif ($item['attendance'][$item['date']][2]->status == 'absent') {
                                                    $status = 'غائب';
                                                } elseif ($item['attendance'][$item['date']][2]->status == 'on_vocation') {
                                                    $status = 'في إجازة';
                                                } elseif ($item['attendance'][$item['date']][2]->status == 'late') {
                                                    $status = 'متأخر';
                                                } elseif ($item['attendance'][$item['date']][2]->status == 'early') {
                                                    $status = 'مبكر';
                                                }
                                                echo $status;
                                            } else {
                                                echo 'غائب';
                                            }
                                        @endphp
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>


            </div>
        </div>
    </div>

@stop

@section('javascript')
    <script>
        var params = {};
        var $file;



        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();


        });
    </script>
@stop
