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

{{arrange('Parent',$parent)}}
<br>
{{show_array('Courses This Category',$courses,'course')}}
<br>
{{show_array('Sort By Likes',$sortCourses,'course')}}
</body>
</html>
