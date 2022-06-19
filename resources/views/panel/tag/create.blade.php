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
<form>
    @csrf
    <input type="submit" value="send">
</form>
</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const title='title1';

        $.ajax({
            type:"POST",
            url:'/panel/tag',
            dataType:'JSON',
            data:{
                Title :title,
                _token:$('[name=_token]').val(),
            },success:result => console.log(result.data),
        });
    });
</script>
