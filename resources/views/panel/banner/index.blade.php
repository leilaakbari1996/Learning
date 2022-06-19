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
<h1>Banners</h1>
@foreach($banners as $banner)
    <h5>{{$banner->id}}</h5><br>
    <a href="{{route('panel.banner.show',$banner)}}">show</a>
    <form>
        @csrf
        <input type="text" name="id" value="{{$banner->id}}">
        <input type="submit" value="DELETE">
    </form>

@endforeach


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
            url:'/panel/banner/'+id,
            data:{
                _token :_token,
                _method:'DELETE'
            }

            ,success:result => alert(result.data),
        });
    });
</script>
