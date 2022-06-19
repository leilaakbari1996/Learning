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
<h1>{{$course->id}}</h1>
{{show_array_panel('Related Podcast',$relatedPodcasts,'podcast')}}
{{show_array_panel('Related Course',$relatedCourses,'course')}}
{{show_array_panel('Related Guidance',$relatedGuidance,'guidance')}}
{{show_array_panel('Related Blog',$relatedBlog,'blog')}}



</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        const Related = $('[name=Related]').val();
        const type = $('[name=type]').val();
        const RecordId = $('[name=RecordId]').val();


        $.ajax({
            type:"POST",
            url:'/panel/'+type+'/'+RecordId+'/related',
            dataType:'JSON',
            data:{
                id:id,
                Related:Related,
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            }
            ,success:result => alert(result.data),
        });
    });
</script>
