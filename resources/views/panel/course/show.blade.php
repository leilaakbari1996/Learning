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
    <h5>{{$course->id}}</h5>

    <a href="{{route('panel.course.edit',$course)}}">edit</a><br>
    <a href="{{route('panel.course.videosTitle.index',$course)}}">list video Titles</a><br>
    <a href="{{route('panel.course.categories',$course)}}">List Category</a><br>
    <a href="{{route('panel.course.related',$course)}}">Relateds</a><br>
    <a href="{{route('panel.course.image',$course)}}">Images</a><br>
    <a href="{{route('panel.course.video',$course)}}">Videos</a><br>
    <form>
        @csrf
        <input type="text" name="id" value="{{$course->id}}"><br>
        <input type="submit" value="delete">
    </form>



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
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            },success:result=>alert(result.data)
        });
    });


</script>
