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

<h1>{{$video->Title}}:{{$video->id}}</h1>
price:{{$video->Price}}
<form>
    @csrf
    <input type="text" name="count" value="1"><br>
    <input type="text" name="model" value="Video">
    <input type="text" name="id" value="{{$video->id}}">
    <button type="submit">add to cart</button>
</form>

</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>
    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $("[name = id]").val();
        const model = $("[name = model]").val();
        const count = $("[name = count]").val().trim();

        $.ajax({
            type:'POST',
            url:'/api/cart',
            dataType:"JSON",
            data:{
                id : id,
                model : model,
                count : count,
                _token:$("[name=_token]").val(),

            },

            success:function (result){
                if(result.data === 'login'){
                    window.location.replace('/login');
                }else{
                    alert('Add to cart');
                }

            },error:function (result){

            }
        });
    });

</script>
