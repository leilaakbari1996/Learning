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


    {{$guidance->id}}<br>
    <a href="{{route('panel.guidance.edit',$guidance)}}">edit</a><br>
    <a href="{{route('panel.guidance.courses',$guidance)}}">مشاهده ی دوره ها</a><br>
    <a href="{{route('panel.guidance.related',$guidance)}}">Related</a><br>





</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id=$('[name=id]').val();
        const title='title1edit';
        const description='d1aaa';
        const ImageURL = '';
        const VideoURL = '';
        const IconURL = '';
        const order = 4;
        const IsSpecial = 1;
        const IsEnable = 1;
        const courses = [5,6];
        const relatedPodcast = [6];
        const relatedGuidance = [5];
        const relatedCourses = [7,8,9];
        const relatedBlog = [5,7];

        const _token = $('[name=_token]').val();
        const data = new FormData();

        courses.map(item => {
            data.append("Courses[]", item);
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
        data.append('Description',description);
        data.append('ImageURL',ImageURL);
        data.append('IconURL',IconURL);
        data.append('VideoURL',VideoURL);
        data.append('Order',order);
        data.append('IsEnable',IsEnable);
        data.append('IsSpecial',IsSpecial);
        data.append('_token',_token);
        data.append('_method','PUT');


        $.ajax({
            type:"POST",
            url:'/panel/guidance/'+id,
            dataType:'JSON',
            data:data,
            processData:false,
            contentType:false
            ,success:result => alert(result.data),
        });


        /*const title='title1';
        const description='d1aaa';
        const ImageURL = $('[name=ImageURL]')[0].files[0];
        const VideoURL = $('[name=VideoURL]')[0].files[0];
        const IconURL = $('[name=IconURL]')[0].files[0];
        const order = 4;
        const IsSpecial = 1;
        const IsEnable = 1;
        const courses = [5,6];
        const relatedPodcast = [6];
        const relatedGuidance = [5];
        const relatedCourses = [7,8,9];
        const relatedBlog = [5,7];

        const _token = $('[name=_token]').val();
        const data = new FormData();

        courses.map(item => {
            data.append("Courses[]", item);
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
        data.append('Description',description);
        data.append('ImageURL',ImageURL);
        data.append('IconURL',IconURL);
        data.append('VideoURL',VideoURL);
        data.append('Order',order);
        data.append('IsEnable',IsEnable);
        data.append('IsSpecial',IsSpecial);
        data.append('_token',_token);


        $.ajax({
            type:"POST",
            url:'/panel/guidance',
            dataType:'JSON',
            data:data,
            processData:false,
            contentType:false
            ,success:result => console.log(result.data),
        });*/
    });
</script>
