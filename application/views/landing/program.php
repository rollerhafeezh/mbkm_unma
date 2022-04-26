<section>
    <div class="head-2">
        <div class="container">
            <div class="head-2-inn head-2-inn-padd-top" style="text-align: left !important;">
                <h1 class="pb-0">Program Kampus Merdeka</h1>
                <p>Kamu bisa berbagai pilihan program dari <b>Kampus Merdeka</b> yang tersedia untukmu</p>
            </div>
        </div>
    </div>
</section>
<section class="pop-cour">
    <div class="container com-sp pad-bot-70">
        <div class="row">
            <div class="cor about-sp">
                <div class="ed-about-sec1">
                    <div class="ed-advan">
                        <ul>
                            <?php foreach ($program->data as $row): ?>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4><?= $row->nama_kegiatan ?></h4>
                                    <p><?= $row->deskripsi ?></p>
                                    <!-- <a href="https://kampusmerdeka.kemdikbud.go.id/web/auth/integration/detail_program?id_ref_kegiatan=<?= $row->id ?>">Informasi Program &raquo;</a> -->
                                </div>
                            </li>
                            <?php endforeach; ?>
                            <!-- <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Bangkit by Google, Goto, Traveloka</h4>
                                    <p>Bangkit adalah program kesiapan karier yang didesain oleh Google untuk memberikan mahasiswa Indonesia paparan langsung dengan praktisi industri, serta mempersiapkan mahasiswa dengan keterampilan yang relevan untuk karir sukses di perusahaan teknologi terkemuka.</p>
                                    <a href="https://grow.google/intl/id_id/bangkit/">Informasi Program &raquo;</a>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Indonesian International Student Mobility Awards</h4>
                                    <p>Mobilitas mahasiswa selama 1 semester di perguruan tinggi terbaik dunia</p>
                                    <a href="https://kampusmerdeka.kemdikbud.go.id/km/IISMA/landing.html">Informasi Program &raquo;</a>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Kampus Mengajar</h4>
                                    <p>Membantu peningkatan kualitas dan pemerataan pendidikan dasar</p>
                                    <a href="https://kampusmerdeka.kemdikbud.go.id/program/mengajar">Informasi Program &raquo;</a>
                                </div>
                            </li>

                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Kementerian ESDM - GERILYA</h4>
                                    <p>Studi Independen GERILYA (Gerakan Inisiatif Listrik Tenaga Surya) memanggil 50 mahasiswa eksakta dari perguruan tinggi di Indonesia untuk turut bergabung mengasah skill dan mengembangkan kompetensi secara praktis di bidang energi bersih khususnya Solar Photovoltaic (PV).</p>
                                    <a href="https://www.esdm.go.id/id/page/gerilya">Informasi Program &raquo;</a>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Magang</h4>
                                    <p>Sambut karir masa depan dengan pengalaman kerja yang berharga</p>
                                    <a href="https://kampusmerdeka.kemdikbud.go.id/program/magang/detail">Informasi Program &raquo;</a>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Membangun Desa (KKN Tematik)</h4>
                                    <p>Menyumbang gagasan solusi untuk isu-isu sosial</p>
                                </div>
                            </li>

                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Pejuang Muda Kampus Merdeka</h4>
                                    <p>Pejuang Muda adalah laboratorium sosial bagi para mahasiswa mengaplikasikan ilmu dan pengetahuannya untuk memberi dampak sosial secara konkret. Melalui Program setara 20 SKS ini, mahasiswa ditantang untuk belajar dari warga sekaligus berkolaborasi dengan Pemerintah Daerah dan tokoh daerah setempat.</p>
                                    <a href="https://pejuangmuda.kemensos.go.id/">Informasi Program &raquo;</a>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Pertukaran Mahasiswa Merdeka</h4>
                                    <p>Belajar lintas kampus dan lintas budaya</p>
                                    <a href="https://kampusmerdeka.kemdikbud.go.id/web/pertukaranMahasiswaMerdeka2021">Informasi Program &raquo;</a>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Proyek Kemanusiaan</h4>
                                    <p>Menyumbang gagasan solusi untuk isu-isu sosial</p>
                                </div>
                            </li>

                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Riset atau Penelitian</h4>
                                    <p>Proyek penelitian di laboratorium pusat riset</p>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Studi Independen</h4>
                                    <p>Kuasai ilmu aplikatif lintas jurusan dari para ahli di bidangnya</p>
                                    <a href="https://kampusmerdeka.kemdikbud.go.id/web/pertukaranMahasiswaMerdeka2021">Informasi Program &raquo;</a>
                                </div>
                            </li>
                            <li style="height: 265px !important;">
                                <div class="ed-ad-dec">
                                    <h4>Wirausaha</h4>
                                    <p>Mengembangkan usaha di bawah bimbingan profesional</p>
                                </div>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div class="ed-about-sec1">
                    <div class="col-md-6"></div>
                    <div class="col-md-6"></div>
                </div>
            </div>
        </div>
    </div>
</section>