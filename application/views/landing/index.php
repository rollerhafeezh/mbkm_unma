<!-- SLIDER -->
<section>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item slider1 active">
                <img src="<?= base_url() ?>assets/images/slider/2.jpg" alt="">
                <div class="carousel-caption slider-con text-left">
                    <h2>MBKM Universitas Majalengka</h2>
                    <p>Kampus Merdeka adalah cara terbaik  berkuliah. <br>
                    	Dapatkan kemerdekaan untuk membentuk masa depan yang sesuai dengan aspirasi kariermu.</p>
                    <a href="<?= base_url('program') ?>" class="bann-btn-1">Daftar Program</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PENGUMUMAN -->
<section id="pengumuman">
    <div class="container com-sp">
        <div class="row">
            <div class="con-title">
                <h2>Terkini</h2>
            </div>
        </div>
        <div class="row">
            <div class="ed-course">
                <?php foreach ($pengumuman->data as $row): ?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <a href="https://kampusmerdeka.kemdikbud.go.id/announcement/<?= $row->id ?>/<?= $row->slug ?>" target="_blank">
                        <div class="ho-ev-latest ho-ev-latest-bg-1">
                            <div class="ho-lat-ev">
                                <p class="text-muted mb-3"><?= $row->create_date ?></p>
                                <h4><?= $row->title ?></h4>
                            </div>
                        </div>
                    </a>
                </div> 
                <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-12 text-center">
            	<a href="https://kampusmerdeka.kemdikbud.go.id/announcement" target="_blank" class="btn btn-primary">Pengumuman Lainnya &raquo;</a>
            </div>
        </div>
    </div>
</section>

<!-- TENTANG MBKM -->
<section class="pop-cour"  id="tentang_mbkm">
    <div class="container com-sp">
        <div class="row" style="font-family: sans-serif; padding: 0px 30px 0 30px;">
            <div class="con-title col">
                <img src="<?= base_url() ?>assets/images/question-mark.png" style="margin-bottom: 20px; width: 90px;">
                <h2 >Apa Itu Kampus Merdeka ?</h2>
                <p>Kampus Merdeka merupakan bagian dari kebijakan Merdeka Belajar oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia yang memberikan kesempaatan bagi mahasiswa/i untuk mengasah kemampuan sesuai bakat dan minat dengan terjun langsung ke dunia kerja sebagai persiapan karier masa depan.</p>

                <h2 style="font-family: sans-serif; padding: 50px 30px 20px 30px;">Kenapa kamu harus mengikuti program-program Kampus Merdeka?</h2>
            </div>

            <div class="col-md-3 col-xs-6 text-center">
                <img src="https://kampusmerdeka.kemdikbud.go.id/static/media/step-1.adcc9bf8.webp" class="mb-3">
                <p>Kegiatan praktik di lapangan akan dikonversi menjadi SKS</p>
            </div>
            <div class="col-md-3 col-xs-6 text-center">
                <img src="https://kampusmerdeka.kemdikbud.go.id/static/media/step-2.0f032462.webp" class="mb-3">
                <p>Eksplorasi pengetahuan dan kemampuan di lapangan selama lebih dari satu semester</p>
            </div>
            <div class="col-md-3 col-xs-6 text-center">
                <img src="https://kampusmerdeka.kemdikbud.go.id/static/media/step-3.a97ee13e.webp" class="mb-3">
                <p>Belajar dan memperluas jaringan di luar program studi atau kampus asal</p>
            </div>
            <div class="col-md-3 col-xs-6 text-center">
                <img src="https://kampusmerdeka.kemdikbud.go.id/static/media/step-4.8e378a24.webp" class="mb-3">
                <p>Menimba ilmu secara langsung dari mitra berkualitas dan terkemuka</p>
            </div>
            <div class="clearfix"></div>
            <div class="col-12 text-center mt-4">
                <a href="<?= base_url('program') ?>" class="btn btn-primary">Lihat Semua Program Kampus Merdeka &raquo;</a>
            </div>
        </div>
    </div>
</section>

<!-- FQ -->
<section id="faq">
    <div class="container com-sp">
        <div class="row">
            <div class="con-title">
                <h2>Pertanyaan Umum</h2>
            </div>
        </div>
        <div class="row">
            <div class="s18-age-event l-info-pack-days">
                <ul>
                    <li>
                        <div class="s17-eve-time">
                            <div class="s17-eve-time-msg">
                                <h4>Bagaimana cara registrasi dan membuat akun di aplikasi Merdeka Belajar Kampus Merdeka (MBKM) Universitas Majalengka?</h4>
                                <div class="time-hide time-hide-1 mt-4" style="display: none;">
                                    <p>1. Mahasiswa memastikan data diri sesuai dengan data di PDDikti (pddikti.kemdikbud.go.id)</p>
                                    <p>2. Pada halaman utama website Merdeka Belajar - Kampus Merdeka klik tombol "Masuk" di pojok kanan atas</p>
                                    <p>3. Selanjutnya akan muncul halaman Login seperti berikut, Klik “Belum Punya Akun? Daftar Disini untuk melanjutkan ke halaman Pendaftaran</p>
                                    <p>4. Maka akan muncul halaman form pendaftaran. Lengkapi data diri Anda.</p>
                                    <p>5. Setelah melakukan pendaftaran akun, silahkan cek pada email yang sudah didaftarkan</p>
                                    <p>6. Klik tombol “AKTIFKAN AKUN” pada email tersebut. Selanjutnya akan muncul halaman Login dengan keterangan ”Perhatian, Akun anda sudah aktif”</p>
                                </div>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-1-btn" style="display: block;">
                                <i class="fa fa-angle-down"></i>
                            </a>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-11-btn hb-com" style="display: none;">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="s17-eve-time">
                            <div class="s17-eve-time-msg">
                                <h4>Bagaimana cara mengecek data saya di PDDIKTI?</h4>
                                <div class="time-hide time-hide-2 mt-4" style="display: none;">
                                    <p>Anda dapat mengecek data Anda di situs PDDikti (http://pddikti.kemdikbud.go.id).</p>
                                </div>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-2-btn" style="display: block;">
                                <i class="fa fa-angle-down"></i>
                            </a>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-22-btn hb-com" style="display: none;">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="s17-eve-time">
                            <div class="s17-eve-time-msg">
                                <h4>Apa yang harus dilakukan apabila data saya berbeda atau tidak ada di PDDIKTI?</h4>
                                <div class="time-hide time-hide-3 mt-4" style="display: none;">
                                    <p>Untuk mendaftarkan atau mengubah data Anda di PDDikti silahkan hubungi Admin PDDIKTI di masing-masing Perguruan Tinggi.</p>
                                </div>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-3-btn" style="display: block;">
                                <i class="fa fa-angle-down"></i>
                            </a>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-33-btn hb-com" style="display: none;">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="s17-eve-time">
                            <div class="s17-eve-time-msg">
                                <h4>Apa yang harus saya lakukan apabila saya lupa password akun Merdeka Belajar Kampus Merdeka (MBKM) Universitas Majalengka?</h4>
                                <div class="time-hide time-hide-4 mt-4" style="display: none;">
                                    <p>1. Pada halaman utama website Merdeka Belajar - Kampus Merdeka klik tombol “Masuk” di pojok kanan atas</p>
                                    <p>2. Klik “Lupa Kata Sandi”</p>
                                    <p>3. Pilih Bantuan “Tidak Tahu/Lupa Kata Sandi” kemudian masukkan Nama Pengguna/NPM, Email dan No. Handphone yang terdaftar lalu klik “Kirim”</p>
                                    <p>4. Cek inbox email Anda dan ikuti instruksi selanjutnya untuk mengubah kata sandi Anda.</p>
                                </div>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-4-btn" style="display: block;">
                                <i class="fa fa-angle-down"></i>
                            </a>
                                <a href="#!" class="s17-sprit age-dwarr-btn time-hide-44-btn hb-com" style="display: none;">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <!-- <div class="clearfix"></div>
                <div class="col-12 text-center">
                    <a href="https://sites.google.com/wartek.belajar.id/faqmahasiswakm/home" target="_blank" class="btn btn-primary">Pertanyaan Lainnya &raquo;</a>
                </div> -->
            </div>
        </div>
    </div>
</section>