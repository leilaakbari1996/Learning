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

<h1>List category</h1>
<h3>{{$course->id}}</h3>
@foreach($categories as $category)
    <h5>{{$category->id}}</h5>
    <a href="{{route('panel.coursesCategory.show',$category,$course)}}">show</a>
    <form>
        @csrf
        <input type="text" name="id" value="{{$course->id}}"><br>
        <input type="text" name="categoryId" value="{{$category->id}}"><br>
        <input type="submit" value="delete of list categories course">
    </form>
@endforeach


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        const categoryId = $('[name=categoryId]').val();

        $.ajax({
            type:'POST',
            url:'/panel/course/'+id+'/category',
            datatype:'JSON',
            data:{
                categoryId:categoryId,
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            },success:result=>alert(result.data)
        });
    });


</script>
