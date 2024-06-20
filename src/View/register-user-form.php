<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register user</title>
	<link rel="stylesheet" href="src/View/styles/register-style.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="form">
	<h1 class="form__title">Registration</h1>
	<form action="/user/registration" method="post" enctype="multipart/form-data">
		<div class="form-group first-name">
			<label for="first_name">First name:</label>
			<input name="first_name" id="first_name" type="text">
		</div>
		<div class="form-group">
			<label for="last_name">Last name:</label>
			<input name="last_name" id="last_name" type="text">
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input name="email" id="email" type="text">
		</div>
		<div class="form-group">
			<label for="phone">Phone:</label>
			<input name="phone" id="phone" type="text">
		</div>
		<div class="form-group">
			<label for="avatar_path">Avatar:</label>
			<input name="avatar_path" id="avatar_path" type="file" accept="image/png, image/jpeg, image/gif"/>
		</div>
		<button class="btn btn-primary" type="submit">Submit</button>
	</form>
	<form action="/show_users_list.php">
		<button class="btn btn-primary" type="submit">Show Users List</button>
	</form>
</div>
</body>
