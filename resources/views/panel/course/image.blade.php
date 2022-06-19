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

@foreach($images as $image)
    <h5>{{$image}}</h5>
    <form>
        @csrf
        <input type="text" name="id" value="{{$course->id}}"><br>
        <input type="text" name="image" value="{{$image}}">
        <input type="submit" value="deleteimage of Course">
    </form>
@endforeach


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        const image=$('[name=image]').val();


        $.ajax({
            type:'POST',
            url:'/panel/course/'+id+'/images',
            datatype:'JSON',
            data:{
                id:id,
                image:image,
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            },success:result=>alert(result.data)
        });
    });


</script>
