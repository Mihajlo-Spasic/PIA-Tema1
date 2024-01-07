<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register Form</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        .login-form, .register-form, .guest-form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            display: none; /* Hide all forms initially */
        }

        .login-form.active, .register-form.active, .guest-form.active {
            display: block; /* Show the active form */
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <button onclick="showForm('login')">Login</button>
            <button onclick="showForm('register')">Register</button>
            <button onclick="showForm('guest')">Guest</button>
        </div>
        
        <form action="login.php" method="post" class="login-form active">
            <label for="loginUsername">Username:</label>
            <input type="text" id="loginUsername" name="username" required><br>

            <label for="loginPassword">Password:</label>
            <input type="password" id="loginPassword" name="password" required><br>

            <input type="submit" value="Login">
            <input type="reset" value="Reset">
        </form>

        <form action="register.php" method="post" class="register-form">
        <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="name">Ime:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="lastname">Prezime:</label>
            <input type="text" id="lastname" name="lastname" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <label>User Type:</label>
            <input type="radio" id="user" name="user_type" value="user" checked>
            <label for="user">Korisnik</label>
            <input type="radio" id="artist" name="user_type" value="artist">
            <label for="artist">Umetnik</label><br>
            <!--Ovde sam dodao za administratora ulogu - Bane -->
            <input type="radio" id="admin" name="user_type" value="admin">
            <label for="admin">Administrator</label>
            <br>

            <input type="submit" value="Register">
            <input type="reset" value="Reset">
        </form>

        <form action="guest.php" method="post" class="guest-form">
            <!-- Guest form content -->
            <input type="submit" value="Enter as Guest">
        </form>
    </div>

    <script>
        function showForm(formType) {
            const loginForm = document.querySelector('.login-form');
            const registerForm = document.querySelector('.register-form');
            const guestForm = document.querySelector('.guest-form');

            loginForm.classList.remove('active');
            registerForm.classList.remove('active');
            guestForm.classList.remove('active');

            if (formType === 'login') {
                loginForm.classList.add('active');
            } else if (formType === 'register') {
                registerForm.classList.add('active');
            } else if (formType === 'guest') {
                guestForm.classList.add('active');
            }
        }
    </script>
</body>
</html>
