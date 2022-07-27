<!doctype html>
<link rel="stylesheet" href="/css/styles.css">
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            div.login__background{
                background-color: lightgray;
                height: 100%;
                width: 100%;
                overflow: auto;
            }
            div.form__container{
                align-content: center;
                margin: 35vh auto;
                width: fit-content;
                padding: 2rem;
                border-radius: 0.5rem;
                background-color: white;
            }
            input.form__input{
                display: block;
                margin: 0.5em 0;
            }
            input.form__button{
                display: block;
            }
        </style>
    </head>
    <body>
        <div class="login__background">
            <div class="form__container">
                <form method="POST" action="/login">
                    @csrf
                    <label for="name">Email</label>
                    <input type="email" value="{{ old('email') }}"
                        name="email" id="email" class="form__input" required>
                    <label for="name">Password</label>
                    <input type="password" name="password" id="password" class="form__input" required>
                    
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">Remember me?</label>

                    <button type="submit" class="form__button">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>



