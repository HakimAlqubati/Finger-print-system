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
                                @foreach (\App\Models\Period::where('company_id', Auth::user()->company_id)->orderBy('order', 'ASC')->get() as $item)
                                    <th colspan="6" style="text-align: center;">
                                        {{ $item->name }}
                                    </th>
                                @endforeach


                            </tr>

                            <tr>
                                <th>م</th>
                                <th>اسم الموظف</th>
                                <th>اليوم</th>
                                <th>التاريخ</th>

                                @foreach (\App\Models\Period::where('company_id', Auth::user()->company_id)->orderBy('order', 'ASC')->get() as $item)
                                    <th>حضور</th>
                                    <th>انصراف</th>
                                    <th>ساعات العمل</th>
                                    <th>تأخير</th>
                                    <th>خروج مبكر</th>
                                    <th>الحالة</th>
                                @endforeach

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

                                    @foreach (\App\Models\Period::where('company_id', Auth::user()->company_id)->orderBy('order', 'ASC')->get() as $k => $periodItem)
                                        <td>
                                            {{-- {{ $item['attendance'][$item['date']][$k]->attendance_time }} --}}




                                            {{ $item['attendance'][$periodItem->id][0]['attending_time'] }}
                                        </td>

                                        <td>
                                            {{ $item['attendance'][$periodItem->id][0]['leaving_time'] }}
                                        </td>

                                        <td>

                                            @php
                                                
                                                $time1 = new DateTime($item['attendance'][$periodItem->id][0]['attending_time']);
                                                $time2 = new DateTime($item['attendance'][$periodItem->id][0]['leaving_time']);
                                                $interval = $time1->diff($time2);
                                                $firstPeriodHoursCOunt = date('H:i:s', strtotime($interval->h . ':' . $interval->i));
                                                echo $firstPeriodHoursCOunt;
                                            @endphp
                                        </td>

                                        <td>

                                        </td>

                                        <td>
                                            {{ $item['attendance'][$periodItem->id][0]['early_leaving'] }}

                                        </td>

                                        <td>

                                            @php
                                                $status = null;
                                                if (count($item['attendance']) > 0) {
                                                    if ($item['attendance'][$periodItem->id][0]['status'] == 'present') {
                                                        $status = 'حاضر';
                                                    } elseif ($item['attendance'][$periodItem->id][0]['status'] == 'absent') {
                                                        $status = 'غائب';
                                                    } elseif ($item['attendance'][$periodItem->id][0]['status'] == 'on_vocation') {
                                                        $status = 'في إجازة';
                                                    } elseif ($item['attendance'][$periodItem->id][0]['status'] == 'late') {
                                                        $status = 'متأخر';
                                                    } elseif ($item['attendance'][$periodItem->id][0]['status'] == 'early') {
                                                        $status = 'مبكر';
                                                    }
                                                    echo $status;
                                                } else {
                                                    echo 'غائب';
                                                }
                                                // echo $status;
                                            @endphp

                                        </td>
                                        {{-- @break --}}
                                    @endforeach



                                </tr>
                            @break
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
