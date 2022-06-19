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
<form id="contact">
    @csrf
    <input type="text" name="name" placeholder="Enter Name"><br>
    <input type="text" name="subject" placeholder="Enter Subject"><br>
    <input type="text" name="phoneNumber" placeholder="Enter Phone Number"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <textarea name="text" placeholder="Enter Text"></textarea>
    <input type="submit" value="send">
</form>
</body>
</html>
<script src="/assets/js/jquery.min.js"></script>

<script>
    $('#contact').submit(function (event){
        event.preventDefault();

        const name = $('[name=name]').val().trim();
        const subject = $('[name=subject]').val().trim();
        const phoneNumber = $('[name=phoneNumber]').val().trim();
        const text = $('[name=text]').val().trim();
        const email=$('[name=email]').val().trim();

        $.ajax({
            type:'POST',
            url:'api/contact',
            datatype:'JSON',
            data:{
                Name:name,
                Subject:subject,
                PhoneNumber:phoneNumber,
                Text:text,
                Email:email,
                _token:$('[name=_token]').val()
            },success:result=>alert(result.data)

        });
    });

</script>
