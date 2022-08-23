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
        border-radius: 20px;"class="row">

            <div style="box-shadow: none;text-align: right; padding-top: 20px;padding-right: 30px;"class="col-md-3 col-sm-3 col-xs-3">
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

            <div style="box-shadow: none; padding-top: 20px;text-align: left;padding-left: 30px;"class="col-md-3 col-sm-3 col-xs-3">
                <p>{{ $companyData->english_name }}</p>
                <p>Branch: {{ $branch->english_name }}</p>
                <p>Phone: {{ $branch->phone_number }}</p>
                <p>Fax: {{ $branch->fax }}</p>
            </div>
        </div>


        <div style="text-align: center;">
            <h3 class="page-title">
                تقرير الحضور

            </h3>
        </div>


        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">


                    <form class="form-inline form-filter no-print" method="GET" action="<?php echo url('/'); ?>/admin/report">

                        <div class="form-group">
                            <label for="status">
                                الموظف
                                :</label>
                            <select class="form-control" name="emp_id" id="emp_id">
                                <option value="">-إختر-</option>
                                @foreach (\App\Models\User::where('role_id', 3)->get() as $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach

                            </select>
                        </div>



                        <div class="form-group">

                            <label for="status"> من تاريخ:</label>
                            <input type="date" name="from_date" type="date" class="form-control">

                            <label for="status"> إلى تاريخ:</label>
                            <input type="date" name="to_date" type="date" class="form-control">

                        </div>


                        <input class="form-control btn btn-primary" type="submit" value="بحث">
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    الاسم
                                </th>
                                <th colspan="3">
                                    <strong>

                                        {{ $empName }}
                                    </strong>
                                </th>
                                <th>
                                    الوظيفة
                                </th>
                                <th colspan="6">
                                    <strong>

                                    </strong>
                                </th>
                            </tr>

                            @foreach ($periods as $item)
                                <tr>
                                    <th>
                                        {{ $item->name }}
                                    </th>
                                    <th>
                                        {{ $item->from_time }}
                                    </th>
                                    <th>
                                        {{ $item->to_time }}
                                    </th>

                                    <th colspan="2">
                                        الراتب الاساسي
                                    </th>
                                    <th>

                                    </th>
                                    <th>
                                        عدد الساعات
                                    </th>
                                    <th>
                                        08:00
                                    </th>
                                    <th colspan="3">
                                        مدة التأخير المسموح به
                                    </th>
                                    <th>
                                        0:15
                                    </th>
                                </tr>
                            @endforeach

                            <tr>
                                <th scope="col">م</th>
                                <th scope="col">اليوم</th>
                                <th scope="col">الحضور</th>
                                <th scope="col">الانصراف</th>
                                <th scope="col">عدد الساعات</th>
                                <th scope="col">الفترة</th>
                                <th scope="col">مدة التأخير</th>
                                <th scope="col">جزاءات التأخير</th>
                                <th scope="col">مدة الوقت الإضافي</th>
                                <th scope="col">الاضافي</th>
                                <th scope="col">جزاءات او خصومات</th>
                                <th scope="col">حوافز ومكافأة</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($attendanceResult as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                  
                                    <td>{{ $key }} </td>
                                    <td>{{ $item[0]->attendance_time }}</td>
                                    <td>{{ count($item) > 1 ? $item[1]->attendance_time : '' }}</td>
                                    <td>


                                        @php
                                            if (count($item) > 1) {
                                                $time1 = new DateTime($item[0]->attendance_time);
                                                $time2 = new DateTime($item[1]->attendance_time);
                                                $interval = $time1->diff($time2);
                                                echo $interval->h . ':' . $interval->i;
                                            }
                                        @endphp


                                    </td>
                                    <td>
                                        {{ $item[0]->period_name }}
                                    </td>
                                    <td>
                                        @if (count($item) > 0)
                                        @endif
                                    </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td>1</td>
                                <td>1/1/2022</td>
                                <td>08:00</td>
                                <td>04:00</td>
                                <td>8</td>
                                <td>00</td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr> --}}

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
