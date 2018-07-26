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
            <li> <a class="pointer grey-blur" id="beranda-layout"> <span class=icon-home></span> beranda </a> </li>
			      <li> <a class="pointer grey-blur" id="registrasi-layout"> <span class=icon-list-alt></span> Registrasi TA </a> </li>
			      <li> <a class="pointer grey-blur" id="seminar-layout"> <span class=icon-list-alt></span> Seminar TA </a> </li>
            <li class=dropdown> <a class='dropdown-toggle pointer' data-toggle=dropdown><span class=icon-globe></span> Universitas Diponegoro <i class="icon-angle-right pull-right"></i></a>
              <ul class=dropdown-menu>
				        <li> <a href=#>Ilmu komputer / Informatika <i class="icon-angle-right pull-right"></i> </a> 
					        <ul class=dropdown-submenu> 
						        <li><a href="http://clone.if.undip.ac.id/">Kuliah online</a></li> 
						        <li><a href="http://hm.if.undip.ac.id/">Himpunan Mahasiswa</a></li> 
                    <li><a href="http://sipkl.000webhostapp.com">Pendaftaran PKL</a></li> 
                    <li><a href="http://if.undip.ac.id/">Halaman beranda</a></li> 
                  </ul> 
                </li> 
				        <li> <a href=#>Fakultas Sains &amp; Matematika <i class="icon-angle-right pull-right"></i> </a> 
					        <ul class=dropdown-submenu> 
						        <li><a href="http://fsm.undip.ac.id/">Halaman beranda</a></li> 
					        </ul> 
				        </li> 
                <li><a style="padding-right : 80px;" class="pointer" href="http://undip.ac.id"> Halaman beranda </a></li>
              </ul>
            </li>
            <li><a class="pointer" id="bantuan-layout"><span class=icon-cogs></span> bantuan</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <?php 
            if($core == null){
              echo '<li> <a class="pointer grey-blur"  href="'.base_url().'Gateinout"> <span class="icon-signin"></span> Masuk </a> </li>'; 
            }
            else{
              echo '
              
              <li class=dropdown> <a class="dropdown-toggle pointer" data-toggle=dropdown><img src="'.$image.'" style="height : 100%; max-width: 100%;" id="gambar-utama"/>  '.$nama.' <i class="icon-angle-right pull-right"></i></a>
                <ul class=dropdown-menu>
                  <li><a style="padding-right : 80px;" class="pointer" href="'.$kelola.'"> <span class=icon-desktop></span> Halaman Kelola </a></li>
                  <li><a style="padding-right : 80px;" class="pointer" href="'.$pengaturan.'"> <span class=icon-cogs></span> Pengaturan </a></li>
                  <li><a style="padding-right : 80px;" class="pointer"  id="keluar-local"> <span class=icon-signout></span> Keluar </a></li>
                </ul>
              </li>
              '; 
          }?>
            
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