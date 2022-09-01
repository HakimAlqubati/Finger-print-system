 @php
     $companyData = \App\Models\Company::find(Auth::user()->company_id);
     $branch = \App\Models\Company::find(Auth::user()->company_id);
 @endphp




 <!-- CSS only -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
 <div size="A4">
     <header>
         <div style="box-shadow: none"class="row">
             <div style="box-shadow: none; padding-top: 20px;"class="col-md-3 col-sm-3">
                 <p>{{ $companyData->english_name }}</p>
                 <p>Branch: {{ $branch->english_name }}</p>
                 <p>Phone: {{ $branch->phone_number }}</p>
                 <p>Fax: {{ $branch->fax }}</p>
             </div>
             <div style="box-shadow: none; text-align: center;"class="col-md-6 col-sm-6">

                 <img style="margin-top: 15px;" width="155px" height="155px"
                     src="{{ url('/') . '/storage/' . $companyData->avatar }}" alt="">
             </div>
             <div style="box-shadow: none;text-align: right; padding-top: 20px;"class="col-md-3 col-sm-3">
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
         </div>

     </header>


     <div class="row" style="box-shadow: none;top: 18%; margin-right: 0px;margin-left: 0px;text-align: right;">

         <div class="col-md-12" style="box-shadow: none; text-align: center">
             <p>
                 نموذج طلب إجازة
             </p>
         </div>

         <br> <br> <br>


         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label> نوع الإجازة</label>
             <p>
                 {{ $vacationData->vacationType->name }}
             </p>
         </div>

         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label>التاريخ</label>
             <p>
                 {{ $vacationData->date }}
             </p>
         </div>

         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label>إسم الموظف</label>
             <p>
                 {{ $vacationData->user->name }}
             </p>
         </div>


         <hr>
         <br> <br> <br>

         <div class="col-md-8 col-xs-8 col-sm-8" style="box-shadow: none;">
             <label>الفترات</label>
             @foreach ($vacationData->period_ids_exploded as $item)
                 <p>{{ $item['period_name'] }}</p>
             @endforeach
         </div>
         {{-- <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label> إلى الساعة</label>
             <p>
                 {{ $vacationData->from_time }}
             </p>
         </div>
         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label> من الساعة</label>
             <p>
                 {{ $vacationData->from_time }}
             </p>
         </div> --}}
         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label>عدد أيام الإجازة</label>
             <p>
                 {{ $vacationData->no_of_days }}
             </p>
         </div>

         <hr>
         <br> <br> <br>
         <div class="col-md-12 col-xs-12 col-sm-12" style="box-shadow: none;">
             <label> سبب أخذ الإجازة</label>
             <p>
                 {{ $vacationData->vacation_reason }}
             </p>
         </div>
         <hr>
         <br> <br> <br>

         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label> حالة الإجازة</label>
             <p>
                 {{ $vacationData->status }}
             </p>
         </div>

         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label> المدير العام</label>
             <p>
                 الاستاذ:
             </p>
         </div>

         <div class="col-md-4 col-xs-4 col-sm-4" style="box-shadow: none;">
             <label> مدير الموارد البشرية</label>
             <p>

             </p>
         </div>

     </div>



     <footer>

         <div class="row" style="box-shadow: none">


             <div class="col-md-6" style="box-shadow: none">
                 <ul>
                     <li>
                         {{-- {{ $companyData->address_arabic }} --}}
                         <p>
                             نظام بصمة حقائب المسافر
                         </p>
                     </li>
                     <li>
                         {{-- {{ $companyData->about_arabic }} --}}
                         <p>
                             تصميم وبرمجة شركة كلاود سناب للبرمجيات والذكاء الاصطناعي
                         </p>
                     </li>
                 </ul>
             </div>

             <div class="col-md-6" style="box-shadow: none; direction: ltr; ">
                 <ul>
                     <li>
                         {{-- {{ $companyData->address_english }} --}}
                         <p>
                             Hakaeeb Almosafer Finger print
                         </p>
                     </li>
                     <li>
                         {{-- {{ $companyData->about_english }} --}}
                         <p>
                             Design and developing Cloud Snap Software Company for Artificial Intelligence
                         </p>
                     </li>
                 </ul>
             </div>
         </div>


     </footer>
 </div>

 <style>
     body {
         background: rgb(204, 204, 204);

     }


     div {
         position: relative;
         background: white;
         display: block;
         margin: 0 auto;

         box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
     }

     div[size="A4"] {
         width: 21cm;
         height: 29.7cm;
     }

     div[size="A4"][layout="portrait"] {
         width: 29.7cm;
         height: 21cm;
     }






     header,
     footer {
         position: absolute;
         left: 0;
         right: 0;
         padding-right: 12px;
         padding-left: 12px;
     }

     header:after {}


     header {
         top: 0;
         border-bottom: double;
         /* padding-top: 5mm;
         padding-bottom: 3mm; */
     }

     footer {
         bottom: 0;
         color: #000;
         padding-top: 3mm;
         padding-bottom: 5mm;
         direction: rtl;
         border-top: double;
     }

     @media print {

         body,
         div {
             margin: 0;
             box-shadow: 0;
         }

         header,
         footer {
             position: fixed;
             left: 0;
             right: 0;
             padding-right: 12px;
             padding-left: 12px;
         }
     }

     p {
         margin-bottom: 0px;
         font-weight: bold;
     }


     svg {
         border: 1px double;
         padding: 13px;
         border-radius: 20px;
         vertical-align: middle;
     }

     td {
         border: 1px solid;
     }
 </style>
