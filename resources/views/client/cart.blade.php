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
<h2>Courses</h2>
@foreach($courses as $child)
    {{$child->id}} => {{$child->pivot->Count}}
    <br>
@endforeach


<br>
<h2>Videos</h2>
@foreach($videos as $child)
    {{$child->id}} => {{$child->pivot->Count}}
    <br>
@endforeach

@if(count($videos) != 0 || count($courses) != 0)
    <a href="{{route('client.order.index')}}">Add To Order</a>
@endif
</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>
    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();

        const model = $("[name = model]").val();

        $.ajax({
            type:'POSt',
            url:'/api/cart/all',
            dataType:"JSON",
            data:{
                model:model,
                _token:$("[name=_token]").val(),
                _method : 'DELETE'

            },

            success:function (result){
                alert('ok');
            },error:function (result){

            }
        });
    });

</script>

