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
<h1>{{$podcast->id}}</h1>
<h1>Related podcast</h1>
@foreach($relatedPodcasts as $related)
    {{$related->id}}<br>
    <a href="{{route('panel.podcast.show',$related)}}">show</a>
    <form>
        @csrf
        <input type="text" name="podcastId" value="{{$podcast->id}}">
        <input type="text" name="id" value="{{$related->id}}">
        <input type="text" name="Related" value="podcasts">
        <input type="submit" value="delete">
    </form>
@endforeach

<h1>Related blog</h1>
@foreach($relatedBlog as $related)
    {{$related->id}}<br>
    <a href="{{route('pane.blog.show',$related)}}">show</a>
    <form>
        @csrf
        <input type="text" name="podcastId" value="{{$podcast->id}}">
        <input type="text" name="id" value="{{$related->id}}">
        <input type="text" name="Related" value="blogs">
        <input type="submit" value="delete">
    </form>
@endforeach

<h1>Related course</h1>
@foreach($relatedCourses as $related)
    {{$related->id}}<br>
    <a href="{{route('pane.course.show',$related)}}">show</a>
    <form>
        @csrf
        <input type="text" name="podcastId" value="{{$podcast->id}}">
        <input type="text" name="id" value="{{$related->id}}">
        <input type="text" name="Related" value="courses">
        <input type="submit" value="delete">
    </form>
@endforeach

<h1>Related guidance</h1>
@foreach($relatedGuidance as $related)
    {{$related->id}}<br>

    <form>
        @csrf
        <input type="text" name="podcastId" value="{{$podcast->id}}">
        <input type="text" name="id" value="{{$related->id}}">
        <input type="text" name="Related" value="guidances">
        <input type="submit" value="delete">
    </form>
@endforeach






</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const podcastId = $('[name=podcastId]').val();
        const id = $('[name=id]').val();

        const Related = $('[name=Related]').val();



        $.ajax({
            type:"POST",
            url:'/panel/podcast/'+podcastId+'/related',
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
