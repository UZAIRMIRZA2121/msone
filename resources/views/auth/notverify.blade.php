
<!DOCTYPE html>
<html>
<head>
    <title>Not Verified - Please Log In</title>
</head>
<body>
    <div class="alert alert-danger" role="alert">
        {{ session('alert') }}
    </div>
    <h1>You are not verified</h1>
    <p>Please log in with your credentials.</p>
    <a href="{{ route('login') }}">Back to Login</a>
</body>
</html>