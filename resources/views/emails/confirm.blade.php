<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Confirmation</title>
</head>
<body>
    
    <h1>Thank you for signing up!</h1>

    <p>
        You need to click <a href='{{ url("register/confirm/{$user->token}") }}'>to confirm your email address</a> 
        for your account confirmation!
    </p>
</body>
</html>