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

         <div style="box-shadow: none;border: 1px solid #38393a;
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
                 تقرير بعدد ساعات حضور الموظفين لشهر
                 ({{ $monthName }})


             </h3>
         </div>
         <div class="row">
             <div class="col-md-12" style="padding: 0px !important;">

                 <div class="panel panel-bordered">


                     <form class="form-inline form-filter no-print" method="GET"
                         action="<?php echo url('/'); ?>/admin/employees-report-hours">

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

                             <label for="status"> الشهر:</label>
                             <input type="date" name="month" type="date" class="form-control">


                         </div>


                         <input class="form-control btn btn-primary" type="submit" value="بحث">
                     </form>
                     <table class="table table-striped table-bordered">
                         <thead>
                             <tr>

                                 <th>رقم الموظف</th>
                                 <th>رقم البصمة</th>
                                 <th>اسم الموظف</th>
                                 <th>
                                     ساعات مطلوبة
                                 </th>
                                 <th>
                                     ساعات العمل
                                 </th>
                                 <th>
                                     ساعات التأخر
                                 </th>
                                 <th>
                                     الخروج المبكر
                                 </th>
                                 <th>
                                     ساعات الغياب
                                 </th>
                                 <th>
                                     ساعات الاستئذان
                                 </th>
                                 <th>
                                     ساعات الإضافي
                                 </th>
                                 <th>
                                     ساعات الإجازة
                                 </th>

                             </tr>
                         </thead>

                         <tbody>


                             @foreach ($result as $item)
                                 <tr>
                                     <td>{{ $item['emp_id'] }}</td>
                                     <td> {{ $item['emp_id'] }} </td>
                                     <td>
                                         <strong>

                                             {{ $item['emp_name'] }}
                                         </strong>
                                     </td>
                                     <td> {{ $item['requested_work_hours'] }} </td>
                                     <td> {{ $item['hours_work'] }} </td>
                                     <td> {{ $item['delay_hours'] }} </td>
                                     <td> {{ $item['early_leaving'] }} </td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
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
