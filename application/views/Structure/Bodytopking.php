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
            <li><a class="pointer grey-blur" id="bimbingan-layout"> <span class=icon-home></span> Bimbingan </a> </li>
            <li><a id="penguji-layout" class=' grey-blur pointer' data-toggle=dropdown><span class=icon-pencil></span> Penguji TA </a></li>
            <li><a class="pointer  grey-blur" id="bantuan-layout"><span class=icon-cogs></span> bantuan</a></li>
          </ul>
		  
		  <ul class="nav navbar-nav navbar-right">
            <li class=dropdown> <a class="dropdown-toggle pointer" data-toggle=dropdown><img src=<?php echo $image;?> style="height : 100%; max-width: 100%;" id="gambar-utama"/> <?php echo $nama; ?> <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
                <li><a style="padding-right : 80px;" class="pointer" href="<?php echo base_url();?>"> <span class=icon-windows></span> Halaman Pengunjung </a></li>
                <li><a style="padding-right : 80px;" class="pointer" id="go-to-pengaturan" onclick="openPengaturan()" > <span class=icon-cogs></span> Pengaturan </a></li>
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
  	  <li>Acara</li> 
  	  </ol> 
  	 </div>
  </div>
<div class='row'>