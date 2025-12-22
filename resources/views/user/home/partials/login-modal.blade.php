<div id="loginModal" class="login-modal-overlay">
    <div class="login-modal">
        <button class="modal-close" aria-label="Close" data-close-modal>&times;</button>
        <div class="login-modal-body">
            <p class="modal-label">Masuk ke Appkonkos</p>
            <h3>Pilih jenis akun untuk melanjutkan</h3>
            <div class="role-grid">
                <a href="{{ route('login.form') }}" class="role-card">
                    <div class="role-icon">
                        <i class="bi bi-person-heart"></i>
                    </div>
                    <div>
                        <strong>Pencari Kos & Kontrakan</strong>
                        <p>Masuk untuk menemukan kos & kontrakan</p>
                    </div>
                </a>

                <a href="{{ route('admin.login.form') }}" class="role-card">
                    <div class="role-icon admin">
                        <i class="bi bi-building-lock"></i>
                    </div>
                    <div>
                        <strong>Admin Kos & Kontrakan</strong>
                        <p>Kelola listing kosan & kontrakan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>