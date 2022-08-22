<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registeration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <style>
        html,
        body {
            margin: 0;
            height: 100%;
        }

        input[type="text"] {

            background-color: #d1d1d1;

        }
    </style>
</head>

<body class="login">



    <div class="row" style="height: 100%;  ">








        <div class="col-md-12" style="height: 50%;padding-right: 40px;padding-left: 40px;padding-top: 40px;">
            <form action="{{url('/') . '/registeration'}}" method="POST">
                {{ csrf_field() }}

                <div class="col-md-12">
                    <h5>User data</h5>
                    <input type="text" id="user_name" name="user_name" placeholder="Full name" class="form-control"
                        required>

                    <input type="email" id="user_email" name="user_email" placeholder="User email"
                        class="form-control">

                    <input type="text" name="user_phone" id="number" placeholder="Phone number"
                        class="form-control">

                    <input type="password" name="password" id="password" placeholder="Password" class="form-control"
                        required>

                    <input type="password" id="confirm_password" placeholder="Confirm password" class="form-control"
                        required>



                </div>

                <br>

                <div class="col-md-12">
                    <h5>Company data</h5>
                    <input type="text" name="company_name" id="company_name" placeholder="Company name"
                        class="form-control" required>

                    <input type="email" name="company_email" id="company_email" placeholder="Company email"
                        class="form-control">

                    <input type="text" name="company_website" id="company_website" placeholder="Website" class="form-control">


                </div>


                <div style="padding-top: 20px; text-align: center;">
                    {{-- <input type="checkbox" name="remember" id="remember" value="1"><label for="remember"
                            class="remember-me-text">{{ __('voyager::generic.remember_me') }}</label> --}}
                    <button type="submit" class="btn btn-block login-button"
                        style="color: white;background-color: #0C2159;
                            padding-right: 60px;padding-left: 60px;
                            border-radius: 20px;
                            ">
                        Save
                    </button>
                </div>


            </form>
        </div>

    </div>


</body>
@if (!$errors->isEmpty())
    <div class="alert alert-red">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif


@section('post_js')
    <script>
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        var email = document.querySelector('[name="email"]');
        var password = document.querySelector('[name="password"]');
        btn.addEventListener('click', function(ev) {
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
        email.focus();
        document.getElementById('emailGroup').classList.add("focused");

        // Focus events for email and password fields
        email.addEventListener('focusin', function(e) {
            document.getElementById('emailGroup').classList.add("focused");
        });
        email.addEventListener('focusout', function(e) {
            document.getElementById('emailGroup').classList.remove("focused");
        });

        password.addEventListener('focusin', function(e) {
            document.getElementById('passwordGroup').classList.add("focused");
        });
        password.addEventListener('focusout', function(e) {
            document.getElementById('passwordGroup').classList.remove("focused");
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
        integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous">
    </script>
@endsection





</html>
