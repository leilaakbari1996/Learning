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
<h1>Edit : {{$course->id}}</h1>

<form>
    @csrf
    <input type="text" name="id" value="{{$course->id}}">
    Image:
    <input type="file" name="PreviewImageURl"><br>
    Video :
    <input type="file" name="videos"><br>
    <input type="file" name="videos1"><br>
    Images:
    <input type="file" name="image"><br>
    <input type="file" name="image1"><br>

    <input type="submit">

</form>

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const id = $('[name=id]').val();
        const title='title1edit';
        const description='d1aaa';
        const afterBuyDescription = 'abd1';
        const price = 1000;
        const discount = 20;
        const Type = "Online";
        const order = 4;
        const IsFree = 1;
        const IsSpecial = 1;
        const IsEnable = 1;
        const IsNew = 1;
        const status = 'End';
        const seoTitle = 't1';
        const seoDescription = 'sd1';
        const level = 'Advance';
        const updateDate = '2014/08/17';
        const images1 = $('[name=image]')[0].files[0];
        const images2 = $('[name=image1]')[0].files[0];
        const images = [];
        if(images1 !== undefined){
            images.push(images1);
        }if(images2 !== undefined){
            images.push(images2);
        }
        const relatedCourses = [
            1,3,4
        ];
        const relatedPodcasts = [
            1,2,2
        ];
        const relatedBlogs = [

        ];
        const categories = [2];
        const relatedGuidances = [3];
        const videos1 = $('[name=videos]')[0].files[0];
        const videos2 = $('[name=videos1]')[0].files[0];
        const videos = [];
        if(videos1 !== undefined){
            videos.push(videos1);
        }if(videos2 !== undefined){
            videos.push(videos2);
        }
        const previewImageURL = $('[name=PreviewImageURl]')[0].files[0];
        const FAQ = '{"i1":"i2"}';
        const videoTitles = [
            {'Title':'vtT1','children':['child11','child12gg']},
            {'Title':'vtT2','children':['child21','child22']},
            {'Title':'vtT3','children':['child31','child32']},
        ];
        const _token = $('[name=_token]').val();

        const tags = [
            'Tag13'
        ];

        //const arr2 = [
        //    {title:"Title1", order:1},
        //     {title:"Title2", order:2},
        //    {title:"Title3", order:3},
        // ];

        //  // arr3 = {
        //  "title": 1,
        //   "description" : [1,2,3,4],
        //   "sdasd" : {"tt":"rere"}
        //  }

        const data = new FormData();

        // "این برای آرایه ساده"
        // "map همون حلقست"
        //  "دوست داشتی میتونی از همون for استفاده کنی"

        relatedCourses.map(item => {
            data.append("RelatedCourses[]", item);
        });
        relatedPodcasts.map(item => {
            data.append("RelatedPodcasts[]", item);
        });
        relatedBlogs.map(item => {
            data.append("RelatedBlogs[]", item);
        });
        relatedGuidances.map(item => {
            data.append("RelatedGuidances[]", item);
        });
        images.map(item => {
            data.append('Images[]', item);
        });
        videos.map(item => {
            data.append('Videos[]', item);
        });
        categories.map(item => {
            data.append('Categories[]', item);
        });

        //"این برای زمانیه که توی آرایت جیسون داشته باشی"/////
        tags.map(item => {
            data.append("Tags[]",JSON.stringify(item))
        });


        //for(let i in arr2)
        // {
        //   data.append("Tag[]", JSON.stringify(arr2[i]));
        //  }


        //data.append("Arr", JSON.stringify(arr3));

        // "حله؟"


        data.append("Title", title);
        data.append("AfterBuyDescription", afterBuyDescription);
        data.append("Price", price);
        data.append("Discount", discount);
        data.append("Type", Type);
        data.append('Order',order);
        data.append('IsFree',IsFree);
        data.append('IsSpecial',IsSpecial);
        data.append('IsNew',IsNew);
        data.append('Status',status);
        data.append('SeoTitle',seoTitle);
        data.append('SeoDescription',seoDescription);
        data.append('Level',level);
        data.append('UpdateDate',updateDate);
        data.append('Images',images);
        data.append('PreviewImageURl',previewImageURL);
        data.append('FAQ',FAQ);
        data.append('VideoTitles',JSON.stringify(videoTitles));
        data.append('IsEnable',IsEnable);
        data.append('Description',description);
        data.append('_token',_token);
        data.append('_method','PUT');
        $.ajax({
            type:"POST",
            url:'/panel/course/'+id,
            dataType:'JSON',
            data:data,
            processData:false,
            contentType:false
            ,success:result => alert(result.data),
        });
    });
</script>
