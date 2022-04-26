<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow d-print-none" data-scroll-to-active="true">
	<div class="main-menu-content">
		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
			<?php 
			//MENU MAHASISWA
			if($_SESSION['app_level'] == 1){ ?>
			<li class="navigation-header">
				<span data-i18n="nav.category.aka">Mahasiswa Kampus Merdeka</span>
				<i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Dosen"></i>
			</li>
			<?php 
				$sidebar=$this->Menu_model->sidebar_mhs();
			}
			
			//MENU DOSEN
			if($_SESSION['app_level'] == 2){ ?>
			<li class="navigation-header">
				<span data-i18n="nav.category.aka">Dosen</span>
				<i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Dosen"></i>
			</li>
			<?php 
				$sidebar=$this->Menu_model->sidebar_dosen();
			}
			
			//MENU DOSEN
			if($_SESSION['app_level'] == 3){ ?>
			<li class="navigation-header">
				<span data-i18n="nav.category.aka">P3M</span>
				<i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Dosen"></i>
			</li>
			<?php 
				$sidebar=$this->Menu_model->sidebar_p3m();
			}
			
			$active='';
			foreach($sidebar as $r){
				
				if($r['has-sub']==TRUE){
				$active = ($this->router->fetch_class() == $r['menu_child'][0]['menu_link'])? 'active open':'';
			?>
			<li class="nav-item has-sub <?=$active?> <?=$r['menu_color']?> ">
				<a href="#"><i class="<?=$r['menu_icon']?>"></i>
					<span class="menu-title " data-i18n><?=$r['menu_text']?></span>
				</a>
				<ul class="menu-content" style="">
				<?php 
					$active='';
					foreach($r['menu_child'] as $c){ 
					//$active = ($this->router->fetch_class() == $c['menu_link'] or strpos($c['menu_link'], $this->router->method) ) ? 'active':'';
				?>
					<li class="<?=$active?>">
						<a class="menu-item" href="<?=base_url($c['menu_link'])?>"><i></i>
							<span data-i18n><?=$c['menu_text'] ?></span></a>
					</li>
				<?php } ?>
				</ul>
			</li>
				<?php 
				
					}else{ 
					$active = ($this->router->fetch_class() == $r['menu_link'])?'active':'';
				?>
					<li class="nav-item <?=$active?> <?=$r['menu_color']?>">
						<a href="<?=base_url($r['menu_link'])?>" class="nav-link">
							<i class="<?=$r['menu_icon']?>"></i>
							<span class="menu-title " data-i18n>
								<?=$r['menu_text']?>
							</span>
						</a>
					</li>
				<?php }}  ?>
		</ul>
	</div>
</div>