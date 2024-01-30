<h1 class="page-title text-large">REGISTER</h1>
<form action="register.php" method="post" class="form text-small" id="register-form" novalidate>
    <label for="firstname" class="form__label">First Name</label>
    <input type="text" class="form__input text-small" id="firstname" name="firstname" placeholder="The">

    <label for="lastname" class="form__label">Last Name</label>
    <input type="text" class="form__input text-small" id="lastname" name="lastname" placeholder="Greatest">

    <label for="email" class="form__label">Email</label>
    <input type="email" class="form__input text-small" id="email" name="email" placeholder="thegreatest@gmail.com">

    <label for="pass" class="form__label">Password</label>
    <input type="password" class="form__input text-small" id="pass" name="pass" placeholder="nationalSecret">

    <label for="confirm" class="form__label">Confirm Password</label>
    <input type="password" class="form__input text-small" id="confirm" name="confirm" placeholder="nationalSecret">
    <br>

    <input type="submit" class="form__input form__input--submit text-small" id="submit" name="submit" value="Register">
</form>