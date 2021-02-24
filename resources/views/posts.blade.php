<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<ul>
    <li>
        <a href="lang/pt">PT</a>
    </li>
    <li>
        <a href="lang/en">EN</a>
    </li>
</ul>

<h6>{{ session()->get('locale') }}</h6>
@foreach($posts as $post)
    <h2>{{ $post->title }}</h2>
    <img src="{{ $post->featured_image }}" alt="">
    <small>{{ $post->summary }}</small>
    <div>
        {!! $post->body !!}
    </div>
@endforeach
</body>
</html>