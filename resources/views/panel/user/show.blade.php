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


    {{$user->id}}
    <form id="master">
        @csrf
        <input type="text" value="{{$user->id}}" name="id">
        @if($user->IsMaster)
            <input type="text" name="value" value="false">
            <input type="submit" value="Delete of master">
        @else
            <input type="text" name="value" value="true">
            <input type="submit" value="master">
        @endif
    </form>

    <form id="admin">
        @csrf
        <input type="text" value="{{$user->id}}" name="id">
        @if($user->IsAdmin)
            <input type="text" name="valueAdmin" value="false">
            <input type="submit" value="Delete of Admin">
        @else
            <input type="text" name="valueAdmin" value="true">
            <input type="submit" value="Admin">
        @endif
    </form>
    <a href="{{route('panel.user.edit',$user)}}">edit</a>
    <hr>
    <h1>Course Like by {{$user->FirstName}}:</h1>
    @foreach($likeCourses as $course)
        {{$course->id}}
        <a href="{{route('panel.course.show',$course)}}">show</a><br>
    @endforeach
    <h1>Course SAVE by {{$user->FirstName}}:</h1>
    @foreach($saveCourses as $course)
        {{$course->id}}
        <a href="{{route('panel.course.show',$course)}}">show</a><br>
    @endforeach

    <h1>blog Like by {{$user->FirstName}}:</h1>
    @foreach($likeBlogs as $blog)
        {{$bloge->id}}
        <a href="{{route('panel.blog.show',$blog)}}">show</a><br>
    @endforeach
    <h1>blog SAVE by {{$user->FirstName}}:</h1>
    @foreach($saveBlogs as $blog)
        {{$blog->id}}
        <a href="{{route('panel.blog.show',$blog)}}">show</a><br>
    @endforeach

    <h1>Poscast Like by {{$user->FirstName}}:</h1>
    @foreach($likePodcasts as $podcast)
        {{$podcast->id}}
        <a href="{{route('panel.podcast.show',$podcast)}}">show</a><br>
    @endforeach
    <h1>Course SAVE by {{$user->FirstName}}:</h1>
    @foreach($savePodcasts as $podcast)
        {{$podcast->id}}
        <a href="{{route('panel.podcast.show',$podcast)}}">show</a><br>
    @endforeach

    @if($user->IsMaster)
        <h1>دوره های تدریس کرده</h1>
        @foreach($coursesTeaching as $course)
            {{$course->id}}:<a href="{{route('panel.course.show',$course)}}">show</a><br>
        @endforeach
    @endif





</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>
    $('#master').submit(function (event){
        event.preventDefault();
        const id = $("[name = id]").val();
        const value = $("[name=value]").val();

        $.ajax({
            type:'POST',
            url:'/panel/user/master/'+id,
            dataType:"JSON",
            data:{
                value:value,
                _token:$("[name=_token]").val(),
                _method:"PUT"

            },

            success:result => alert(result.data)

            ,

        });
    });

   $('#admin').submit(function (event){
        event.preventDefault();
        const id = $("[name = id]").val();
        const value = $("[name=valueAdmin]").val();

        $.ajax({
            type:'POST',
            url:'/panel/user/admin/'+id,
            dataType:"JSON",
            data:{
                value:value,
                _token:$("[name=_token]").val(),
                _method:"PUT"

            },

            success:result => alert(result.data)

            ,

        });
    });

</script>

