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

@foreach($courses as $course)
    {{$course->id}}<br>
    <form>
        @csrf
        <input type="text" name="id" value="{{$guidance->id}}">course:
        <input type="text" name="courseId" value="{{$course->id}}">
        <input type="submit" value="حذف این دوره از مسیر راهنما">
    </form>
@endforeach


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        const courseId = $('[name=courseId]').val();


        $.ajax({
            type:"POST",
            url:'/panel/guidance/'+id+'/course/',
            dataType:'JSON',
            data:{
                courseId:courseId,
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            }
            ,success:result => alert(result.data),
        });
    });
</script>
