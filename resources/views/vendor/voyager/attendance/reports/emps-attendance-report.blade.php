@extends('voyager::master')

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

            <div style="box-shadow: none;text-align: right; padding-top: 20px;padding-right: 30px;"class="col-md-3 col-sm-3">
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

            <div style="box-shadow: none; text-align: center;"class="col-md-6 col-sm-6">

                <img style="margin-top: 15px;" width="155px" height="155px"
                    src="{{ url('/') . '/storage/' . $companyData->avatar }}" alt="">
            </div>

            <div style="box-shadow: none; padding-top: 20px;text-align: left;padding-left: 30px;"class="col-md-3 col-sm-3">
                <p>{{ $companyData->english_name }}</p>
                <p>Branch: {{ $branch->english_name }}</p>
                <p>Phone: {{ $branch->phone_number }}</p>
                <p>Fax: {{ $branch->fax }}</p>
            </div>
        </div>
        <div style="text-align: center;">
          

            <h3 class="page-title">
                تقرير الحضور الموظفين
                من تاريخ ({{ $from_date }})
                إلى تاريخ
                ({{ $to_date }})
            </h3>

        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">


                    <form class="form-inline form-filter no-print" method="GET"
                        action="<?php echo url('/'); ?>/admin/employees-report">

                        {{-- <div class="form-group">
                            <label for="status">
                               الموظف
                                :</label>
                            <select class="form-control" name="emp_id" id="emp_id">
                                <option value="">-إختر-</option>
                                @foreach (\App\Models\User::where('role_id', 2)->get() as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach

                            </select>
                        </div> --}}



                        <div class="form-group">

                            <label for="status"> من تاريخ:</label>
                            <input type="date" name="from_date" type="date" class="form-control">

                            <label for="status"> إلى تاريخ:</label>
                            <input type="date" name="to_date" type="date" class="form-control">

                        </div>


                        <input class="form-control btn btn-primary" type="submit" value="بحث">
                    </form>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>م</th>
                                <th>رقم الموظف</th>
                                <th>رقم البصمة</th>
                                <th>اسم الموظف</th>
                                <th>التاريخ</th>
                                <th>اليوم</th>
                                <th>فترة الدوام</th>
                                <th>دخول</th>
                                <th>خروج</th>
                                <th>ساعات العمل</th>
                                <th>التأخر</th>
                                <th>الخروج المبكر</th>
                                <th>الغياب</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>

                        <tbody>


                            @foreach ($result as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['emp_id'] }}</td>
                                    <td>{{ $item['emp_id'] }}</td>

                                    <td>
                                        <strong>
                                            {{ $item['emp_name'] }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ $item['date'] }}
                                    </td>

                                    <td>
                                        {{ date('l', strtotime($item['date'])) }}
                                    </td>

                                    {{-- <td> --}}
                                    {{-- {{  $item['attendance'][$item['date']]  }} --}}
                                    {{-- </td> --}}
                                    {{-- @foreach ($item['attendance'] as $item_attendace)
                                        <td></td>
                                    @endforeach --}}

                                    <td>
                                        {{ count($item['attendance']) > 0 && count($item['attendance']) > 0 ? $item['attendance'][$item['date']][0]->period_name : '' }}
                                    </td>



                                    <td>
                                        {{ count($item['attendance']) > 0 && count($item['attendance']) > 0 ? $item['attendance'][$item['date']][0]->attendance_time : '' }}
                                    </td>

                                    <td>

                                        {{ count($item['attendance']) > 0 && $item['date'] != null && count($item['attendance'][$item['date']]) > 1 ? $item['attendance'][$item['date']][1]->attendance_time : '' }}
                                    </td>

                                    <td>

                                        @php
                                            
                                            /*  if (count($item['attendance']) > 0) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $time1 = new DateTime($item['attendance'][$item['date']][0]->attendance_time);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $time2 = new DateTime($item['attendance'][$item['date']][1]->attendance_time);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $interval = $time1->diff($time2);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        echo date('H:i:s', strtotime($interval->h . ':' . $interval->i));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }  */
                                        @endphp
                                    </td>

                                    <td>
                                        {{ count($item['attendance']) > 0 && $item['date'] != null && count($item['attendance'][$item['date']]) > 1 ? $item['attendance'][$item['date']][0]?->delay_duration : '' }}

                                    </td>

                                    <td>


                                        {{ count($item['attendance']) > 0 && $item['date'] != null && count($item['attendance'][$item['date']]) > 1 ? $item['attendance'][$item['date']][1]->early_leaving : '' }}

                                    </td>

                                    <td></td>
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
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>


            </div>
        </div>

        {{-- <div class="col-md-12"
            style=" padding: 9px;
    border-top: 1px solid #1865a0;
    bottom: 0;
    position: fixed;
    width: 100%;">

            <ul>
                <li>
                    <p> برمجة وتطوير شركة كلاود سناب للبرمجيات والذكاء الاصطناعي</p>
                </li>
            </ul>
        </div> --}}

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
