<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - Apkonkos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1967d2;
            --dark: #2f2f2f;
            --muted: #6b7280;
            --radius: 30px;
        }

        * {
            box-sizing: border-box;
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
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .visual {
            position: relative;
            background: url('{{ asset('image/hero.png') }}') center/cover no-repeat;
            min-height: 520px;
            border-radius: 0 50px 50px 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            padding: 130px 50px;
            color: white;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .visual::after {
            content: "";
            position: absolute;
            border-radius: 0 50px 50px 0;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.55) 0%, rgba(0, 0, 0, 0.45) 100%);
        }

        .visual>* {
            position: relative;
            z-index: 2;
        }

        .visual h2 {
            margin: 0 0 14px;
            font-size: clamp(26px, 4vw, 34px);
            font-weight: 700;
            line-height: 1.2;
        }

        .visual p {
            margin: 0;
            max-width: 440px;
            color: rgba(255, 255, 255, 0.9);
        }

        .ghost-btn {
            align-self: center;
            margin-top: auto;
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
        }

        .form-wrap {
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-wrap h1 {
            margin: 0;
            text-align: center;
            font-size: 30px;
            font-weight: 700;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-top: 8px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input {
            border: 1px solid #d5d9e2;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 15px;
            outline: none;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        .form-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(25, 103, 210, 0.18);
        }

        .btn-primary {
            width: 100%;
            margin-top: 20px;
            border-radius: 12px;
            background: #333;
            color: white;
            padding: 12px 16px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 5px 0;
            gap: 12px;
            color: var(--muted);
            font-weight: 600;
            font-size: 14px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .social-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
        }

        .social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid #dfe3eac8;
            padding: 10px 12px;
            border-radius: 12px;
            background: #fff;
            font-weight: 600;
            color: var(--dark);
            cursor: pointer;
            transition: box-shadow 0.2s ease;
        }

        .social-btn:hover {
            box-shadow: 0 8px 18px rgba(25, 103, 210, 0.3);
        }

        .form-alert {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13px;
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
                border-radius: 20px 20px 0 0;
            }

            .visual::after {
                border-radius: 20px 20px 0 0;
            }

            .form-wrap {
                padding: 32px 24px 36px;
                gap: 14px;
            }

            .form-wrap h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="visual" id="visual-panel">
            <div>
                <h2>Selamat Datang Kembali!</h2>
                <p>Silahkan masuk untuk mengakses layanan booking kosan dan kontrakan dengan mudah.</p>
            </div>
            <a class="ghost-btn" href="{{ route('login.form') }}" id="to-login">Masuk</a>
        </div>
        <div class="form-wrap">
            <h1>Daftar</h1>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                @if (session('error'))
                    <div class="form-alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="form-alert">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan Nama Lengkap Anda" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Masukkan Email Anda" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password Anda" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi Password" required>
                </div>
                <button type="submit" class="btn-primary">Daftar</button>
            </form>
            <div class="divider">atau</div>
            <div class="social-row">
                <button type="button" class="social-btn" id="google-auth-btn">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/google/google-original.svg"
                        alt="Google" width="18" height="18">
                    Google
                </button>
                <button type="button" class="social-btn" id="facebook-auth-btn">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/facebook/facebook-original.svg"
                        alt="Facebook" width="18" height="18">
                    Facebook
                </button>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-app.js";
    import { getAuth, GoogleAuthProvider, FacebookAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/10.13.1/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "AIzaSyC1Nu7XdaU2hCGdFVy2kr8cEKqTgJTHcW8",
        authDomain: "appkonkos.firebaseapp.com",
        projectId: "appkonkos",
        storageBucket: "appkonkos.firebasestorage.app",
        messagingSenderId: "91985835670",
        appId: "1:91985835670:web:dcf54d4f24f707e58bb4b7"
    };

    const googleBtn = document.getElementById('google-auth-btn');
    const facebookBtn = document.getElementById('facebook-auth-btn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const notify = (options) => {
        if (window.Swal) {
            return Swal.fire(options);
        }

        alert(options.text || options.title || 'Terjadi kesalahan');
    };

    const attachLogin = (button, providerFactory) => {
        if (!button) return;
        button.addEventListener('click', async () => {
            try {
                if (!firebaseConfig.apiKey || !firebaseConfig.authDomain) {
                    throw new Error('Firebase belum dikonfigurasi. Lengkapi kredensial di file environment.');
                }

                const app = initializeApp(firebaseConfig);
                const auth = getAuth(app);
                const provider = providerFactory();

                const result = await signInWithPopup(auth, provider);
                const idToken = await result.user.getIdToken();

                const response = await fetch("{{ route('auth.firebase.login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({ token: idToken }),
                });

                const data = await response.json();
                const redirectUrl = data.redirect || "{{ route('home') }}";
                if (response.ok && data.status === 'success') {
                    notify({
                        icon: 'success',
                        title: 'Berhasil login',
                        showConfirmButton: false,
                        timer: 1200,
                    });
                    setTimeout(() => window.location.href = redirectUrl, 900);
                    return;
                }

                throw new Error(data.message || 'Login gagal, coba lagi.');
            } catch (error) {
                console.error('Firebase login error:', error);
                notify({
                    icon: 'error',
                    title: 'Login gagal',
                    text: error.message || 'Terjadi kesalahan saat login.',
                });
            }
        });
    };

    attachLogin(googleBtn, () => new GoogleAuthProvider());
    attachLogin(facebookBtn, () => new FacebookAuthProvider());
</script>

<!-- Script untuk SweetAlert dari session -->
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        })
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        })
    @endif
</script>

</html>
