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
@foreach($blogs as $blog)
    {{$blog->id}}: <br>
    <a href="{{route('panel.blog.show',$blog)}}">show</a><br>
    <form>
        @csrf
        Image:
        <input type="text" name="id" value="{{$blog->id}}">
        <input type="submit" value="delete">

    </form>
@endforeach


</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        $.ajax({
            type:"POST",
            url:'/panel/blog/'+id,
            dataType:'JSON',
            data:{
                _token:$('[name=_token]').val(),
                _method:'DELETE'
            }
            ,success:result => alert(result.data),
        });
        /*const title='title1';
        const text='d1aaa';
        const ImageURL = $('[name=ImageURL]')[0].files[0];
        const order = 4;
        const id = $('[name=id]').val();
        const IsNew = 1;
        const IsEnable = 1;
        const seoTitle = 't1';
        const seoDescription = 'sd1';
        const relatedPodcast = [1,2,3];
        const relatedGuidance = [3,4];
        const relatedCourses = [1];
        const relatedBlog = [2,3];
        const author_id = 3;
        const categories = [1,2,3];
        const _token = $('[name=_token]').val();
        const data = new FormData();

        categories.map(item => {
            data.append("Categories[]", item);
        });
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
        data.append('Text',text);
        data.append('ImageURL',ImageURL);
        data.append('Order',order);
        data.append('IsNew',IsNew);
        data.append('IsEnable',IsEnable);
        data.append('SeoTitle',seoTitle);
        data.append('SeoDescription',seoDescription);
        data.append('author_id',author_id);
        data.append('id',id);
        data.append('_token',_token);
        data.append('_method','PUT');


        $.ajax({
            type:"POST",
            url:'/panel/blog',
            dataType:'JSON',
            data:data,
            processData:false,
            contentType:false
            ,success:result => alert(result.data),
        });*/
    });
</script>
