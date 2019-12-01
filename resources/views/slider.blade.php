@extends('layouts.app')

@section('content')
    <div id="app">
        <input id="sele" type="text" class="js-range-slider" name="my_range" value=""
               data-type="double"
               data-min="0"
               data-max="1000"
               data-from="200"
               data-to="500"
               data-grid="true"
        />
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        window.addEventListener("load", function(event) {
            $(".js-range-slider").ionRangeSlider(
                {type: "double",
                min: 0,
                max: 1000,
                // from: 200,
                // to: 500,
                grid: true}
            );
            $("#sele").change(function(e){
                console.log($(".js-range-slider").data("ionRangeSlider").result);
            })
        });
        </script>
@endsection

{{--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">--}}
{{--<html>--}}
{{--<head>--}}
{{--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">--}}
{{--    <title>Пример веб-страницы</title>--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css"/>--}}
{{--</head>--}}
{{--<body>--}}
{{--<h1>Заголовок</h1>--}}
{{--<!-- Комментарий -->--}}
{{--<p>Первый абзац.</p>--}}
{{--<p>Второй абзац.</p>--}}
{{--<input type="text" class="js-range-slider" name="my_range" value="" />--}}

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}

{{--<!--Plugin JavaScript file-->--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>--}}
{{--<script type="text/javascript">--}}
{{--    $(".js-range-slider").ionRangeSlider();--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
