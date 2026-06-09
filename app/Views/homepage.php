<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Digital</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/6.5.2/css/all.min.css">
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 0, 0, .4);
            backdrop-filter: blur(10px);
        }

        /* Hero */
        .hero {
            height: 100vh;
            background:
                linear-gradient(rgba(0, 0, 0, .70), rgba(0, 0, 0, .70)),
                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1920');
                    background-size:cover;
                    background-position:center;
                    display:flex;
                    align-items:center;
                    color:white;
            }

            .hero h1 {
                font-size:4rem;
                font-weight:bold;
            }

            .hero p {
                font-size:1.2rem;
            }

            .btn-login {
                padding:14px 35px;
                border-radius:50px;
                font-weight:bold;
            }

            .section-title {
                font-weight:bold;
                margin-bottom:10px;
            }

            .book-card {
                transition:.3s;
            }

            .book-card:hover {
                transform:translateY(-8px);
            }

            .feature-card {
                border:none;
                border-radius:20px;
                box-shadow:0 5px 20px rgba(0, 0, 0, .08);
                transition:.3s;
            }

            .feature-card:hover {
                transform:translateY(-8px);
            }

            .feature-icon {
                font-size:50px;
                color:#0d6efd;
            }

            footer {
                background:#111827;
                color:white;
                padding:25px;
            }

            .cover-book {
                height: 360px;
                object-fit: contain;
            }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                📚 Perpustakaan Digital
            </a>
            <button class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a href="#katalog" class="nav-link">Katalog Buku</a>
                    </li>
                    <li class="nav-item">
                        <a href="#fitur" class="nav-link">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a href="#tentang" class="nav-link">Tentang</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- HERO -->
    <section class="hero">
        <div class="container text-center">
            <h1>Sistem Informasi Perpustakaan</h1>
            <p class="mt-3 mb-4">
                Kelola buku, anggota, kategori, rak dan koleksi
                perpustakaan secara modern dan terintegrasi.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="<?= base_url('admin/login-admin') ?>"
                    class="btn btn-primary btn-lg btn-login">
                    <i class="fa-solid fa-user-shield"></i>
                    Login Admin
                </a>
                <a href="<?= base_url('anggota/login') ?>"
                    class="btn btn-success btn-lg btn-login">
                    <i class="fa-solid fa-users"></i>
                    Login Anggota
                </a>
            </div>
        </div>
    </section>
    <!-- KATALOG -->
    <section id="katalog" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">
                    Katalog Buku
                </h2>
                <p class="text-muted">
                    Koleksi buku yang tersedia di perpustakaan
                </p>
            </div>
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <input type="text"
                        id="searchBook"
                        class="form-control form-control-lg"
                        placeholder="Cari Judul Buku...">
                </div>
            </div>
            <div class="row">
                <?php foreach ($data_buku as $buku): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 book-item">
                        <div class="card border-0 shadow h-100 book-card">
                            <?php if (!empty($buku['cover_buku'])): ?>
                                <img
                                    src="<?=
                                            base_url('Assets/CoverBuku/' . $buku['cover_buku']) ?>"
                                    class="card-img-top cover-book">
                            <?php else: ?>
                                <img
                                    src="https://via.placeholder.com/300x400?text=No+Cover"
                                    class="card-img-top cover-book">
                            <?php endif; ?>
                            <div class="card-body">
                                <h3 class="fw-bold text-center" style="fontsize:18px;">
                                    <?= $buku['judul_buku']; ?>
                                </h3>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <button
                                    class="btn btn-outline-primary w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal<?= $buku['id_buku']; ?>">
                                    Detail Buku
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!-- FITUR -->
    <section id="fitur" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">
                    Fitur Sistem
                </h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center h-100">
                        <i class="fa-solid fa-book feature-icon"></i>
                        <h4 class="mt-3">
                            Manajemen Buku
                        </h4>
                        <p>
                            Kelola data buku dan stok koleksi.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center h-100">
                        <i class="fa-solid fa-users feature-icon"></i>
                        <h4 class="mt-3">
                            Data Anggota
                        </h4>
                        <p>
                            Kelola data anggota perpustakaan.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 text-center h-100">
                        <i class="fa-solid fa-chart-column feature-icon"></i>
                        <h4 class="mt-3">
                            Monitoring
                        </h4>
                        <p>
                            Monitoring data perpustakaan realtime.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- TENTANG -->
    <section id="tentang" class="bg-light py-5">
        <div class="container text-center">
            <h2 class="section-title">
                Tentang Perpustakaan
            </h2>
            <p class="text-muted">
                Sistem Informasi Perpustakaan berbasis CodeIgniter 4
                untuk membantu pengelolaan buku, anggota,
                kategori dan rak secara digital.
            </p>
        </div>
    </section>
    <!-- FOOTER -->
    <footer class="text-center">
        © <?= date('Y'); ?> Sistem Informasi Perpustakaan
    </footer>
    <!-- MODAL DETAIL BUKU -->
    <?php foreach ($data_buku as $buku): ?>
        <div class="modal fade" id="modal<?= $buku['id_buku']; ?>">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?= $buku['judul_buku']; ?>
                        </h5>
                        <button class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <?php if (!empty($buku['cover_buku'])): ?>
                                    <img
                                        src="<?=
                                                base_url('Assets/CoverBuku/' . $buku['cover_buku']) ?>"
                                        class="img-fluid rounded">
                                <?php endif; ?>
                            </div>
                            <div class="col-md-8">
                                <table class="table">
                                    <tr>
                                        <th>Judul</th>
                                        <td><?= $buku['judul_buku']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pengarang</th>
                                        <td><?= $buku['pengarang']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Penerbit</th>
                                        <td><?= $buku['penerbit']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tahun</th>
                                        <td><?= $buku['tahun']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td><?= $buku['nama_kategori']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Rak</th>
                                        <td><?= $buku['nama_rak']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah</th>
                                        <td><?= $buku['jumlah_eksemplar']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan</th>
                                        <td><?= $buku['keterangan']; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('searchBook')
            .addEventListener('keyup', function() {
                let keyword = this.value.toLowerCase();
                document.querySelectorAll('.book-item')
                    .forEach(function(item) {
                        let text = item.innerText.toLowerCase();
                        item.style.display =
                            text.includes(keyword) ?
                            '' :
                            'none';
                    });
            });
    </script>
</body>

</html>