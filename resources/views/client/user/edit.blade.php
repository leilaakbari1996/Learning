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
<h1>{{$user->FirstName}}</h1>
<form id="user">
    @csrf
    <input type="file" name="ProfileURL">
    <input type="text" name="id" value="{{$user->id}}">
    <input type="submit" value="edit">
</form>


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>

<script>
    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $("[name = id]").val();
        const ProfileURL = $('[name=ProfileURL]')[0].files[0];
        const _token = $('[name=_token]').val();
        const Wallet = 10;

        const data = new FormData();
        data.append("ProfileURL", ProfileURL);
        data.append('Wallet',Wallet);
        data.append('PhoneNumber',11461111);
        data.append('_token',_token);
        data.append('_method','PUT');

        $.ajax({
            type:'POST',
            url:'/api/user/'+id,
            dataType:"JSON",
            data:data,
            processData:false,
            contentType:false,
            success:result => alert(result.data)


        });
    });

</script>

