<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/main.css')}}">

    <!-- Styles -->

</head>
<body>
<div id="container-1">
    <h2 align="center">KPIS Dashboard Task</h2>
</div>
<div id="container">
    <div class="kpi-card orange">
        <a href="{{route("transactions.kpi.index")}}">
            <span class="card-value">User KPI </span>

            <span class="card-text">Click to see more details</span>
        </a>

    </div>


    <div class="kpi-card purple">
        <a href="">
            <span class="card-value">Product KPI </span>
            <span class="card-text">Click to see more details</span>
        </a>
    </div>

    <div class="kpi-card grey-dark">
        <a href="">
            <span class="card-value">Transaction KPI </span>
            <span class="card-text">Click to see more details</span>
        </a>
    </div>

</div>

</body>
</html>
