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
    <input type="submit" value="send">
</form>
</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const title='title1';
        const order = 4;
        const IsSpecial = 1;
        const videoTitles = [
            {'Title':'vtT1','children':["child11","child12"]},
            {'Title':'vtT2','children':["child21","child22"]},
            {'Title':'vtT3','children':["child31","child32"]},
        ];
        $.ajax({
            type:"POST",
            url:'/panel/course',
            dataType:'JSON',
            data:{
                Title :title,
                Description:description,
                AfterBuyDescription :afterBuyDescription,
                Price : price,
                Discount : discount,
                Type:Type,
                Order:order,
                IsFree:IsFree,
                IsSpecial:IsSpecial,
                IsNew:IsNew,
                Status:status,
                SeoTitle:seoTitle,
                SeoDescription:seoDescription,
                Level:level,
                FAQ:FAQ,
                Images:images,
                Videos:videos,
                PreviewImageURL:previewImageURL,
                VideoTitles :videoTitles,
                UpdateDate : updateDate,
                _token:$('[name=_token]').val(),
            },success:result => console.log(result.data),
        });
    });
</script>
