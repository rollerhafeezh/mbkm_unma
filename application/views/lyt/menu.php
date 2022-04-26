<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow d-print-none">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item mr-auto">
            <a class="navbar-brand" href="<?=base_url('dashboard')?>">
              <img width="100%" alt="UNMAKU LOGO" src="<?=base_url()?>assets/images/unmaku_150.png">
            </a>
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
			<li class="nav-item d-none d-md-block float-right"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="toggle-icon ft-toggle-right font-medium-3" data-ticon="ft-toggle-right"></i></a></li>
		  </ul>
          <ul class="nav navbar-nav float-right">
            <!-- <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="false">
                <i class="ficon ft-mail"></i>
                <span class="badge badge-pill badge-info badge-up font-small-3" style="top:15px;right:8px;">1</span>
              </a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right pb-0">
                  <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Pesan Masuk</span></h6>
                  </li>
                  <li class="scrollable-container media-list w-100 ps">
                    <a href="javascript:void(0)">
                      <div class="media">
                        <div class="media-left align-self-center">
                          <i class="ft-user-check icon-bg-circle bg-success mr-0"></i>
                        </div>
                        <div class="media-body">
                          <h6 class="media-heading">Pelaksanaan Seminar Kerja Praktek (Disetujui)</h6>
                          <p class="notification-text font-small-3 text-muted" style="line-height: normal;">Selamat, pengajuan seminar kerja praktek anda sudah disetujui dan akan dilaksanakan di <b>Ruang Rapat</b> pada hari <b>Senin, 01 Mei 2020</b> dan akan diuji/telaah oleh <b>Ardi Mardiana, ST., M.Kom.</b>.</p>
                            <small>
                              <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time>
                            </small>
                        </div>
                      </div>
                    </a>
                    </li>
                </ul>
              </li> -->
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1">
                  <span class="user-name text-bold-700"><?=$_SESSION['nama_user']?></span>
                </span>
                <span class="avatar avatar-online">
                  <img src="<?=base_url()?>assets/images/logo_100.png" alt="avatar"><i></i></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
               
                <a class="dropdown-item" href="#"><i class="la la-key"></i><?=$_SESSION['username']?></a>
                <a class="dropdown-item" href="#"><i class="la la-group"></i><?=$_SESSION['level_name']?></a>
				<div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?=base_url('auth/logout')?>"><i class="ft-power"></i> Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>