

<!DOCTYPE html>
<html>
<head>
	<title>How to Design Login & Registration Form Transition</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="cont">
    <form action="doSignin.php" method="post">
      <div class="form sign-in">
        <h2>Sign In</h2>
        <label for="email">
          <span>Email Address</span>
          <input type="email" name="email">
        </label>
        <label for="password">
          <span>Password</span>
          <input type="password" name="password">
        </label>
        <button class="submit" type="submit">Sign In</button>
        
        <p class="forgot-pass">Forgot Password ?</p>
        <div class="social-media">
          <ul>
            <li><img src="images/facebook.png"></li>
            <li><img src="images/twitter.png"></li>
            <li><img src="images/linkedin.png"></li>
            <li><img src="images/instagram.png"></li>
          </ul>
        </div>
      </div>
    </form>
    <form action="doSignin.php" method="post">
      <div class="form sign-in">
        <h2>Sign In</h2>
        <label for="email">
          <span>Email Address</span>
          <input type="email" name="email">
        </label>
        <label for="password">
          <span>Password</span>
          <input type="password" name="password">
        </label>
        <button class="submit" type="submit">Sign In</button>
        
        <p class="forgot-pass">Forgot Password ?</p>
        <div class="social-media">
          <ul>
            <li><img src="images/facebook.png"></li>
            <li><img src="images/twitter.png"></li>
            <li><img src="images/linkedin.png"></li>
            <li><img src="images/instagram.png"></li>
          </ul>
        </div>
      </div>
    </form>
    <form action="doSignin.php" method="post">
      <div class="form sign-in">
        <h2>Sign In</h2>
        <label for="email">
          <span>Email Address</span>
          <input type="email" name="email">
        </label>
        <label for="password">
          <span>Password</span>
          <input type="password" name="password">
        </label>
        <button class="submit" type="submit">Sign In</button>
        
        <p class="forgot-pass">Forgot Password ?</p>
        <div class="social-media">
          <ul>
            <li><img src="images/facebook.png"></li>
            <li><img src="images/twitter.png"></li>
            <li><img src="images/linkedin.png"></li>
            <li><img src="images/instagram.png"></li>
          </ul>
        </div>
      </div>
    </form>

    <div class="sub-cont">
      <div class="img">
        <div class="img-text m-up">
          <h2>New here?</h2>
          <p>Sign up and discover great amount of new opportunities!</p>
        </div>
        <div class="img-text m-in">
          <h2>One of us?</h2>
          <p>If you already has an account, just sign in. We've missed you!</p>
        </div>
        <div class="img-btn">
          <span class="m-up">Sign Up</span>
          <span class="m-in">Sign In</span>
        </div>
      </div>
      <form action="doSignup.php" method="post">
        <div class="form sign-up">
          <h2>Sign Up</h2>
          <label for="account">
            <span>Account</span>
            <input type="name" class="form-control" name="account">
          </label>
          <label for="email">
            <span>Email</span>
            <input type="email" class="form-control" name="email">
          </label>
          <label for="password">
            <span>Password</span>
            <input type="password" class="form-control" name="password">
          </label>
          <label for="repassword">
            <span>Confirm Password</span>
            <input type="password" class="form-control" name="repassword">
          </label>
          <label for="valid">
            <!-- <span>Confirm Password</span> -->
            <input type="valid" class="form-control" name="valid" value="1" style="display:none;">
          </label>
          <button type="submit" class="submit">Sign Up Now</button>
        </div>
      </form>
    </div>
  </div>
<script type="text/javascript" src="script.js"></script>
</body>
</html>