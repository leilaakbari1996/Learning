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

    {{$coupon->Title}}:
    <form>
        @csrf
        <input type="text" value="{{$coupon->id}}" name="id">
        start:
        <input type="date" name="startDate"> <br>
        End:
        <input type="date" name="endDate">
        <input type="submit" value="edit">
    </form>


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const title='couponedit1';
        const id=$('[name=id]').val();
        const IsEnable = 1;
        const count = 20;
        const type = 'Code';
        const amount = 2000;
        const minOrder = 100000;
        const startDate = $('[name=startDate]').val();
        const endDate = $('[name=endDate]').val();
        const _token = $('[name=_token]').val();

        $.ajax({
            type:"POST",
            url:'/panel/coupon/'+id,
            dataType:'JSON',
            data:{
                Title:title,
                IsEnable:IsEnable,
                Count:count,
                Type:type,
                Amount:amount,
                MinOrder:minOrder,
                StartDate:startDate,
                EndDate:endDate,
                _token:_token,
                _method:'PUT'
            },
            success:result => alert(result.data),
        });
    });
</script>
