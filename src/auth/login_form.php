<h1 class="page-title text-large">LOGIN</h1>
<form action="login.php" method="post" class="form text-small" id="login-form" novalidate>
    <label for="email" class="form__label">Email</label>
    <input type="email" class="form__input text-small" id="email" name="email" placeholder="thegreatest@gmail.com">

    <label for="pass" class="form__label">Password</label>
    <input type="password" class="form__input text-small" id="pass" name="pass" placeholder="nationalSecret">

    <label for="remember" class="form__label">Remember me</label>
    <input type="checkbox" class="form__input form__input--checkbox" name="remember" id="remember">

    <input type="submit" class="form__input form__input--submit text-small" id="submit" name="submit" value="Login">
</form>