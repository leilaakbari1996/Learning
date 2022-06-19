<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Head::GetTitle()}}</title>
</head>
<body>
<h1>{{$videoTitle->Title}}:{{$videoTitle->id}}</h1>

@foreach ($videos as $item)
    @if(!empty($item))
        <h5><a href="/video/{{$item->Title}}">{{$item->id}} </a></h5>
    @endif
@endforeach

</body>
</html>
