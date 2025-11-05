<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	@auth
		<h2>Edit Post</h2>
		<form action="/edit-post/{{ $post->id }}" method="POST">
			@csrf
			@method('PUT')

			@error('title')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<input name="title" type="text" value="{{ $post->title }}">

			@error('body')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<textarea name="body">{{ $post->body }}</textarea>

			<button>Update Post</button>
		</form>
	@endauth
</body>
</html>