<div class="page-content sidebar-page right-sidebar-page clearfix">
  <!-- .page-content-wrapper -->
  <div class="page-content-wrapper">
    <div class="page-content-inner">
      <!-- Start .row -->
      <?php $kws = $this->controller->elements->area(); ?>
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
          <div class="panel panel-mdpt">
            <div class="panel-heading">
              <h4>LAPORAN SIASATAN TAPAK</h4>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <form role="form" id="form-verifylists">
                  <table id="sitereviews" class="table table-bordered" style="width:100%;">
                    <thead>
                      <tr>
                        <th>
                          No. Akaun <br />
                          No. Lot
                        </th>
                        <th>Alamat</th>
                        <th>Nama Jalan</th>
                        <th>Jenis Hartanah</th>
                        <th>
                          Luas Bangunan(mp) <br />
                          Luas Tanah(mp) <br />
                          Luas Ansolari(mp)
                        </th>
                        <th>
                          Luas Bgn Tamb.(mp) <br />
                          Luas Ans Tamb.(mp)
                        </th>
                        <th>
                          Catatan Hadapan <br />
                          Catatan Belakang
                        </th>
                        <th>Jenis Semakan</th>
                        <th>Tarikh Lawatan</th>
                        <th>Pegawai</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                      <button type="submit" class="btn btn-primary btn-sm" id="send"><i class="fa fa-send"></i> Serah
                        ke PBT</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End .row -->
    </div>
    <!-- End .page-content-inner -->
  </div>
  <!-- / page-content-wrapper -->
</div>