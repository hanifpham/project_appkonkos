<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Admin - Appkonkos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <style>
        body { overflow-x: hidden; }
        .auth-card { overflow: hidden; }
    </style>
</head>

<body class="auth-body">
    <div class="auth-card" data-aos="fade-up" data-aos-duration="800">
        
        <div class="auth-form-wrap" data-aos="fade-right" data-aos-delay="400" data-aos-duration="1000">
            <h1>Masuk Admin</h1>
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="auth-form-group" data-aos="fade-up" data-aos-delay="600">
                    <label>Email Admin</label>
                    <input type="email" name="email" placeholder="Masukkan Email Anda" required>
                </div>
                <div class="auth-form-group" data-aos="fade-up" data-aos-delay="700">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password Anda" required>
                </div>
                <div class="auth-meta-row" data-aos="fade-up" data-aos-delay="800">
                    <a href="#">Lupa password?</a>
                </div>
                <button type="submit" class="auth-btn-primary" data-aos="fade-up" data-aos-delay="900">Masuk</button>
                <div class="auth-footer" data-aos="fade-up" data-aos-delay="1000">
                    <span>Bukan admin?</span>
                    <a href="{{ route('login.form') }}">Login User</a>
                </div>
            </form>
        </div>

        <div class="auth-visual" 
             style="background-image: url('{{ asset('image/hero.png') }}')"
             data-aos="fade-left" 
             data-aos-delay="200" 
             data-aos-duration="1000">
            <h2>Temukan kos dan kontrakan terbaik</h2>
            <p>Platform Appkonkos siap membantu Anda mendapatkan hunian terbaik dengan cepat, aman, dan nyaman.</p>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,  
            duration: 800,  
            offset: 0      
        });
    </script>
</body>
</html>