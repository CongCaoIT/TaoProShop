<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin</title>
<base href="{{ env('APP_URL') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="Administrator/css/bootstrap.min.css" rel="stylesheet">
<link href="Administrator/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="Administrator/css/animate.css" rel="stylesheet">
@if (isset($config['css']) && is_array($config['css']))
    @foreach ($config['css'] as $key => $val)
        {!! '<link href="' . $val . '" rel="stylesheet">' !!}
    @endforeach
@endif
<link href="Administrator/css/style.css" rel="stylesheet">
<link href="Administrator/css/customize.css" rel="stylesheet">
<script src="Administrator/js/jquery-3.1.1.min.js"></script>
