<ul>
    <li><a href="{{route('panel.course.create')}}">تعریف دوره</a></li>
    <li><a href="{{route('panel.course.index')}}">list course</a></li>
    <li><a href="{{route('panel.coursesCategory.create')}}">Course Category</a></li>
    <li><a href="{{route('panel.coursesCategory.index')}}">list category courses</a></li>
    <li><a href="{{route('panel.banner.create')}}">تعریف بنر</a></li>
    <li><a href="{{route('panel.banner.index')}}">لیست بنر</a></li>
    <li><a href="{{route('panel.blogCategory.create')}}">تعریف category blog</a></li>
    <li><a href="{{route('panel.blogCategory.index')}}">List category blog</a></li>
    <li><a href="{{route('panel.blog.create')}}"> blog</a></li>
    <li><a href="{{route('panel.blog.index')}}">list blog</a></li>
    <li><a href="{{route('panel.tag.create')}}">tag</a></li>
    <li><a href="{{route('panel.tag.index')}}">list tag</a></li>
    <li><a href="{{route('panel.podcast.create')}}">podcast</a></li>
    <li><a href="{{route('panel.podcast.index')}}">List podcast</a></li>
    <li><a href="{{route('panel.guidance.create')}}">guidance</a></li>
    <li><a href="{{route('panel.guidance.index')}}">list guidance</a></li>
    <!--<li><a href="/panel/video">video</a></li>-->
    <li><a href="{{route('panel.comment.index')}}">Comments</a><span style="background: red;margin: 10px;padding: 6px">{{$countComments}}</span></li>
    <li><a href="{{route('panel.admin.index')}}">list admins</a></li>
    <li><a href="{{route('panel.master.index')}}">list master</a></li>
    <li><a href="{{route('panel.user.index')}}">user</a></li>
    <li><a href="{{route('panel.coupon.create')}}">create Coupon</a></li>
    <li><a href="{{route('panel.coupon.index')}}">List Coupon</a></li>
    <li><a href="{{route('panel.setting.index')}}">List settings</a></li>
    <li><a href="{{route('panel.setting.edit')}}">edit settings</a></li>
    <li><a href="{{route('panel.contact.index')}}">list contact</a><span style="background: red;margin: 10px;padding: 6px">{{$countContacts}}</span></li>

</ul>
