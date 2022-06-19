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

<h1>category course</h1>

    {{$category->id}}
<a href="{{route('panel.coursesCategory.edit',$category)}}">edit</a>
    <form>
        @csrf
        <input type="text" value="{{$category->id}}" name="id">
        <input type="submit" value="delete of list categories">
    </form>


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        const _token = $('[name=_token]').val();
        $.ajax({
            type:"POST",
            url:'/panel/coursesCategory/'+id,
            dataType:'JSON',
            data:{
                _token:_token,
                _method:'DELETE'
            }
            ,success:result => alert(result.data),
        });
    });
</script>
