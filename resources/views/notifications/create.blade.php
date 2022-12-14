@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href={{ url('/') . '/multiselect/css/style_custom.css' }}>


@stop

@section('page_title', ' إضافة الفترات')

@section('page_header')
    <h1 class="page-title">
        إرسال إشعارات
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <!-- form start -->


                    <form class="form-inline form-filter" method="POST" action="<?php echo url('/'); ?>/send-notifi">
                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}


                        <div class="form-group">
                            <div class="dropdown-container">
                                <div class="dropdown-button noselect w-100">
                                    <div class="dropdown-label">المستخدمين</div>
                                    <div class="dropdown-quantity">(<span class="quantity">0</span>)</div>
                                    <i class="fa fa-chevron-down"></i>
                                </div>
                                <div class="dropdown-list" style="display: none;">

                                    <input type="search" placeholder="البحث..." class="dropdown-search" />
                                    <ul id="ul"></ul>
                                </div>
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group" style="width: 100%">
                                    <label for="exampleInputEmail1">العنوان</label>
                                    <br>
                                    <input type="text" style="width: 100%;" class="form-control" name="title"
                                        placeholder="عنوان الإشعار" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group" style="width: 100%;">
                                    <label for="exampleInputEmail1">نص الإشعار</label>
                                    <textarea style="width: 100%;" type="text" class="form-control" name="body" placeholder="نص الإشعار"></textarea>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <input class="form-control btn btn-primary" type="submit" value="إرسال">
                        </div>


                    </form>



                </div>
            </div>
        </div>
    </div>

@stop


@section('javascript')


    <script src={{ url('/') . '/multiselect/js/jquery.min.js' }}></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/3.5.0/lodash.min.js"></script>

    <script src={{ url('/') . '/multiselect/js/bootstrap.min.js' }}></script>


    <script>
        window.onload = function() {






        }


        var params = {};
        var $file;



        $('document').ready(function() {


            (function($) {
                $(document)
                    .on("click", ".dropdown-button", function() {
                        $(this).siblings(".dropdown-list").toggle();
                    })
                    .on("input", ".dropdown-search", function() {
                        var target = $(this);
                        var dropdownList = target.closest(".dropdown-list");
                        var search = target.val().toLowerCase();

                        if (!search) {
                            dropdownList.find("li").show();
                            return false;
                        }

                        dropdownList.find("li").each(function() {
                            var text = $(this).text().toLowerCase();
                            var match = text.indexOf(search) > -1;
                            $(this).toggle(match);
                        });
                    })
                    .on("change", '[type="checkbox"]', function() {
                        var container = $(this).closest(".dropdown-container");
                        var numChecked = container.find('[type="checkbox"]:checked').length;
                        container.find(".quantity").text(numChecked || "Any");
                    });

                // JSON of States for demo purposes

                var users = <?php
                $users = \App\Models\User::where('role_id', 3)->get();
                foreach ($users as $user_val) {
                    $final[] = [
                        'name' => $user_val->name,
                        'abbreviation' => $user_val->id,
                        'capName' => $user_val->name,
                    ];
                }
                echo json_encode($final);
                ?>



                var usStates = [{
                        name: "ALABAMA",
                        abbreviation: "AL"
                    },
                    {
                        name: "ALASKA",
                        abbreviation: "AK"
                    },

                ];

                var stateTemplate = _.template(



                    // "<li>" +
                    // '<label class="checkbox-wrap"><input id="colorsid" name="users[]" value="<%= abbreviation %>" type="checkbox"> <span for="<%= abbreviation %>"><%= name %></span> <span class="checkmark"></span></label>' +
                    // "</li>"

                    "<li>" +
                    '<label class="checkbox-wrap"><input id="colorsid" name="users[]" value="<%= abbreviation %>" type="checkbox"> <span for="<%= abbreviation %>"><%= name %></span> <span class="checkmark"></span></label>' +
                    "</li>"
                );

                console.log('hakeeem===> ', users)
                // Populate list with states
                _.each(users, function(s) {
                    s.capName = _.startCase(s.name.toLowerCase());
                    $("#ul").append(stateTemplate(s));
                });


            })(jQuery);

        });
    </script>

    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"
        integrity="sha256-xH4q8N0pEzrZMaRmd7gQVcTZiFei+HfRTBPJ1OGXC0k=" crossorigin="anonymous"></script>


@stop
