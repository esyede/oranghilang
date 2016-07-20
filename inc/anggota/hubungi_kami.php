<?php
ob_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda
require_once 'inc/sistem/kepala.php'; //sda
require_once 'inc/sistem/nav_anggota.php'; //sda

 ?>

<div class="banner">
  <h2>
    <a href="<?php echo $index; ?>">Beranda</a>
    &raquo;
    <span>Hubungi Kami</span>
  </h2>
</div>

<div class="validation-system">
  <div class="validation-form">
         <div class="questions">
           <h5>Irwan Depi Juliana <span class="btn btn-xs btn-success">mod</span></h5>
               <p>
                 <a class="btn btn-default" href="#"><i class="fa fa-facebook-official"></i> Irwan on Facebook</a>
                 <a class="btn btn-default" href="#"><i class="fa fa-twitter-square"></i> Irwan on Twitter</a>
                 <a class="btn btn-default" href="#"><i class="fa fa-google-plus"></i> Irwan on Google+</a>
                 <a class="btn btn-default" href="#"><i class="fa fa-github"></i> Irwan on GitHub</a>
               </p>
             </div>

             <div class="questions">
               <h5>Ardiyanto <span class="btn btn-xs btn-success">mod</span></h5>
                   <p>
                     <a class="btn btn-default" href="#"><i class="fa fa-facebook-official"></i> Ardi on Facebook</a>
                     <a class="btn btn-default" href="#"><i class="fa fa-twitter-square"></i> Ardi on Twitter</a>
                     <a class="btn btn-default" href="#"><i class="fa fa-google-plus"></i> Ardi on Google+</a>
                     <a class="btn btn-default" href="#"><i class="fa fa-github"></i> Ardi on GitHub</a>
                   </p>
                 </div>

              <div class="questions">
                <h5>Arif Aulia Rachman <span class="btn btn-xs btn-success">mod</span></h5>
                    <p>
                      <a class="btn btn-default" href="#"><i class="fa fa-facebook-official"></i> Arif on Facebook</a>
                      <a class="btn btn-default" href="#"><i class="fa fa-twitter-square"></i> Arif on Twitter</a>
                      <a class="btn btn-default" href="#"><i class="fa fa-google-plus"></i> Arif on Google+</a>
                      <a class="btn btn-default" href="#"><i class="fa fa-github"></i> Arif on GitHub</a>
                    </p>
                  </div>

                <div class="questions">
                  <h5>Acep Zaenal <span class="btn btn-xs btn-success">mod</span></h5>
                      <p>
                        <a class="btn btn-default" href="#"><i class="fa fa-facebook-official"></i> Acep on Facebook</a>
                        <a class="btn btn-default" href="#"><i class="fa fa-twitter-square"></i> Acep on Twitter</a>
                        <a class="btn btn-default" href="#"><i class="fa fa-google-plus"></i> Acep on Google+</a>
                        <a class="btn btn-default" href="#"><i class="fa fa-github"></i> Acep on GitHub</a>
                      </p>
                    </div>

                  <div class="questions">
                    <h5>Asri Indah Permatasari <span class="btn btn-xs btn-success">mod</span></h5>
                        <p>
                          <a class="btn btn-default" href="#"><i class="fa fa-facebook-official"></i> Asri on Facebook</a>
                          <a class="btn btn-default" href="#"><i class="fa fa-twitter-square"></i> Asri on Twitter</a>
                          <a class="btn btn-default" href="#"><i class="fa fa-google-plus"></i> Asri on Google+</a>
                          <a class="btn btn-default" href="#"><i class="fa fa-github"></i> Asri on GitHub</a>
                        </p>
                      </div>
</div>
</div>

   <?php
  require_once 'inc/sistem/kaki.php'; //sda
  ob_end_flush(); //sda
    ?>
