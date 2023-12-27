<h1 class="form-title text-large">REGISTER</h1>
<form action="register.php" method="post" class="form text-small" id="register-form" novalidate>
    <label for="firstname">First Name</label>
    <input type="text" class="text-small" id="firstname" name="firstname" placeholder="The">

    <label for="lastname">Last Name</label>
    <input type="text" class="text-small" id="lastname" name="lastname" placeholder="Greatest">

    <label for="email">Email</label>
    <input type="email" class="text-small" id="email" name="email" placeholder="thegreatest@gmail.com">

    <label for="pass">Password</label>
    <input type="password" class="text-small" id="pass" name="pass" placeholder="nationalSecret">

    <label for="confirm">Confirm Password</label>
    <input type="password" class="text-small" id="confirm" name="confirm" placeholder="nationalSecret">
    <br>

    <input type="submit" class="text-small" id="submit" name="submit" value="Register">
</form>