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

@foreach($courses as $course)
    {{$course->id}}
    <a href="{{route('client.course.show',$course->Slug)}}">ثبت نام و دیدن جزییات</a><br>
@endforeach

<br><br><br>
</body>
</html>
