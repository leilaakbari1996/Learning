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
    <input type="file" name="ImageURL"><br>
    <input type="submit">

</form>

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const title='title1';
        const text='d1aaa';
        const ImageURL = $('[name=ImageURL]')[0].files[0];
        const order = 4;
        const IsNew = 1;
        const IsEnable = 1;
        const seoTitle = 't1';
        const seoDescription = 'sd1';
        const relatedPodcast = [1,2,3];
        const relatedGuidance = [3,4];
        const relatedCourses = [];
        const relatedBlog = [2,3,73];
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
        data.append('_token',_token);


        $.ajax({
            type:"POST",
            url:'/panel/blog',
            dataType:'JSON',
            data:data,
            processData:false,
            contentType:false
            ,success:result => console.log(result.data),
        });
    });
</script>
