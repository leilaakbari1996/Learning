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
<h1>{{$user->FirstName}}</h1>
<h3>Orders Payed</h3>
@foreach($orders['payed'] as $order)
    {{$order->id}}<br>
@endforeach
<h3>Order NoyPayed</h3>
@foreach($orders['notPayed'] as $order)
    {{$order->id}}
@endforeach
<h3>Courses</h3>
@foreach($courses as $course)
    {{$course->id}}<br>
@endforeach
<h3>Videos</h3>
@foreach($videos as $vidoe)
    {{$vidoe->id}}<br>
@endforeach
<h3>Like Course</h3>
@foreach($likes['courses'] as $like)
    {{$like->id}}<br>
@endforeach
<h3>Like Blog</h3>
@foreach($likes['blogs'] as $like)
    {{$like->id}}<br>
@endforeach
<h3>Like Podcast</h3>
@foreach($likes['podcasts'] as $like)
    {{$like->id}}<br>
@endforeach
<h3>Save Course</h3>
@foreach($saves['courses'] as $like)
    {{$like->id}}<br>
@endforeach
<h3>Save Blog</h3>
@foreach($saves['blogs'] as $like)
    {{$like->id}}<br>
@endforeach
<h3>Save Podcast</h3>
@foreach($saves['podcasts'] as $like)
    {{$like->id}}<br>
@endforeach

</body>
</html>
