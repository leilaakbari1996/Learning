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
{{arrange('Parent',$categoriesParent)}}/course:{{$course->id}}
<br>
{{show_array_tag('Tages',$tags,'tag')}}
<form>
    @csrf
    <input type="text" name="count" value="1"><br>
    <input type="hidden" name="model" value="Course">
    <input type="hidden" name="id" value="{{$course->id}}">
    <button type="submit">add to cart</button>
</form>
<h1>Video Title</h1>
@foreach ($videoTitle as $array)
    <h3><a href="/course/{{$course->Slug}}/videoTitle/{{$array['parent']->Title}}">{{$array['parent']->id}}</a></h3>
    @if(count($array['child']) != 0)
        @foreach ($array['child'] as $child)
            <a href="/course/{{$course->Slug}}/videoTitle/{{$child->Title}}">child:{{$child->id}}</a>
        @endforeach
    @endif
@endforeach

{{show_array('Related Courses',$relatedCourse,'course')}}
{{show_array('Related Blog',$relatedBlog,'blog')}}
{{show_array('Related Podcast',$relatedPodcast,'podcast')}}

<h1>Comments</h1>
{{show_separate_parent_child($comments,'#')}}
<br>{{$settings["Description"]}}
{{show_array('Related Guidance',$relatedGuidance,'guidance')}}

{{show_array_master('User Buy Courses',$users,'user')}}
{{show_array_master('Masters',$masters,'user')}}
jjjjjjjjj
<br><br><br>
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
                    alert(result.data);
                }

            },error:function (result){

            }
        });
    });

</script>
