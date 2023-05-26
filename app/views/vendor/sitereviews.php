<div class="page-content sidebar-page clearfix">
  <!-- .page-content-wrapper -->
  <div class="page-content-wrapper">
    <div class="page-content-inner">
      <!-- Start .row -->
      <?php $kws = $this->controller->elements->area(); ?>
      <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <div class="row align-items-center">
                <div class="col">
                  <h4 class="ml15">MAKLUMAT SIASATAN TAPAK</h4>
                </div>
                <!--end col-->
                <div class="col-auto">
                  <button type="button" class="btn btn-default btn-xs mt10 mr10" id="print"><i class="glyphicon glyphicon-print"></i></button>
                </div>
                <!--end col-->
              </div>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6">
                </div>
                <div class="col-lg-6 col-sm-6 col-md-6 mb10 tar pr15">
                  <form class="form-inline" role="form">
                    <div class="form-group">
                      <select class="form-control input-sm" name="area" id="area">
                        <option selected value="">Sila Pilih Kawasan</option>
                        <?php foreach ($kws as $row) { ?>
                          <option value="<?= $row["kws_kwkod"] ?>"><?= $row["kws_knama"] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <select class="form-control input-sm" name="street" id="street" style="width:100%">
                        <option selected value="">Sila Pilih Jalan</option>
                      </select>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="filter"><i class="fa  fa-search"></i>
                      Saring</button>
                    <!-- <button type="button" class="btn btn-info btn-sm btn-alt ml30" id="print"><i
                        class="fa fa-print"></i>
                      Cetak</button> -->
                  </form>
                </div>
              </div>
              <div class="table-responsive">
                <form role="form" id="form-verifylists">
                  <table id="sitereviews" class="display" style="width:100%;">
                    <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <th>
                          No. Akaun <br />
                          No. Lot
                        </th>
                        <th>
                          Nama Jalan<br />
                          Jenis Hartanah
                        </th>
                        <th>
                          Luas Bangunan <br />
                          Luas Tanah <br />
                          Luas Ansolari
                        </th>
                        <th>
                          Luas Bgn Tamb. <br />
                          Luas Ans Tamb.
                        </th>
                        <th width="10%">
                          Catatan Hadapan <br />
                          Catatan Belakang
                        </th>
                        <th>Jenis Semakan</th>
                        <th>Status</th>
                        <th>Tarikh Lawatan</th>
                        <th>Pegawai</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <div class="row mt15">
                    <div class="col-lg-12 col-sm-12 col-md-12">
                      <button type="submit" class="btn btn-primary btn-sm" id="send"><i class="fa fa-send"></i> Serah ke
                        PBT</button>
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

<div class="modal fade" id="luas_popup" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="submitionareareview">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">KEMASKINI DATA LUAS TAMBAHAN</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Luas Bangunan Tambahan</label>
                <input class="form-control input-sm" type="number" value="" name="lsbgn">
                <input type="hidden" value="" name="index" id="index">
                <input type="hidden" value="" name="id" id="id">
                <input type="hidden" value="" name="akaun" id="akaun">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Luas Ansolari Tambahan</label>
                <input class="form-control input-sm" type="number" value="" name="lsans">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" name="nota" cols="30" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="submit_popup" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" id="form-submit-review">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">SERAHAN DATA</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="rujukan" class="col-sm-4 control-label">No. Rujukan</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control input-sm" id="rujukan" name="rujukan" required>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="inputEmail6" class="col-sm-4 control-label">Tarikh Serah</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control input-sm" id="tarikh" name="tarikh" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt5">
            <div class="col-md-12">
              <div class="form-group">
                <label for="inputPassword5" class="col-sm-12 control-label">Pilihan Data</label>
                <div class="col-sm-12">
                  <textarea class="form-control" rows="3" id="id" name="data" readonly></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Serah</button>
        </div>
      </form>
    </div>
  </div>
</div>