<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<body>
<div class=container>
  <div class='row header-static'>
    <div class=col-md-12>
      <nav class="navbar" role=navigation>
      	<div class=navbar-header>
          <button type=button class=navbar-toggle data-toggle=collapse data-target=.navbar-ex1-collapse> <span class=sr-only>Toggle navigation</span> <span class=icon-reorder></span> </button>
          <a class=navbar-brand href="http://undip.ac.id/"><img src="<?php echo base_url();?>resources/mystyle/image/undip.png"/></a> 
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse back-black-blur grey-blur">
          <ul class="nav navbar-nav">
            <li> <a class="pointer grey-blur" id="home-layout"> <span class=icon-home></span> Beranda </a> </li>
            <li class=dropdown> <a class='dropdown-toggle pointer' data-toggle=dropdown><span class=icon-pencil></span> Registrasi TA <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a class="pointer" id="registrasi-baru-layout"> Baru</a></li>
                <li><a class="pointer" id="registrasi-lama-layout"> Lama / Melanjutkan</a></li>
              </ul>
            </li>
            <li class=dropdown> <a class="pointer dropdown-toggle" data-toggle=dropdown><span class=icon-pencil></span> Seminar dan Sidang<i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a class="pointer" id="seminar-ta1-layout"> Seminar</a></li>
                <li><a class="pointer" id="seminar-ta2-layout"> Sidang</a></li>
              </ul>
            </li>
            <li class=dropdown> <a class='dropdown-toggle pointer' data-toggle=dropdown><span class=icon-globe></span> Lihat <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a class="pointer" id="lihat-dosen-layout"> Dosen</a></li>
                <li><a class="pointer" id="lihat-bimbingan-layout"> Bimbingan</a></li>
              </ul>
            </li>
            <li><a class="pointer" id="pinjam-layout"><span class=icon-calendar></span> Pinjam Ruang</a></li>
            <li><a class="pointer" id="bantuan-layout"><span class=icon-cogs></span> Bantuan</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li class=dropdown> <a class="dropdown-toggle pointer" data-toggle=dropdown><img src=<?php echo $image;?> style="height : 100%; max-width: 100%;" id="gambar-utama"/> <?php echo $nama; ?> <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a style="padding-right : 80px;" class="pointer" href="<?php echo base_url();?>"> <span class=icon-windows></span> Halaman Pengunjung </a></li>
                <li><a style="padding-right : 80px;" class="pointer" id="pengaturan-control" > <span class=icon-cogs></span> Pengaturan </a></li>
                <li> <a class="pointer grey-blur"  id='keluar-confirm-exe'> <span class=icon-signin></span> Keluar </a> </li>
              </ul>
            </li>
            <li style="width: 63px;"></li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="row content-top-static">
  	<div class="col-md-12">
  	 <ol class="breadcrumb" id="content-breadcrumb">
  	  <li>beranda</li> 
  	  </ol> 
  	 </div>
  </div>
<div class='row'>