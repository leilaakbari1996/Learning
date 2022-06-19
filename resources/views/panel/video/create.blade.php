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
<h1>course:{{$course->id}}</h1>
<h1>VideoTitle:{{$videosTitle->id}}</h1>
<form>
    @csrf
    Video:
    <input type="file" name="VideoURL"><br>
    <input type="text" name="videoTitleId" value="{{$videosTitle->id}}"><br>
    <input type="text" name="courseId" value="{{$course->id}}"><br>
    <input type="submit">

</form>

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const title='title199';
        const VideoURL = $('[name=VideoURL]')[0].files[0];
        const order = 4;
        const IsEnable = 1;
        const IsFree = 1;
        const video_title_id = $('[name=videoTitleId]').val();
        const courseId = $('[name=courseId]').val();
        const time =  23;
        const price = 120000;
        const _token = $('[name=_token]').val();
        const data = new FormData();


        data.append("Title", title);
        data.append('video_title_id',video_title_id);
        //data.append('courseId',courseId);
        data.append('VideoUrl',VideoURL);
        data.append('Order',order);
        data.append('IsEnable',IsEnable);
        data.append('Time',time);
        data.append('Price',price);
        data.append('IsFree',IsFree);
        data.append('_token',_token);


        $.ajax({
            type:"POST",
            url:'/panel/course/'+courseId+'/videoTitle/'+video_title_id+'/video',
            dataType:'JSON',
            data:data,
            processData:false,
            contentType:false
            ,success:result => console.log(result.data),
        });
    });
</script>
