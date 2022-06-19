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

<a href="{{route('panel.comment.filter','Rejected')}}">filter</a>
<form>
    <input type="text" name="filter" value="UnRead">
    <input type="submit" value="filter">
</form>
@foreach($commentsCourses as $comment)
    Courses :{{$comment['UnRead']->commentable_id}} <br>

    @if(!empty($comment['parent']))
        Parent : {{$comment['parent']->id}} <br>

    @endif
    Coment : {{$comment['UnRead']->id}}
    <form>
        @csrf
        <input type="text" value="{{$comment['UnRead']->id}}" name="id">
        <input type="text" value="Course" name="model">

        <input type="submit" value="Delete">
    </form>
    <hr>

@endforeach

</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const filter = $("[name = filter]").val();


        $.ajax({
            type:'GET',
            url:'/panel/comment/filter/',
            dataType:"JSON",
            data:{
                model : model,
                _token:$("[name=_token]").val(),

            },

            success:result => alert(result.data)

            ,error:result => alert('not')

        });
    });


    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $("[name = id]").val();
        const model = $("[name = model]").val();


        $.ajax({
            type:'POST',
            url:'/panel/comment/'+id,
            dataType:"JSON",
            data:{
                model : model,
                _token:$("[name=_token]").val(),
                _method:"DELETE"

            },

            success:result => alert(result.data)

            ,error:result => alert('not')

        });
    });

</script>

