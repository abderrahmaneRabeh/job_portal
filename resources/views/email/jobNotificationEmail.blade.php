<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @if($mailData['employer'])
    <h1>Hello, {{ $mailData['employer']->name }}</h1>
    @else
    <h1>Hello, Employer</h1>
    @endif
    <p>Job Title: {{ $mailData['job']->title }}</p>

    <p>Employee Details:</p>
    @if($mailData['user'])
    <p>Name: {{ $mailData['user']->name }}</p>
    <p>Email: {{ $mailData['user']->email }}</p>
    <p>Mobile No: {{ $mailData['user']->mobile }}</p>
    @else
    <p>Employee details not available</p>
    @endif
</body>

</html>