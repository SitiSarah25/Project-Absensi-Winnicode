<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ngabsen.in - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #94AEBF;
      position: relative;
      min-height: 100vh;
      overflow-x: hidden;
    }

    .navbar-brand span {
      color: #F6AF45;
    }

    .container-flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px;
      position: relative;
      z-index: 1;
      flex-wrap: wrap;
    }

    .left-panel {
      color: white;
      padding: 40px;
      padding-left: 200px;
      width: 55%;
      box-sizing: border-box;
    }

    .left-panel h4 {
      font-weight: 700;
      color: #F6AF45;
    }

    .left-panel h1 {
      font-weight: 800;
      font-size: 3rem;
      line-height: 1.2;
      margin-bottom: 20px;
    }

    .left-panel p {
      max-width: 400px;
      font-size: 20px;
      line-height: 1.6;
    }

    .right-panel {
      background: white;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 350px;
      transform: translateX(-200px);
      box-sizing: border-box;
    }

    .right-panel h3 {
      text-align: center;
      font-weight: 700;
      margin-bottom: 30px;
    }

    .btn-warning {
      width: 100%;
      font-weight: 600;
      background-color: #F6AF45;
    }

    .form-check-label {
      margin-left: 5px;
    }

    .global-wave {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: 0;
      pointer-events: none;
    }

    svg {
      display: block;
      width: 100%;
      height: 160px;
    }

    @media (max-width: 992px) {
      .container-flex {
        flex-direction: column;
        padding: 30px 20px;
      }

      .left-panel {
        width: 100%;
        padding: 20px;
        padding-left: 0;
        text-align: center;
      }

      .right-panel {
        transform: none;
        margin-top: 30px;
        max-width: 100%;
      }

      .left-panel h1 {
        font-size: 2.2rem;
      }

      .left-panel p {
        font-size: 16px;
        margin: auto;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-light mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" style="color: #142D70;" href="#">
      ngabsen<span>.in</span>
    </a>
  </div>
</nav>

<div class="container-flex">
  <div class="left-panel">
    <h4>Yuk Absen!</h4>
    <h1>Halo, Pejuang<br>Tepat Waktu</h1>
    <p><strong style="color: #142D70;">Tepat waktu</strong> mencerminkan tanggung jawab.
    Silakan lakukan absensi untuk memulai hari kerja Anda.</p>
  </div>

  <div class="right-panel">
    <h3>Masuk</h3>
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" placeholder="Masukkan Email" required value="{{ old('email') }}">
      </div>

      <div class="mb-3 position-relative">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan Password" required>
          <span class="input-group-text bg-white">
            <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
          </span>
        </div>
      </div>

      <button type="submit" class="btn btn-warning">Masuk</button>
    </form>
  </div>
</div>

<div class="global-wave">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
    <path fill="#142D70" fill-opacity="1" d="M0,64L48,90.7C96,117,192,171,288,181.3C384,192,480,160,576,154.7C672,149,768,171,864,192C960,213,1056,235,1152,234.7C1248,235,1344,213,1392,202.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
  </svg>
</div>

<script>
  const toggle = document.getElementById('togglePassword');
  const password = document.getElementById('password');

  toggle.addEventListener('click', function () {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash');
  });
</script>

</body>
</html>
