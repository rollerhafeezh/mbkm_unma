<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
	<div class="main-menu-content">
		<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
			<?php 
			if($_SESSION['app_level'] <= 2){ ?>
			<li class="navigation-header bg-info">
				<span data-i18n="nav.category.aka">Menu Akademik</span>
				<i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Akademik"></i>
			</li>
			<?php } 
			if($_SESSION['app_level'] == 3){ ?>
			<li class="navigation-header bg-info">
				<span data-i18n="nav.category.aka">Menu Mahasiswa</span>
				<i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Akademik"></i>
			</li>
			<?php } 
			if($_SESSION['app_level'] == 4){ ?>
			<li class="navigation-header bg-info">
				<span data-i18n="nav.category.aka">Menu Dosen</span>
				<i class="la la-ellipsis-h ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="Akademik"></i>
			</li>
			<?php }
				$sidebar=$this->Simak_model->sidebar();
				if(isset($sidebar)){
				foreach($sidebar as $r){
				if($r['menu_level'] == 0 or $r['menu_level'] == $_SESSION['app_level']){
				$active = ($this->router->fetch_class() == $r['menu_link'])?'active':'';
				echo $r['menu_link'];
			?>
			<li class="nav-item <?=$active?>">
				<a href="<?=base_url($r['menu_link'])?>" class="nav-link">
					<i class="<?=$r['menu_icon']?>"></i>
					<span class="menu-title" data-i18n>
						<?=$r['menu_text']?>
					</span>
				</a>
			</li>
			<?php
				}}}
			?>
		</ul>
	</div>
</div>