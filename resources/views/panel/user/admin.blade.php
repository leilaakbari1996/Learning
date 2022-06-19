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

@foreach($admins as $admin)
    {{$admin->id}}
    <form>
        @csrf
        <input type="text" value="{{$admin->id}}" name="id">
        <input type="submit" value="Delete of Admin">
    </form>
    <hr>

@endforeach

</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>
    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $("[name = id]").val();

        $.ajax({
            type:'POST',
            url:'/panel/admin/'+id,
            dataType:"JSON",
            data:{
                _token:$("[name=_token]").val(),
                _method:"DELETE"

            },

            success:result => alert(result.data)

            ,
        });
    });

</script>

