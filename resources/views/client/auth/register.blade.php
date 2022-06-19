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
    <input type="text" name="phoneNumber" placeholder="Enter Phone Number"><br>
    <input type="text" name="FirstName" placeholder="First Name"><br>
    <input type="text" name="LastName" placeholder="last Name">
    <button type="submit">Register</button>
</form>
</body>
</html>

<script src="/assets/js/jquery.min.js"></script>

<script>
    document.querySelector('form').addEventListener("submit",(event) => {
        event.preventDefault();
        const email = $("[name = email]").val().trim();
        const phoneNumber = $("[name = phoneNumber]").val().trim();
        const LastName = $("[name = LastName]").val().trim();
        const FirstName = $("[name = FirstName]").val().trim();


        $.ajax({
            type : 'POST',
            url : '/register',
            dataType : 'JSON',
            data : {
                PhoneNumber : phoneNumber,
                LastName:LastName,
                FirstName:FirstName,
                Email : email,
                _token : $('[name = _token]').val()
            },success:result => alert('register'),
        });
    });

</script>

