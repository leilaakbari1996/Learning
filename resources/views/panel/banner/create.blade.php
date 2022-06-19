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
    <input type="file" name="ImageURL">
    <input type="submit" value="send">
</form>

</body>
</html>
<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const Title='title1';
        const Order = 4;
        const IsEnable = 1;
        const ImageURL = $('[name=ImageURL]')[0].files[0];
        const Link = 'llll';
        const Description = 'kklll';
        const _token = $('[name=_token]').val();

        const data = new FormData();
        data.append("Title", Title);
        data.append('Order',Order);
        data.append('ImageURL',ImageURL);
        data.append('IsEnable',IsEnable);
        data.append('Description',Description);
        data.append('Link',Link);
        data.append('_token',_token);

        $.ajax({
            type:"POST",
            url:'/panel/banner',
            data:data,
            processData:false,
            contentType:false
            ,success:result => alert(result.data),
        });
    });
</script>
