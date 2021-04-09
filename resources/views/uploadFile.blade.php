<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .mainDiv{
            border: 1px solid black;
            height: 60px;
            width: 500px;
            padding: 30px;
        }
        .button{
            color: white;
            background-color: #4ec8e8;
            height: 30px;
            border: hidden;
        }
        .button:hover{
            background-color: #0C9A9A;
        }
    </style>
</head>
<body>
<h1><b>Upload CSV File:</b></h1>
    <div class="mainDiv">
        <form action="{{ route('store') }}" enctype="multipart/form-data" method="post">
            @csrf

            <label for="file" class="" style="color: black">choose file in csv format</label>

            <input id="file" type="file" class="" name="file" value="{{ old('file') }}" required autofocus>
            <br/>
            <br/>
            <button class="button"  style="">Add File</button>
        </form>
    </div>
</body>
</html>