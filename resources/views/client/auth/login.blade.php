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
<form>
    @csrf
    <input type="email" name="email" placeholder="Enter Email"><br>
    <input type="text" name="PhoneNumber" placeholder="Enter Phone Number"><br>
    @if(!empty($url))
        <input type="hidden" value="{{$url}}" name="url">
    @endif
    <button type="submit">Login</button>
</form>
<a href="{{route('client.register.index')}}">Register</a>

</body>
</html>
<script src="/assets/js/jquery.min.js"></script>

<script>
    document.querySelector('form').addEventListener("submit",(event) => {
        event.preventDefault();
        const email = $("[name = email]").val().trim();
        const url = $("[name = url]").val();
        const PhoneNumber = $("[name = PhoneNumber]").val().trim();


        $.ajax({
            type : 'POST',
            url : '/login',
            dataType : 'JSON',
            data : {
                PhoneNumber : PhoneNumber,
                Email : email,
                _token : $('[name = _token]').val()
            },success:result => window.location.replace(url),
        });
    });

</script>
