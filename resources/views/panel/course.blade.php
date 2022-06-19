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
    Title : <input type="text" name="title"><br>
    Description : <textarea name="description"></textarea><br>
    AfterBuysDescription : <input type="text" name="afterBuyDescription"><br>
    price: <input type="text" name="price"><br>
    discount: <input type="number" name="discount">
    Type : Online:<input type="radio" name="type" value="Online">  offline : <input type="radio" name="type" value="Offline">
    <br>
    order: <input type="number" name="order"><br>
    tataltime : <input type="number" name="totalTime"><br>
    IsFree : Free : <input type="radio" name="isFree" value="true"> notFree <input type="radio" name="isFree" value="false"><br>
    Isnew : New : <input type="radio" name="isNew" value="true"> notFree <input type="radio" name="isNew" value="false"><br>
    level : Beginner : <input type="radio" name="level" value="Beginner"> Intermediate <input type="radio" name="level" value="Intermediate">
    Advance<input type="radio" name="level" value="Advance"> BegToAvdance <input type="radio" name="level" value="BegToAvdance">
    <br>
    Status : End<input type="radio" name="status" value="End">Beginning <input type="radio" name="status" value="Beginning">
    During<input type="radio" name="status" value="During"><br>
    updateDate : <input type="date" name="updateDate"><br>
    Seo Title : <input type="text" name="seoTitle"><br>
    Seo Description : <input type="text" name="seoDescription">
    <input type="submit" value="send">
</form>

</body>
</html>
