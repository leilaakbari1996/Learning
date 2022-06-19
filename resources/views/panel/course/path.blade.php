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

<h1>List Images Course : {{$course->id}}</h1>

@foreach($videos as $video)
    <h5>{{$video}}</h5>
    <form>
        @csrf
        <input type="text" name="id" value="{{$course->id}}"><br>
        <input type="text" name="video" value="{{$video}}">
        <input type="submit" value="deleteVideo of Course">
    </form>
@endforeach


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        const video=$('[name=video]').val();


        $.ajax({
            type:'POST',
            url:'/panel/course/'+id+'/videos',
            datatype:'JSON',
            data:{
                id:id,
                video:video,
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            },success:result=>alert(result.data)
        });
    });


</script>
