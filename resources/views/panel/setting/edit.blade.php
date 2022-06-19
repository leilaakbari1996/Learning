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
    <input type="submit" name="create">

</form>

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        const settings = [
            {'SiteTitle' : 'LearningShop'},
            {'SiteDescription' : 'desc1edit'},
            {'SocialMediaLinks' :{
                'Instagram' : '#',
                'facebook' : '#'
            }},
            {'SectionsSite' : {
                'SpecialCourse' : '#',
                'contact' : '#',
            }},
            {'WaysOfCommunication' : {
                'SupportPhone': '1536',
                'Address':'shz',
                'Email': 'info@.com'
            }},
            {'Logo' : {

            }},

        ];

        const _token = $('[name=_token]').val();

        $.ajax({
            type:"POST",
            url:'/panel/setting',
            dataType:'JSON',
            data:{
                settings:JSON.stringify(settings),
                _token:_token,
                _method:'PUT'
            },
            success:result => alert(result.data),
        });
    });
</script>
