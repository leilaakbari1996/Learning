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
@include('panel.navbar')
<h1>{{$blogCategory->id}}</h1>
<a href="{{route('panel.blogCategory.edit',$blogCategory)}}">edit</a>

<a href="{{route('panel.blogCategory.blogs',$blogCategory)}}">بلاگ ها</a>

</body>
</html>


