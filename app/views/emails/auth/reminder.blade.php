<!DOCTYPE html>
<html lang="en-US">
	<head>
    <meta charset="utf-8">
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700" rel="stylesheet">
    <style>
      body {
        font-family: "Source Sans Pro", Helvetica, sans-serif;
      }
    </style>
	</head>
	<body>
		<h2>Password Reset</h2>

		<div>
			To reset your password, complete this form: {{ URL::to('/recover/reset', array($token)) }}.
		</div>
	</body>
</html>
