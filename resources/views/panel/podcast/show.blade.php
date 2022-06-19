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
<h1> Podcast :</h1>
    <h4>{{$podcast->id}}</h4>
    <a href="{{route('panel.podcast.edit',$podcast)}}">edit </a><br>
    <a href="{{route('panel.podcast.related',$podcast)}}">Related </a><br>

    <form>
        @csrf
        <input type="text" name="id" value="{{$podcast->id}}">

        <input type="submit" value="delete">
    </form>


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id=$('[name=id]').val();
        /*const title='title1podcast';
        const description='d1aaa';
        const ImageURL = $('[name=ImageURL]')[0].files[0];
        const AudioURL = $('[name=Audio]')[0].files[0];
        const order = 4;
        const IsNew = 1;
        const IsSpecial = 1;
        const IsEnable = 1;
        const seoTitle = 't1';
        const seoDescription = 'sd1';
        const relatedPodcast = [1,2,3];
        const relatedGuidance = [3,4];
        const relatedCourses = [1];
        const relatedBlog = [2,3];
        const id=$('[name=id]').val();

        const _token = $('[name=_token]').val();
        const data = new FormData();

        relatedPodcast.map(item => {
            data.append("RelatedPodcast[]", item);
        });
        relatedCourses.map(item => {
            data.append('RelatedCourses[]',item);
        });
        relatedGuidance.map(item => {
            data.append('RelatedGuidances[]',item);
        });
        relatedBlog.map(item => {
            data.append('RelatedBlog[]',item);
        });
        data.append("Title", title);
        data.append('Description',description);
        data.append('ImageURL',ImageURL);
        data.append('AudioURL',AudioURL);
        data.append('Order',order);
        data.append('IsNew',IsNew);
        data.append('IsEnable',IsEnable);
        data.append('IsSpecial',IsSpecial);
        data.append('SeoTitle',seoTitle);
        data.append('SeoDescription',seoDescription);
        data.append('id',id);
        data.append('_token',_token);
        data.append('_method','PUT');

*/
        $.ajax({
            type:"POST",
            url:'/panel/podcast/'+id,
            dataType:'JSON',
            data:{
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            }
            ,success:result => alert(result.data),
        });
    });
</script>
