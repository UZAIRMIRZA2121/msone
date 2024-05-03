@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head"></h1>
        </section>
        <div class="container">
            <div class="wrapper">
                <div class="title"><span>Sign up <br></span></div>
                <x-validation-errors class="mb-4" />
                @if (session('alert'))
                <center>
                    <div id="alert" class="alert alert-danger fs-4 w-50">
                        {{ session('alert') }}
                    </div>
                </center>
            @endif
           
                <div class="d-flex justify-content-center">
                    <form method="POST" action="{{ route('register.user') }}" class="w-25"
                        onsubmit="return validatePassword()">
                        @csrf
                        <div class="row">
                            <input type="text" placeholder="Username" name="name" :value="old('name')" required
                                autofocus autocomplete="name">
                        </div>
                        <div class="row">
                            <input type="email" placeholder="Email" name="email" :value="old('email')" required
                                autocomplete="username">
                        </div>
                        <div class="row">
                            <input type="password" placeholder="Password" name="password" id="password" required
                                autocomplete="new-password" onkeyup="validatePasswords()">
                        </div>
                        <div class="row">
                            <input type="password" placeholder="Confirm Password" name="password_confirmation"
                                id="confirm_password" required autocomplete="new-password" onkeyup="validatePasswords()">
                        </div>

                        <p id="password_error" class="alert alert-danger fs-3 my-1" style=" display: none;">Passwords do not
                            match.</p>


                        <center>
                            <div class="row button w-50 btn-sm">
                                <input type="submit" value="Register">
                            </div>
                        </center>

                        <div class="signup-link">Already have an account? <a href="{{ route('login') }}">Sign In now</a>
                        </div>
                    </form>
                </div>
            </div>
    </main>
    <script>
        function validatePasswords() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;
            var password_error = document.getElementById("password_error");

            if (password != confirm_password) {
                password_error.style.display = "block";
            } else {
                password_error.style.display = "none";
            }
        }

        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            return password === confirm_password;
        }
    </script>
@endsection
