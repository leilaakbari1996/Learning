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
<h3>Video Titles : </h3>
@foreach($videoTitles as $videoTitle)
    {{$videoTitle['parent']->id}}
    <a href="/panel/course/{{$course->id}}/videosTitle/{{$videoTitle['parent']->id}}">show</a>
    <form>
        @csrf
        <input type="text" value="{{$videoTitle['parent']->id}}" name="id">
        <input type="submit" value="edit">
    </form>
    @if(!empty($videoTitle['child']))
        Child: <br>
        @foreach($videoTitle['child'] as $child)
            {{$child->id}}<br>
            <a href="/panel/course/{{$course->id}}/videoTitles/{{$child->id}}">show</a>
            <form>
                @csrf
                <input type="text" value="{{$child->id}}" name="id">
                <input type="submit" value="edit">
            </form>
        @endforeach
    @endif
    <hr>

@endforeach

</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $("[name = id]").val();
        const Title = 'Video Title 1';
        const Order = 200;
        const IsEnable = 1;


        $.ajax({
            type:'POST',
            url:'/panel/course/videoTitle',
            dataType:"JSON",
            data:{
                id : id,
                Title:Title,
                Order:Order,
                IsEnable:IsEnable,
                course_id:260,
                parent_id : '',
                _token:$("[name=_token]").val(),
                _method:"PUT"

            },

            success:result => alert(result.data)

            ,

        });
    });

</script>

