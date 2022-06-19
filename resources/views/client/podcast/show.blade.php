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
{{show_array('Tags',$tags,'tag')}}
{{show_array('Related Podcast',$relatedPodcast,'podcast')}}
{{show_array('Related Blog',$relatedBlog,'blog')}}
{{show_array('Related Guidance',$relatedGuidance,'guidance')}}

<h1>Comments</h1>
{{show_separate_parent_child($comments,'#')}}
{{show_array('Related Courses',$relatedCourse,'course')}}

</body>
</html>
