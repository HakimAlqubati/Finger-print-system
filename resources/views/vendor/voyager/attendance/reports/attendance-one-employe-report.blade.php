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
                 تقرير الحضور للموظف ({{ $empName }})
                 من تاريخ ({{ $fromDate }})
                 إلى تاريخ
                 ({{ $toDate }})
             </h3>
         </div>

         <div class="row">
             <div class="col-md-12">

                 <div class="panel panel-bordered">


                     <form class="form-inline form-filter no-print" method="GET"
                         action="<?php echo url('/'); ?>/admin/one-employees-report">

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
                         </div>

                         <div class="form-group">
                             <label for="status"> إلى تاريخ:</label>
                             <input type="date" name="to_date" type="date" class="form-control">
                         </div>

                         <input class="form-control btn btn-primary" type="submit" value="بحث">
                     </form>

                     <table class="table table-bordered">
                         <thead>
                             <tr>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">م</th>

                                 <th style="background-color: #ededd5 !important; font-weight: bold;">اليوم</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">التاريخ</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">حضور</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">انصراف</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">ساعات العمل</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">تأخير</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">خروج مبكر</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">الحالة</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">أجرة الساعة</th>
                                 <th style="background-color: #ededd5 !important; font-weight: bold;">أجرة الفترة</th>
                             </tr>
                         </thead>

                         <tbody>
                             @php
                                 $i = 0;
                             @endphp
                             @foreach ($attendanceResult as $key => $item)
                                 <tr>
                                     <td>{{ $loop->iteration }}</td>

                                     <td> {{ date('l', strtotime($item[0]->attendance_date)) }} </td>
                                     <td> {{ $item[0]->attendance_date }} </td>

                                     <td> {{ $item[0]->attendance_time }} </td>

                                     <td> {{ count($item) > 1 ? $item[1]->attendance_time : '' }} </td>
                                     <td>
                                         @php
                                             $hours = null;
                                             if (count($item) > 1) {
                                                 $time1 = new DateTime($item[0]->attendance_time);
                                                 $time2 = new DateTime($item[1]->attendance_time);
                                                 $interval = $time1->diff($time2);
                                                 $hours = date('H:i:s', strtotime($interval->h . ':' . $interval->i));
                                             }
                                             echo $hours;
                                         @endphp

                                     </td>
                                     <td> {{ $item[0]->delay_time }} </td>
                                     <td> {{ count($item) > 1 ? $item[1]->early_leaving : '' }} </td>
                                     <td>

                                         @php
                                             $status = null;
                                             if (count($item) > 0) {
                                                 if ($item[0]->status == 'present') {
                                                     $status = 'حاضر';
                                                 } elseif ($item[0]->status == 'absent') {
                                                     $status = 'غائب';
                                                 } elseif ($item[0]->status == 'on_vocation') {
                                                     $status = 'في إجازة';
                                                 } elseif ($item[0]->status == 'late') {
                                                     $status = 'متأخر';
                                                 } elseif ($item[0]->status == 'early') {
                                                     $status = 'مبكر';
                                                 }
                                                 echo $status;
                                             } else {
                                                 echo 'غائب';
                                             }
                                         @endphp
                                     </td>
                                     <td>

                                         @php
                                             $hoursNumbers = null;
                                             $hourlyFare = null;
                                             if (count($item) > 0) {
                                                 $timestamp = strtotime($hours);
                                                 $hoursNumbers = (float) date('h.i', $timestamp);
                                                 $hourlyFare = $salary / ($hoursNumbers * $item[0]->number_days_in_month);
                                             }
                                             echo round($hourlyFare, 2);
                                         @endphp

                                     </td>
                                     <td>

                                         @php
                                             if (count($item) > 0) {
                                                 echo round($hourlyFare * $hoursNumbers, 2);
                                             }
                                         @endphp
                                     </td>
                                 </tr>

                                 @php
                                     $i += 1;
                                 @endphp
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
