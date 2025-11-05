<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>

	@auth

	@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
	@endif
	<form action="/logout" method="POST">
		@csrf
		<button>Logout</button>
	</form>

	<div style="border: 3px solid black;">
		<h2>Create a Post</h2>
		<form action="/create-post" method="POST">	
			@csrf
			
			@error('title')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<input name="title" type="text" placeholder="Post Title">

			@error('body')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<textarea name="body" placeholder="Post Body..."></textarea>

			<button>Create Post</button>
		</form>
	</div>
	@if (session('successPost'))
    <div class="alert alert-success">
        {{ session('successPost') }}
    </div>
	@endif

	<div style="border: 3px solid black;">
		<h2>All Posts</h2>
		@foreach ($posts as $post)
			<div style="background-color: gray; margin: 10px; padding: 5px 10px 5px 20px;">
				<h3>{{ $post->title }} by {{$post->user->name}} </h3>
				<p>{{ $post->body }}</p>
				<p><a href="/edit-post/{{$post->id}}">Edit</a></p>
				{{-- delete a post --}}
				<form action="/delete-post/{{$post->id}}" method="POST">
					@csrf
					@method('DELETE')
					<button>Delete</button>
				</form>
			</div>
		@endforeach
	</div>

	@else

	<div style="border: 3px solid black;">
		<h2>Register</h2>
		<form action="/register" method="POST">
			@csrf

			@error('name')
				<div class="text-danger">{{ $message }}</div>
				@enderror
			<input name="name" type="text" placeholder="name">

			@error('email')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<input name="email" type="text" placeholder="email">

			@error('password')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<input name="password" type="password" placeholder="password">

			<button>Register</button>
		</form>
	</div>

	@error('failledLogin')
		<div class="text-danger">{{ $message }}</div>
	@enderror
	<div style="border: 3px solid black;">
		<h2>Login</h2>
		<form action="/login" method="POST">
			@csrf

			@error('loginname')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<input name="loginname" type="text" placeholder="name">

			@error('loginpassword')
				<div class="text-danger">{{ $message }}</div>
			@enderror
			<input name="loginpassword" type="password" placeholder="password">

			<button>Login</button>
		</form>
	</div>

	@endauth

</body>
</html>