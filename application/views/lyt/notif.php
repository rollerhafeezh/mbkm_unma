<?php
	$notif=json_decode($this->curl->simple_get(ADD_API.'notif/get_notif?unread=Y&username='.$_SESSION['username'].'&id_level='.$_SESSION['id_level']),true);
	$count=count($notif);
?>
<li class="dropdown dropdown-notification nav-item ">
	<a class="nav-link nav-link-label" href="#" data-toggle="dropdown" aria-expanded="">
		<i class="ficon ft-bell"></i>
		<?php if($count!=0)
			echo'<span class="badge badge-pill badge-danger badge-up badge-glow">'.$count.'</span>';
		?>
	</a>
	<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
	  <li class="dropdown-menu-header">
		<h6 class="dropdown-header m-0">
			<span class="grey darken-2">Notifikasi</span>
		</h6>
			<?php if($count!=0){
			echo '<span class="notification-tag badge badge-danger float-right m-0">
				'.$count.' Baru
			</span>'; }
			?>
	  </li>
		<?php if($count!=0){ 
			foreach($notif as $key=>$value){
		?>
	  <li class="scrollable-container media-list w-100 ps">
		<a onclick="patch_notif('<?=$value['id_notif']?>','read')" href="<?=$value['url_msg']?>">
			<div class="media">
			<div class="media-body">
				<p class="notification-text font-small-3 text-muted">
					<?=$value['created_by']?> <?=$value['isi_msg']?> 
				</p>
				<small>
					<time class="media-meta text-muted" datetime="<?=$value['created_at']?>"><?=time_elapsed_string($value['created_at'])?></time>
				</small>
			</div>
			</div>
		</a>
		</li>
		<?php  }}else{echo '<li class="scrollable-container media-list w-100 ps m-1">belum ada notifikasi</li>';} ?>
	  <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="<?=base_url('dashboard/notifikasi')?>">Lihat Semua Notifikasi</a></li>
	</ul>
</li>
<script type="text/javascript">

function patch_notif(i,w)
{
	var i=i;
	var w=w;
	
	$.ajax({
		type:"POST",
		url: "<?=base_url('dashboard/patch_notif')?>",
		cache: false,
		data:{i:i,w:w},
		success: function(respond){
			return true;
		}
	});
};
</script>