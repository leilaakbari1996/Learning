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

@foreach($settings as $setting)
    {{$setting['key']}}:
    @if(!is_array($setting['value']))
        {{$setting['value']}}

    @else
        @foreach($setting['value'] as $value)
            {{$value['key']}}=>{{$value['value']}}<br>
            <form id="settingDelete">
                @csrf
                <input type="text" name="keyMain" value="{{$setting['key']}}">
                <input type="text" name="key" value="{{$value['key']}}">
                <input type="submit" value="delete">
            </form><br>
        @endforeach
    @endif


    <br>


    <br>
@endforeach

</body>
</html>

<script src="/assets/js/jquery.min.js"></script>
<script>

    document.querySelector("form").addEventListener("submit",(event) => {
        event.preventDefault();
        /*const settings = [
            {'SiteTitle' : 'Learning'},
            {'SiteDescription' : 'des'},
            {'SocialMediaLinks' :{
                    'Instagram' : '#',
                    'facebook' : '#'
                }},
            {'SeccionsSite' : {
                    'SpecialCourse' : '#',
                    'contact' : '#',
                }},
            {'WaysOfCommunication' : {
                    'SupportPhone': '000',
                    'Address':'shz',
                    'Email': 'info@.com'
                }},
            {'Logo' : {

                }},

        ];*/


        const key = $('[name=key]').val();
        const keyMain = $('[name=keyMain]').val();
        const _token = $('[name=_token]').val();

        $.ajax({
            type:"POST",
            url:'/panel/setting/delete',
            dataType:'JSON',
            data:{
                key:key,
                keyMain:keyMain,
                _token:_token,
                _method:'DELETE'
            },
            success:result => alert(result.data),
        });
    });
</script>
