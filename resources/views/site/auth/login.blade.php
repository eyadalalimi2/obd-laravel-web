<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تسجيل الدخول / إنشاء حساب</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Cairo', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(90deg, #f0f2f5, #e0e7ff);
    }

    .container {
      width: 900px;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      display: flex;
      overflow: hidden;
    }

    .form-box {
      flex: 1;
      padding: 40px;
      display: none;
      flex-direction: column;
      justify-content: center;
    }

    .form-box.active {
      display: flex;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #2c3e50;
    }

    .input-box {
      position: relative;
      margin-bottom: 20px;
    }

    .input-box input {
      width: 100%;
      padding: 14px 45px 14px 14px;
      border-radius: 8px;
      border: 1px solid #ccc;
      font-size: 15px;
    }

    .input-box i {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #999;
    }

    .btn {
      padding: 12px;
      width: 100%;
      border: none;
      background: #3b4cca;
      color: white;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 15px;
    }

    .social-icons a {
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 8px;
      font-size: 22px;
      color: #3b4cca;
    }

    .toggle-buttons {
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #3b4cca;
      color: white;
      padding: 40px;
    }

    .toggle-buttons button {
      background: transparent;
      border: 2px solid white;
      padding: 12px;
      margin-top: 15px;
      color: white;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }

    #otp-form {
      display: none;
    }
  </style>

  <!-- Firebase -->
  <script src="https://www.gstatic.com/firebasejs/9.24.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.24.0/firebase-auth.js"></script>
</head>
<body>
  <div class="container">
    <!-- النموذج الجانبي -->
    <div class="toggle-buttons">
      <h2>مرحبًا بك 👋</h2>
      <p>اختر نوع التسجيل أو تسجيل الدخول</p>
      <button onclick="showForm('login')">تسجيل دخول</button>
      <button onclick="showForm('register')">إنشاء حساب</button>
      <button onclick="showForm('phone')">تسجيل عبر الهاتف</button>
    </div>

    <!-- نموذج تسجيل الدخول -->
    <div class="form-box" id="login-form">
      <form onsubmit="event.preventDefault(); loginWithEmail();">
        <h1>تسجيل الدخول</h1>
        <div class="input-box">
          <input type="email" id="login_email" placeholder="البريد الإلكتروني" required />
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
          <input type="password" id="login_password" placeholder="كلمة المرور" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
        <button type="submit" class="btn">تسجيل الدخول</button>
        <div class="social-icons">
          <a href="#" onclick="loginWithGoogle()"><i class='bx bxl-google'></i></a>
          <a href="#" onclick="loginWithFacebook()"><i class='bx bxl-facebook'></i></a>
        </div>
      </form>
    </div>

    <!-- نموذج التسجيل -->
    <div class="form-box" id="register-form">
      <form onsubmit="event.preventDefault(); registerWithEmail();">
        <h1>إنشاء حساب</h1>
        <div class="input-box">
          <input type="text" id="register_username" placeholder="الاسم الكامل" required />
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
          <input type="email" id="register_email" placeholder="البريد الإلكتروني" required />
          <i class="bx bxs-envelope"></i>
        </div>
        <div class="input-box">
          <input type="password" id="register_password" placeholder="كلمة المرور" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
        <div class="input-box">
          <input type="password" id="register_password_confirm" placeholder="تأكيد كلمة المرور" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
        <button type="submit" class="btn">تسجيل</button>
        <div class="social-icons">
          <a href="#" onclick="loginWithGoogle()"><i class='bx bxl-google'></i></a>
          <a href="#" onclick="loginWithFacebook()"><i class='bx bxl-facebook'></i></a>
        </div>
      </form>
    </div>

    <!-- نموذج الهاتف -->
    <div class="form-box" id="phone-form">
      <form onsubmit="event.preventDefault(); loginWithPhone();">
        <h1>تسجيل برقم الهاتف</h1>
        <div class="input-box">
          <input type="tel" id="phone_number" placeholder="رقم الهاتف بصيغة دولية" required />
          <i class="bx bx-phone"></i>
        </div>
        <div id="recaptcha-container"></div>
        <button type="submit" class="btn">إرسال الرمز</button>
      </form>

      <form id="otp-form" onsubmit="event.preventDefault(); verifyOTP();">
        <div class="input-box">
          <input type="text" id="otp_code" placeholder="رمز التحقق" required />
          <i class="bx bx-check-shield"></i>
        </div>
        <button type="submit" class="btn">تأكيد الرمز</button>
      </form>
    </div>
  </div>

  <script>
    const firebaseConfig = {
      apiKey: "AIzaSyCsy_PL59WigJO7rUw_fjOgqVTuGjdrWio",
      authDomain: "obd-code-hub.firebaseapp.com",
      projectId: "obd-code-hub"
    };
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();
  </script>

  <script>
    let confirmationResult = null;

    function showForm(form) {
      document.querySelectorAll('.form-box').forEach(f => f.classList.remove('active'));
      document.getElementById(`${form}-form`).classList.add('active');
    }

    function sendTokenToServer(idToken) {
      return fetch("/api/firebase-auth", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": "Bearer " + idToken
        }
      }).then(res => res.json())
        .then(data => {
          if (data.user) {
            window.location.href = "/";
          } else {
            alert("فشل التحقق");
          }
        });
    }

    function loginWithEmail() {
      const email = document.getElementById("login_email").value;
      const password = document.getElementById("login_password").value;
      auth.signInWithEmailAndPassword(email, password)
        .then(userCredential => userCredential.user.getIdToken())
        .then(sendTokenToServer)
        .catch(err => alert(err.message));
    }

    function registerWithEmail() {
      const username = document.getElementById("register_username").value;
      const email = document.getElementById("register_email").value;
      const password = document.getElementById("register_password").value;
      const confirm = document.getElementById("register_password_confirm").value;

      if (password !== confirm) return alert("كلمة المرور غير متطابقة");

      auth.createUserWithEmailAndPassword(email, password)
        .then(userCredential =>
          userCredential.user.updateProfile({ displayName: username })
            .then(() => userCredential.user.getIdToken())
        )
        .then(sendTokenToServer)
        .catch(err => alert(err.message));
    }

    function loginWithGoogle() {
      const provider = new firebase.auth.GoogleAuthProvider();
      auth.signInWithPopup(provider)
        .then(result => result.user.getIdToken())
        .then(sendTokenToServer)
        .catch(err => alert(err.message));
    }

    function loginWithFacebook() {
      const provider = new firebase.auth.FacebookAuthProvider();
      auth.signInWithPopup(provider)
        .then(result => result.user.getIdToken())
        .then(sendTokenToServer)
        .catch(err => alert(err.message));
    }

    function loginWithPhone() {
      const phoneNumber = document.getElementById("phone_number").value;
      const appVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        size: 'invisible'
      });

      auth.signInWithPhoneNumber(phoneNumber, appVerifier)
        .then(result => {
          confirmationResult = result;
          document.getElementById('otp-form').style.display = 'block';
        })
        .catch(err => alert(err.message));
    }

    function verifyOTP() {
      const code = document.getElementById("otp_code").value;
      confirmationResult.confirm(code)
        .then(result => result.user.getIdToken())
        .then(sendTokenToServer)
        .catch(err => alert(err.message));
    }

    // افتراضي: فتح نموذج تسجيل الدخول
    showForm('login');
  </script>
</body>
</html>
