<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
    <link rel="stylesheet" href="Style.css">
    <style type="text/css">
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: aquamarine;
            color: hotpink;
        }
    </style>
</head>
<body>
	<form action="register.php" method="post" class="register-form">
        <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="name">Ime:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="lastname">Prezime:</label>
            <input type="text" id="lastname" name="lastname" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <input type="hidden" id="artist" name="user_type" value="artist" checeked>
 
            <!--Ovde sam dodao za administratora ulogu - Bane -->
            
            <br>

            <input type="submit" value="Register">
            <input type="reset" value="Reset">
    </form>
</body>
</html>