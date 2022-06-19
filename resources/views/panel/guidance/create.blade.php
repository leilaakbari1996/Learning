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

<form>
    @csrf
    Image:
    <input type="file" name="ImageURL"><br>Video:
    <input type="file" name="VideoURL"><br>Icon:
    <input type="file" name="IconURL"><br>
    <input type="submit">

</form>

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const title='title1';
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
        const relatedCourses = [7,8];
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
        });
    });
</script>
