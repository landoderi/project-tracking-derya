<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracking - Kelola Keuanganmu Lebih Cerdas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root { --primary-color: #696cff; --secondary-color: #f5f5f9; --navy: #233446; }
        body { font-family: 'Public Sans', sans-serif; overflow-x: hidden; }
        .hero-section { padding: 100px 0; background: linear-gradient(135deg, #fff 0%, #e7e7ff 100%); }
        .btn-primary { background-color: var(--primary-color); border: none; padding: 12px 30px; border-radius: 8px; }
        .feature-card { border: none; transition: 0.3s; border-radius: 15px; }
        .feature-card:hover { transform: translateY(-10px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .icon-box { width: 60px; height: 60px; background: #e7e7ff; color: var(--primary-color); display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 30px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#"><i class='bx bx-analyse'></i> tracking</a>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary shadow">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4" style="color: var(--navy);">Satu Aplikasi untuk <span class="text-primary">Pantau Semua</span> Keuangan.</h1>
                    <p class="lead text-muted mb-5">Berhenti menebak ke mana uangmu pergi. Catat, analisis, dan rencanakan masa depan finansialmu dengan Tracking.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg shadow">Mulai Gratis</a>
                        <a href="#features" class="btn btn-light btn-lg">Pelajari Fitur</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="https://img.freepik.com/free-vector/personal-finance-concept-illustration_114360-5481.jpg" class="img-fluid" alt="Hero Image">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Kenapa Memilih Tracking?</h2>
                <p class="text-muted">Fitur lengkap untuk manajemen kas harianmu.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 p-4 feature-card">
                        <div class="icon-box"><i class='bx bx-wallet'></i></div>
                        <h4>Multi Akun</h4>
                        <p class="text-muted">Kelola saldo bank, e-wallet, dan tunai dalam satu dashboard terpusat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 feature-card">
                        <div class="icon-box"><i class='bx bx-pie-chart-alt-2'></i></div>
                        <h4>Visualisasi Data</h4>
                        <p class="text-muted">Lihat arus kas melalui grafik interaktif yang mudah dipahami setiap harinya.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 feature-card">
                        <div class="icon-box"><i class='bx bx-shield-quarter'></i></div>
                        <h4>Aman & Privat</h4>
                        <p class="text-muted">Data keuanganmu dienkripsi dan hanya bisa diakses olehmu sendiri.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>