<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('site.login') }} / {{ __('site.register') }}</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    /* --- بداية eyad.css --- */
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap");
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
      text-decoration: none;
      list-style: none;
    }
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(90deg, #e2e2e2, #c9d6ff);
    }
    .container {
      position: relative;
      width: 850px;
      height: 550px;
      background: #fff;
      margin: 20px;
      border-radius: 30px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
      overflow: hidden;
    }
    .container h1 {
      font-size: 36px;
      margin: -10px 0;
    }
    .container p {
      font-size: 14.5px;
      margin: 15px 0;
    }
    form {
      width: 100%;
    }
    .form-box {
      position: absolute;
      right: 0;
      width: 50%;
      height: 100%;
      background: #fff;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px;
      padding-top: 10px;
      
      color: #333;
      text-align: center;
      z-index: 3;
      transition: 0.6s ease-in-out 0s;
    }
    /* Positioning on toggle */
    .container.active .form-box.login,
    .container.active .form-box.phone-login {
      right: 50%;
    }
    .form-box.register {
      right: 0;
      visibility: hidden;
    }
    .container.active .form-box.register {
      right: 50%;
      visibility: visible;
    }
    /* Phone-login form hidden by default */
    .form-box.phone-login {
      display: none;
    }
    .container.active .form-box.phone-login {
      display: flex;
    }
    .input-box {
      position: relative;
      width: 100%;
      margin: 30px 0;
    }
    .input-box input {
      width: 100%;
      padding: 13px 50px 13px 20px;
      background: #eee;
      border: none;
      border-radius: 8px;
      outline: none;
      font-size: 16px;
      color: #333;
    }
    .input-box input::placeholder {
      color: #888;
    }
    .input-box i {
      position: absolute;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 20px;
      color: #333;
    }
    .btn {
      width: 100%;
      height: 48px;
      background: #7494ec;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      color: #fff;
      font-weight: 600;
      margin-top: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .social-icons {
      display: flex;
      justify-content: center;
      margin-top: 15px;
    }
    .social-icons a {
      display: inline-flex;
      padding: 10px;
      margin: 0 8px;
      border: 2px solid #ccc;
      border-radius: 8px;
      font-size: 24px;
      color: #333;
    }
    .toggle-box {
      position: absolute;
      width: 100%;
      height: 100%;
    }
    .toggle-box::before {
      content: "";
      position: absolute;
      left: -250%;
      width: 300%;
      height: 100%;
      background: #7494ec;
      border-radius: 150px;
      z-index: 2;
      transition: 1.8s ease-in-out;
      pointer-events: none;
    }
    .container.active .toggle-box::before {
      left: 50%;
    }
    .toggle-panel {
      position: absolute;
      width: 50%;
      height: 100%;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 2;
      transition: 0.6s ease-in-out;
    }
    .toggle-panel.toggle-left {
      left: 0;
      transition-delay: 1.2s;
    }
    .container.active .toggle-panel.toggle-left {
      left: -50%;
      transition-delay: 0.6s;
    }
    .toggle-panel.toggle-right {
      right: -50%;
      transition-delay: 0.6s;
    }
    .container.active .toggle-panel.toggle-right {
      right: 0;
      transition-delay: 1.2s;
    }
    .toggle-panel p {
      margin-bottom: 20px;
    }
    .toggle-panel .btn {
      width: 160px;
      height: 46px;
      background: transparent;
      border: 2px solid #fff;
      box-shadow: none;
    }
    @media screen and (max-width:650px) {
      .container { height: calc(100vh - 40px); }
      .form-box { bottom: 0; width: 100%; height: 70%; }
      .container.active .form-box { right: 0; bottom: 30%; }
      .toggle-box::before {
        left: 0; top: -270%; width: 100%; height: 300%; border-radius: 20vw;
      }
      .container.active .toggle-box::before { left: 0; top: 70%; }
      .toggle-panel { width: 100%; height: 30%; }
      .container.active .toggle-panel.toggle-left {
        left: 0; top: -30%;
      }
      .toggle-panel.toggle-left { top: 0; }
      .toggle-panel.toggle-right { right: 0; bottom: -30%; }
      .container.active .toggle-panel.toggle-right { bottom: 0; }
    }
    @media screen and (max-width:400px) {
      .form-box { padding: 20px; }
      .toggle-panel h1 { font-size: 30px; }
    }
    /* --- نهاية eyad.css --- */
  </style>

  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/9.24.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.24.0/firebase-auth.js"></script>
</head>

<body>
  <div class="container">

    <!-- Login Form -->
    <div class="form-box login">
      <form onsubmit="event.preventDefault(); loginWithEmail();">
        @csrf
        <h1>{{ __('site.login') }}</h1>
        <div class="input-box">
          <input type="email" id="login_email" name="email" placeholder="{{ __('site.email') }}" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="password" id="login_password" name="password" placeholder="{{ __('site.password') }}" required>
          <i class='bx bxs-lock-alt'></i>
        </div>
        <button type="submit" class="btn">{{ __('site.login') }}</button>

        <p>{{ __('site.or_social') }}</p>
        <div class="social-icons">
          <a href="#" onclick="loginWithGoogle()"><i class='bx bxl-google'></i></a>
          <a href="#" onclick="loginWithFacebook()"><i class='bx bxl-facebook'></i></a>
          <!-- زر إظهار نموذج الهاتف -->
          <a href="#" onclick="showPhoneLogin()"><i class='bx bxs-phone'></i></a>
        </div>
      </form>
    </div>

    <!-- Registration Form -->
    <div class="form-box register">
      <form onsubmit="event.preventDefault(); registerWithEmail();">
        @csrf
        <h1>{{ __('site.register') }}</h1>
        <div class="input-box">
          <input type="text" id="register_username" name="name" placeholder="{{ __('site.name') }}" required>
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="email" id="register_email" name="email" placeholder="{{ __('site.email') }}" required>
          <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
          <input type="password" id="register_password" name="password" placeholder="{{ __('site.password') }}" required>
          <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="input-box">
          <input type="password" id="register_password_confirm" name="password_confirmation" placeholder="{{ __('site.password_confirmation') }}" required>
          <i class='bx bxs-lock-alt'></i>
        </div>
        <button type="submit" class="btn">{{ __('site.register') }}</button>

        <p>{{ __('site.or_social') }}</p>
        <div class="social-icons">
          <a href="#" onclick="loginWithGoogle()"><i class='bx bxl-google'></i></a>
          <a href="#" onclick="loginWithFacebook()"><i class='bx bxl-facebook'></i></a>
          <!-- زر إظهار نموذج الهاتف -->
          <a href="#" onclick="showPhoneLogin()"><i class='bx bxs-phone'></i></a>
        </div>
      </form>
    </div>

    <!-- Phone Login Form -->
    <div class="form-box phone-login">
      <h1>تسجيل الدخول برقم الهاتف</h1>
      <div class="input-box">
        <input type="text" id="phone_number" placeholder="رقم الهاتف" required>
        <i class='bx bxs-phone'></i>
      </div>
      <div id="recaptcha-container"></div>
      <button class="btn" onclick="sendOTP()">إرسال الرمز</button>
      <div class="input-box" style="margin-top:20px;">
        <input type="text" id="otp_code" placeholder="أدخل رمز التحقق">
        <i class='bx bxs-check-shield'></i>
      </div>
      <button class="btn" onclick="verifyOTP()">تأكيد الرمز</button>
    </div>

    <!-- Toggle Panels -->
    <div class="toggle-box">
      <div class="toggle-panel toggle-left">
        <h1>{{ __('site.welcome') }}</h1>
        <p>{{ __('site.no_account') }}</p>
        <button type="button" id="toggleRegisterBtn" class="btn register-btn">{{ __('site.register') }}</button>
      </div>
      <div class="toggle-panel toggle-right">
        <h1>{{ __('site.welcome_back') }}</h1>
        <p>{{ __('site.already_have_account') }}</p>
        <button type="button" id="toggleLoginBtn" class="btn login-btn">{{ __('site.login') }}</button>
      </div>
    </div>

  </div>

  <!-- Toggle Logic -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const container = document.querySelector('.container');
      const regBtn = document.getElementById('toggleRegisterBtn');
      const logBtn = document.getElementById('toggleLoginBtn');

      if (window.location.hash === '#register') {
        container.classList.add('active');
      }

      regBtn.addEventListener('click', () => {
        container.classList.add('active');
        showRegister();
      });
      logBtn.addEventListener('click', () => {
        container.classList.remove('active');
        showLogin();
      });
    });
  </script>

  <!-- Firebase Initialization -->
  <script>
    const firebaseConfig = {
      apiKey: "AIzaSyCsy_PL59WigJO7rUw_fjOgqVTuGjdrWio",
      authDomain: "obd-code-hub.firebaseapp.com",
      projectId: "obd-code-hub",
    };
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();
  </script>

  <!-- Auth & Phone Functions -->
  <script>
    async function sendTokenToServer(idToken) {
      const res = await fetch("/api/firebase-auth", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": "Bearer " + idToken
        }
      });
      const data = await res.json();
      if (res.ok) window.location.href = "/";
      else alert(data.message || "فشل التحقق من الخادم");
    }

    function loginWithEmail() {
      const email = document.getElementById("login_email").value;
      const password = document.getElementById("login_password").value;
      auth.signInWithEmailAndPassword(email, password)
        .then(u => u.user.getIdToken())
        .then(sendTokenToServer)
        .catch(e => alert(e.message));
    }

    function registerWithEmail() {
      const username = document.getElementById("register_username").value;
      const email = document.getElementById("register_email").value;
      const password = document.getElementById("register_password").value;
      const confirm = document.getElementById("register_password_confirm").value;
      if (password !== confirm) {
        return alert("كلمة المرور وتأكيدها غير متطابقين");
      }
      auth.createUserWithEmailAndPassword(email, password)
        .then(u => u.user.updateProfile({ displayName: username }).then(() => u.user.getIdToken()))
        .then(sendTokenToServer)
        .catch(e => alert(e.message));
    }

    function loginWithGoogle() {
      const prov = new firebase.auth.GoogleAuthProvider();
      auth.signInWithPopup(prov)
        .then(r => r.user.getIdToken())
        .then(sendTokenToServer)
        .catch(e => alert(e.message));
    }

    function loginWithFacebook() {
      const prov = new firebase.auth.FacebookAuthProvider();
      auth.signInWithPopup(prov)
        .then(r => r.user.getIdToken())
        .then(sendTokenToServer)
        .catch(e => alert(e.message));
    }

    let confirmationResult = null;
    function sendOTP() {
      const num = document.getElementById('phone_number').value;
      const verifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', { size: 'invisible' });
      auth.signInWithPhoneNumber(num, verifier)
        .then(res => { confirmationResult = res; alert("تم إرسال الرمز إلى الهاتف."); })
        .catch(e => alert(e.message));
    }
    function verifyOTP() {
      const code = document.getElementById('otp_code').value;
      if (!confirmationResult) return alert("يجب إرسال الرمز أولاً.");
      confirmationResult.confirm(code)
        .then(r => r.user.getIdToken())
        .then(sendTokenToServer)
        .catch(() => alert("رمز التحقق غير صحيح."));
    }

    function showLogin() {
      const c = document.querySelector('.container');
      c.classList.remove('active');
      document.querySelector('.form-box.login').style.display = 'flex';
      document.querySelector('.form-box.register').style.display = 'none';
      document.querySelector('.form-box.phone-login').style.display = 'none';
    }
    function showRegister() {
      const c = document.querySelector('.container');
      c.classList.add('active');
      document.querySelector('.form-box.login').style.display = 'none';
      document.querySelector('.form-box.register').style.display = 'flex';
      document.querySelector('.form-box.phone-login').style.display = 'none';
    }
    function showPhoneLogin() {
      const c = document.querySelector('.container');
      c.classList.add('active');
      document.querySelector('.form-box.login').style.display = 'none';
      document.querySelector('.form-box.register').style.display = 'none';
      // phone-login يظهر تلقائيًا عبر CSS عند وجود .active
    }
  </script>
</body>

</html>
