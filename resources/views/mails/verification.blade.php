<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
</head>
<body>
    <p>Hii {{$name}},</p>
    <p>Click on below link to verify your account :</p>
    <a href="{{ $url}}">Click here</a>

    <p>Regards, <br>{{config('app.name')}} Team. <br> Please do not reply to this mali.</p>
</body>
</html>