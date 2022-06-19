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
    <form>
        @csrf
        <input type="text" value="{{$user->id}}" name="id">
        <input type="submit" value="upload">
    </form>
    <hr>



</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>
    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $("[name = id]").val();
        const IsAdmin = 1;
        const IsMaster = 1;
        const Wallet=1000;

        const video = 4;

        $.ajax({
            type:'POST',
            url:'/panel/user/'+id,
            dataType:"JSON",
            data:{
                IsAdmin:IsAdmin,
                IsMaster:IsMaster,
                Wallet:Wallet,
                video:video,
                _token:$("[name=_token]").val(),
                _method:"PUT"

            },

            success:result => alert(result.data)

            ,

        });
    });

</script>

