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
    <input type="text" name="id" value="{{$coursesCategory->id}}">
    <input type="submit" value="update">

</form>

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const title='title1';
        const id=$('[name=id]').val();
        const order = 4;
        const IsSpecial = 1;
        const IsEnable = 1;
        const parent_id = null;
        const level = 3;
        const _token = $('[name=_token]').val();
        $.ajax({
            type:"POST",
            url:'/panel/coursesCategory/'+id,
            dataType:'JSON',
            data:{
                Title:title,
                Level : level,
                parent_id:parent_id,
                IsEnable:IsEnable,
                IsSpecial:IsSpecial,
                Order:order,
                _token:_token,
                _method:'PUT'
            }
            ,success:result => alert(result.data),
        });
    });
</script>
