@extends('frontend.master')

@section('title')
    {{ $siteSettings->title }} | Login / Register
@endsection

@section('content')

    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span></span> Login / Register
            </div>
        </div>
    </div>
    <section class="pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                @include('frontend.auth.frontMessage')
                @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="alert-ul">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Register</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                                <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h3 class="mb-30">Login</h3>
                                </div>
                                    <form method="post" action="{{ route('user.login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" required="" name="email" placeholder="Your Email">
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="login_footer form-group">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                                    <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                                </div>
                                            </div>
                                            <a class="text-muted" href="{{ route('forgetPassword') }}">Forgot password?</a>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-fill-out btn-block hover-up" name="login">Log in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="login_wrap widget-taber-content p-30 background-white border-radius-5">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h3 class="mb-30">Create an Account</h3>
                                    </div>
                                    <p class="mb-50 font-sm">
                                        Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy
                                    </p>
                                    <form action="{{ route('userRegister') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" required="" name="name" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required="" name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password" id="password" placeholder="Password" oninput="checkPasswordMatch()">
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" id="confirmPassword" placeholder="Confirm password" name="password_confirmation" oninput="checkPasswordMatch()">
                                            <span id="passwordMatchMessage" style="color: red;"></span>
                                        </div>
                                        <div class="login_footer form-group">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox12" value="YES">
                                                    <label class="form-check-label" for="exampleCheckbox12"><span>I agree to terms &amp; Policy.</span></label>
                                                </div>
                                            </div>
                                            <a href=""><i class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" id="submitButton" class="btn btn-fill-out btn-block hover-up" name="login">Submit & Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('customJs')

    <script>
        function checkPasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var passwordMatchMessage = document.getElementById("passwordMatchMessage");
            var submitButton = document.getElementById("submitButton");

            if (password === confirmPassword) {
                passwordMatchMessage.innerHTML = "";
                submitButton.disabled = false;
            } else {
                passwordMatchMessage.innerHTML = "Passwords do not match!";
                submitButton.disabled = true;
            }
        }
    </script>

@endsection
