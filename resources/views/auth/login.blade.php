<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Appkonkos</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary: #1967d2;
            --dark: #2f2f2f;
            --muted: #6b7280;
            --radius: 30px;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(150% 120% at 10% 20%, #e8f2ff 0%, #cde0ff 30%, #1158d3 60%, #093880 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            width: min(1100px, 95vw);
            height: 600px;
            background: white;
            border-radius: var(--radius);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            border: none;
        }

        .form-wrap {
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .form-wrap h1 {
            margin: 0;
            text-align: center;
            font-size: 30px;
            font-weight: 700;
        }

        .form-control {
            border: 1px solid #d5d9e2;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 15px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25, 103, 210, 0.18);
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
        }

        .input-group-text {
            background: white;
            border: 1px solid #d5d9e2;
            border-left: none;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            color: var(--muted);
            cursor: pointer;
        }

        .meta-row {
            display: flex;
            justify-content: flex-end;
            font-size: 14px;
            margin: 10px 0;
        }

        .meta-row a {
            color: var(--muted);
            text-decoration: none;
        }

        .btn-primary-custom {
            width: 100%;
            margin-top: 10px;
            border-radius: 12px;
            background: #333;
            color: white;
            padding: 12px 16px;
            font-weight: 700;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: #000;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
        }

        .auth-footer {
            display: flex;
            gap: 6px;
            margin-top: 15px;
            font-size: 14px;
            justify-content: center;
        }

        .auth-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .visual {
            position: relative;
            background: url('{{ asset('image/hero.png') }}') center/cover no-repeat;
            min-height: 520px;
            border-radius: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            padding: 130px 50px;
            color: white;
        }

        .visual::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.45) 100%);
        }

        .visual>* {
            position: relative;
            z-index: 2;
        }

        .ghost-btn {
            align-self: center;
            padding: 12px 28px;
            border-radius: 16px;
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            color: white;
            background: rgba(255, 255, 255, 0.08);
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .ghost-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            color: white;
        }

        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                padding: 16px;
            }

            .card {
                height: auto;
                grid-template-columns: 1fr;
            }

            .visual {
                min-height: 260px;
                padding: 90px 28px 70px;
            }

            .form-wrap {
                padding: 32px 24px 36px;
                gap: 24px;
            }

            .form-wrap h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="form-wrap" data-aos="fade-right" data-aos-delay="400">
            <h1>Masuk</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if (session('error'))
                    <div class="alert alert-danger small">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger small">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-semibold small">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Masukkan Email Anda" required>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold small">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan Password Anda" required>
                        <span class="input-group-text" onclick="togglePassword()">
                            <i class="bi bi-eye-slash" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <div class="meta-row">
                    <a href="#">Lupa password?</a>
                </div>

                <button type="submit" class="btn-primary-custom">Masuk</button>

                <div class="auth-footer">
                    <span>Kamu tidak punya akun?</span>
                    <a href="{{ route('register.form') }}">Daftar</a>
                </div>
            </form>
        </div>

        <div class="visual" data-aos="fade-left" data-aos-delay="200">
            <div>
                <h2 class="fw-bold">Halo, Pencari Koskon Baru!</h2>
                <p>Daftarkan diri anda untuk mengakses layanan booking kosan dan kontrakan dengan mudah.</p>
            </div>
            <a class="ghost-btn" href="{{ route('register.form') }}">Daftar</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        if (window.AOS) {
            AOS.init({ once: true, duration: 800 });
        }

        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
            else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            }
        }

        @if (session('success'))
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        @endif
        @if (session('error'))
            if (window.Swal) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: '{{ session('error') }}',
                    showConfirmButton: true
                });
            }
        @endif
    </script>
</body>

</html>