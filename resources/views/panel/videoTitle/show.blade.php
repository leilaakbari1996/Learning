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
<h1>course:{{$course->id}}</h1>
<h3>Video Title : </h3>

    {{$videosTitle->id}}
    <a href="/panel/course/{{$course->id}}/videoTitle/{{$videosTitle->id}}/video/create">Upload Videos</a><br>
    <a href="/panel/course/{{$course->id}}/videoTitle/{{$videosTitle->id}}/video/">list Videos</a>

    <hr>
<form>
    @csrf
    <input type="text" name="id" value="{{$videosTitle->id}}"><br>
    <input type="text" name="courseId" value="{{$course->id}}"><br>
    <input type="submit" value="delete">

</form>



</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>
    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $("[name = id]").val();
        const courseId = $("[name = courseId]").val();


        $.ajax({
            type:'POST',
            url:'/panel/course/'+courseId+'/videosTitle/'+id,
            dataType:"JSON",
            data:{
                _token:$("[name=_token]").val(),
                _method:"DELETE"

            },

            success:result => alert(result.data)

            ,

        });
    });

</script>

