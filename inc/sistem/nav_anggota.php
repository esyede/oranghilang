<?php
//ini buat nyetting judul halaman. lihat fungsi set_judul_halaman() di file /inc/sistem/fungsi.php
set_judul_halaman(); ?>
<div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
          <!-- INI BUAT  ANGGOTA DAN ADMIN -->
          <?php if (dia_admin() || dia_anggota()) { //jadi kalo dia admin atau dia anggota, biarin dia akses menu - menu ini
            ?>
            <li>
                <a href="kelola.php?aksi=lihat_profil" class=" hvr-bounce-to-right"><i class="fa fa-user nav_icon "></i><span class="nav-label">Profil saya</span> </a>
            </li>

            <li>
                <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-indent nav_icon"></i> <span class="nav-label">Buat Laporan</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="kelola.php?aksi=buat_laporan_kehilangan" class=" hvr-bounce-to-right"> <i class="fa fa-area-chart nav_icon"></i>Lapor Kehilangan</a></li>
                    <li><a href="kelola.php?aksi=buat_laporan_ditemukan" class=" hvr-bounce-to-right"><i class="fa fa-map-marker nav_icon"></i>Lapor Ditemukan</a></li>

               </ul>
            </li>
            <li>
                <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-indent nav_icon"></i> <span class="nav-label">Data Pelaporan</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="kelola.php?aksi=laporan_saya" class=" hvr-bounce-to-right"> <i class="fa fa-area-chart nav_icon"></i>Laporan Saya</a></li>
                    <li><a href="kelola.php?aksi=semua_laporan" class=" hvr-bounce-to-right"><i class="fa fa-map-marker nav_icon"></i>Semua Laporan</a></li>
               </ul>
            </li>
            <li>
                <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-indent nav_icon"></i> <span class="nav-label">Pencarian</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="kelola.php?aksi=cari_nama" class=" hvr-bounce-to-right"> <i class="fa fa-area-chart nav_icon"></i>Cari Menurut Nama</a></li>
                    <li><a href="kelola.php?aksi=cari_tanggal" class=" hvr-bounce-to-right"><i class="fa fa-map-marker nav_icon"></i>Cari Menurut Tanggal</a></li>
               </ul>
            </li>
            <!-- INI BUAT ANGGOTA DAN ADMIN -->


            <!-- INI HANYA BUAT ADMIN -->
            <?php if (dia_admin()) { //kalo ini khusus buat admin
              ?>
                    <li>
                        <a href="#" class=" hvr-bounce-to-right"><i class="fa fa-cogs nav_icon"></i> <span class="nav-label">Menu Admin</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="admin.php?aksi=kelola_anggota" class=" hvr-bounce-to-right"> <i class="fa fa-users nav_icon"></i>Kelola Anggota</a></li>
                       </ul>
                    </li>

            <!-- INI HANYA BUAT ADMIN -->
            <?php 
}
}
          ?>
            <!-- INI BUAT SIAPA AJA-->
              <li>
                <a href="#" class=" hvr-bounce-to-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-lightbulb-o nav_icon"></i> <span class="nav-label">Tentang</span> </a>
            </li>

            <li>
              <a href="kelola.php?aksi=hubungi_kami" class=" hvr-bounce-to-right"><i class="fa fa-inbox nav_icon"></i>Hubungi Kami</a>
            </li>
        </ul>
    </div>
</div>
</nav>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
     <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           <h3 class="modal-title">Tentang</h3>
         </div>
         <div class="modal-body">
           <script>
           $(function(){

               $("#typed").typed({
                   // strings: ["Typed.js is a <strong>jQuery</strong> plugin.", "It <em>types</em> out sentences.", "And then deletes them.", "Try it out!"],
                   stringsElement: $('#teks-tentang'),
                   typeSpeed: 30,
                   backDelay: 500,
                   loop: false,
                   contentType: 'html', // or text
                   // defaults to false for infinite loop
                   loopCount: false,
                   callback: function(){ foo(); },
                   resetCallback: function() { newTyped(); }
               });

               $(".reset").click(function(){
                   $("#typed").typed('reset');
               });

           });

           </script>
           <div class="row">
               <div class="col-md-4">
                 <img src="assets/images/ikon.png" height="150px" width="150px" alt="ikon" />
               </div>
               <div class="col-md-8">
                 <div id="teks-tentang">
                   <p>App.   : Lost in Karawang<br>Ver.     : 0.1 <small class="text text-danger">(alpha)</small><br>Auth.  : Fasilkom Unsika 2014 B-F<br>Lic.      : <a href="gpl-2.0.txt" target="_blank">GNU GPLv2</a><br><br>"Everything will be okay in the end.<br> If it's not okay, it's not the end."</p>
                 </div>
                 <span id="typed" style="white-space:pre;"></span>
               </div>
             </div>
             </div>
         <div class="modal-footer">
           <button type="button" id="reset" class="btn btn-success pull-right" data-dismiss="modal">Tutup</button>
         </div>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
   </div>




<div id="page-wrapper" class="gray-bg dashbard-1">
<div class="content-main">
