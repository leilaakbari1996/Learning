<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Head::GetTitle()}}</title>
    <style>
        ul li{
            display: inline;
            margin: 30px;
        }
    </style>
</head>
<body>
@auth
    <?php $user = auth()->user() ?>
    <a href="{{route('client.user.show',$user)}}">{{$user->FirstName}}</a>
    <form>
        @csrf
        <input type="submit" value="logout">
    </form>
    <a href="{{route('client.cart.index')}}">cart</a>
@else
    <br> <a href="{{route('client.login')}}">login</a>
@endauth
<br>
<a href="{{route('client.contact')}}">ارتباط با ما</a><br>
<a href="{{route('client.course.offline')}}">ثبت نام دوره های حضوری</a>
<h1>Categories</h1>
@foreach($categories as $category)
    <h2><a href="{{route('client.category.show',$category['parent']->Slug)}}">{{$category['parent']->id}}</a></h2>
    @if(count($category['child']) != 0)
        <h6>Children</h6>
        @foreach($category['child'] as $child)
            <a href="{{route('client.category.show',$child->Slug)}}">{{$child->id}}</a><br>
        @endforeach

    @endif
    <hr>
@endforeach

{{show_array_tag('Banners',$banners,'banner')}}
{{show_array('Special Courses',$specialCourses,'course')}}
{{show_array('Special Categories',$specialCategories,'category')}}
{{showByColumn('Free Courses',$specialCategories,$freeCourses)}}
{{showByColumn('New Courses',$specialCategories,$newCourses)}}
{{showByColumn('Most Buys',$specialCategories,$mostSoldCourses)}}
<a href="{{route('client.guidance.index')}}">All Guidance</a>
{{show_array('Guidance Special',$guidancesSpecial,'guidance')}}
<a href="{{route('client.blog.index')}}">All Blog</a>
{{show_array('New Blog',$blogsNew,'blog')}}
<a href="{{route('client.podcast.index')}}">All Podcast</a>
{{show_array('Podcast Special',$podcastsSpecial,'podcast')}}
{{show_array_master('Masters',$masters,'user')}}
<h1>settings</h1>

<!--foreach($settings as $setting)
    <h2>setting['key']}}</h2>
    foreach($setting['values'] as $value)

        <h5><a href="$value['url']}}">value['desc']}}=>$value['title']}}</a></h5>
    endforeach
endforeach
-->




</body>
</html>

<script src="/assets/js/jquery.min.js"></script>

<script>
    document.querySelector('form').addEventListener("submit",(event) => {
        event.preventDefault();


        $.ajax({
            type : 'POST',
            url : '/logout',
            dataType : 'JSON',
            data : {
                _method: 'DELETE',
                _token : $('[name = _token]').val()
            },success:result => console.log(result),
        });
    });

</script>
