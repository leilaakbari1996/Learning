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

<h1>List Courses</h1>

@foreach($courses as $course)
    <h5>{{$course->id}}</h5>

    <a href="{{route('panel.course.show',$course)}}">show</a><br>
    <!--<a href="/panel/course/{{$course->id}}/videosTitle">list video Titles</a><br>
    <a href="/panel/course/{{$course->id}}/categories">List Category</a><br>
    <a href="/panel/course/{{$course->id}}/related">Relateds</a><br>
    <a href="/panel/course/{{$course->id}}/images">Images</a><br>
    <a href="/panel/course/{{$course->id}}/videos">Videos</a><br>-->

@endforeach


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();

        $.ajax({
            type:'POST',
            url:'/panel/course/'+id,
            datatype:'JSON',
            data:{
                id:id,
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            },success:result=>alert(result.data)
        });
    });


</script>
