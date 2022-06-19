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
<h1>course:{{$course->id}}</h1>
<h1>VideoTitle:{{$videosTitle->id}}</h1>
<h1>video : {{$video->id}}</h1>
<a href="/panel/course/{{$course->id}}/videoTitle/{{$videosTitle->id}}/video/{{$video->id}}/edit">edit</a>
<form>
    @csrf
    Video:
    <input type="text" name="videoId" value="{{$video->id}}"><br>
    <input type="text" name="videoTitleId" value="{{$videosTitle->id}}"><br>
    <input type="text" name="courseId" value="{{$course->id}}"><br>
    <input type="submit" value="delete">

</form>

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const videoId = $('[name=videoId]').val();
        const video_title_id = $('[name=videoTitleId]').val();
        const courseId = $('[name=courseId]').val();

        $.ajax({
            type:"POST",
            url:'/panel/course/'+courseId+'/videoTitle/'+video_title_id+'/video/'+videoId,
            dataType:'JSON',
            data:{
                _method:'DELETE',
                _token:$('[name=_token]').val()
            }

            ,success:result => console.log(result.data),
        });
    });
</script>
