@php
	$title = 'Original Title';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible"
		content="ie=edge">

	@vite('resources/js/app.js')
	<title>Card Example</title>
</head>

<body>
	<div class="card-example">
		<h1>Card Example</h1>

		<div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
			<input id="title-input"
				type="text" />

			<button id="change-title"
				onclick="changeTitle()">Change Title</button>
		</div>

		<my-card title="{{ $title }}">
			Nulla ea eu consectetur ad adipisicing laborum laboris dolore dolor eu incididunt.
		</my-card>
	</div>
</body>
<style>
	.card-example {
		margin: 2rem;
	}
</style>

<script>
	function changeTitle() {
		const title = document.getElementById("title-input").value;
		const card = document.querySelector("my-card");
		card.title = title;
	}
</script>

</html>
