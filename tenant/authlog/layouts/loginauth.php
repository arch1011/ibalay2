<div class="wrapper">
  <div class="title-text">
    <div class="title login">Welcome Back!</div>
    <div class="title signup">Signup Form</div>
  </div>
  <div class="form-container">
    <div class="slide-controls">
      <input type="radio" name="slide" id="login" checked>
      <input type="radio" name="slide" id="signup">
      <label for="login" class="slide login">Login</label>
      <label for="signup" class="slide signup">Signup</label>
      <div class="slider-tab"></div>
    </div>
    <div class="form-inner">
  <form id="loginForm" class="login">
    <div class="field">
      <input type="text" placeholder="Email Address" required name="email">
    </div>
    <div class="field">
      <input type="password" placeholder="Password" required name="password">
    </div>
    <div class="error-message" id="loginError"></div>
    <div class="pass-link"><a href="#">Forgot password?</a></div>
    <div class="field btn">
      <div class="btn-layer"></div>
      <input type="submit" value="Login">
    </div>
    <div class="signup-link">Not a member? <a href="#signup">Signup now</a></div>
  </form>
      <form action="tasks/register_process.php" method="POST" class="signup">
        <div class="field">
          <input type="text" name="FirstName" placeholder="First Name" required>
        </div>
        <div class="field">
          <input type="text" name="LastName" placeholder="Last Name" required>
        </div>
        <div class="field">
          <input type="email" name="Email" placeholder="Email Address" required>
        </div>
        <div class="field">
          <input type="text" name="PhoneNumber" placeholder="Phone Number" required>
        </div>
        <div class="field">
          <input type="password" name="Password" placeholder="Password" required>
        </div>
        <div class="field">
          <input type="text" name="student_id" placeholder="Student ID Number" required>
        </div>
        <div class="field">
          <input type="text" name="address" placeholder="Address" required>
        </div>
        <div class="field">
          <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="field btn">
          <div class="btn-layer"></div>
          <input type="submit" value="Signup">
        </div>
      </form>
    </div>
  </div>
</div>

