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
<h2>Courses</h2>
@foreach($courses as $child)
    {{$child->id}} => {{$child->pivot->Count}}<br>
    {{$child->Price}}=>{{$child->Discount}}
    <br>
@endforeach

sum:{{computing($courses,'Price') + computing($videos,'Price')}};
sumDiscount:{{computing($courses,'Discount') + computing($videos,'Discount')}};
sumTotal:{{computing($courses,'Price') + computing($videos,'Price')-computing($courses,'Discount') - computing($videos,'Discount')}};
<br>
@php
    $price = computing($courses,'Price') + computing($videos,'Price')-computing($courses,'Discount') - computing($videos,'Discount');
@endphp
total:
<p id="totalPrice">{{$price}}</p>
<h2>Videos</h2>
@foreach($videos as $child)
    {{$child->id}} => {{$child->pivot->Count}}=>{{$child->Price}}=>{{$child->Discount}}
    <br>
@endforeach
<form id="coupon">
    @csrf
    <input type="text" name="coupon">
    <input type="hidden" name="price" value="{{$price}}">
    <input type="submit" value="coupon">
</form>
<br>
<form id="submit">
    @csrf
    <input name="Email" type="email" value="{{$user->Email}}">
    <input name="PhoneNumber" type="text" value="{{$user->PhoneNumber}}">
    <input type="text" value="{{$price}}" name="price">
    <input type="text" value="" name="couponId">
    <button type="submit">ثبت</button>
</form>
</body>
</html>

<script src="/assets/js/jquery.min.js"></script>

<script>
    $( "#coupon" ).submit(function( event ) {
        event.preventDefault();

        const coupon = $("[name=coupon]").val().trim();
        const price = $("[name=price]").val().trim();

        $.ajax({
            type: 'POST',
            url: '/api/coupon',
            datatype: "JSON",
            data: {
                coupon: coupon,
                price: price,
                _token: $('[name=_token]').val()
            }, success: function (result) {
                if(result.status == 1) {
                    $('#totalPrice').text(price - result.data.Amount);
                    $('input[name=price]').val(price - result.data.Amount);
                    alert(result.text);
                }else{
                    alert(result.data);
                }
            }
        });


    });

    $("#submit").submit(function (event){
        event.preventDefault();

        const phoneNumber = $("[name=PhoneNumber]").val().trim();//trim => delete spaces first and End
        const email = $("[name=Email]").val().trim();
        const price = $("[name=price]").val().trim();
        const couponId = $("[name=couponId]").val().trim();



        if(phoneNumber === "")
        {
            alert("Please Enter Phone Number");

            return;
        }
        if(email=== "")
        {
            alert("Please Enter Email");

            return;
        }


        $.ajax({
            type:"POST",
            url:"/api/order/",
            dataType:"JSON",
            data:{
                PhoneNumber : phoneNumber,
                Email:email,
                price:price,
                couponId:couponId,
                _token:$("[name=_token]").val(),
                _method:"PUT"
            },
            success:result => alert(result.text),

        });
    });


</script>
