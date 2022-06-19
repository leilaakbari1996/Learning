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
@foreach($categories as $category)
    {{$category->id}}<br>
    <a href="{{route('panel.blogCategory.show',$category)}}">show</a>
    <form>
        @csrf
        <input type="text" value="{{$category->id}}" name="id">
        <input type="submit" value="delete">

    </form>

@endforeach

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        $.ajax({
            type:"POST",
            url:'/panel/blogCategory/'+id,
            dataType:'JSON',
            data:{
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            }
            ,success:result => alert(result.data),
        });
        /*const title='title1edit';
        const order = 400;
        const IsSpecial = 1;

        const IsEnable = 1;
        const parent_id = null;
        const _token = $('[name=_token]').val();

        $.ajax({
            type:"POST",
            url:'/panel/categoryBlog',
            dataType:'JSON',
            data:{
                id:id,
                Title:title,
                parent_id:parent_id,
                IsEnable:IsEnable,
                IsSpecial:IsSpecial,
                Order:order,
                _token:_token,
                _method:'PUT'
            }
            ,success:result => alert(result.data),
        });*/
    });
</script>
