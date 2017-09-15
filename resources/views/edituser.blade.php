<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
</head>
<body>
<h1> {{ $user->name }}</h1>
<h2> {{ $user->email }}</h2>

<p> Edit details </p>

<form action="/users" method="POST">

{{ csrf_field() }}
  Name:<br>
  <input type="text" id="name" name="name" 
  placeholder="{{$user->name}}"
  value="{{ Request::old('name', $user->name) }}"><br>

  <input type="text" id="email" name="email" 
  placeholder="{{$user->email}}"
  value="{{ Request::old('email', $user->email) }}"><br>
  
  <input type="hidden" id="id" name="id" 
  placeholder="{{$user->id}}"
  value="{{ Request::old('id', $user->id) }}">
  <input type="submit" value="Submit" >
</form>


</body>
</html>