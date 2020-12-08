<div class="content-header row mb-3">
    <div class="col-md-12">
        <h5>
            <i class="fas fa-user title-icon"></i> Data Pelanggan
            <a href="javascript:void(0);" id="btnTambah" class="btn btn-info float-right" data-toggle="modal"
                data-target="#modalPelanggan" role="button"><i class="fas fa-plus"></i> Tambah</a>
        </h5>
    </div>
</div>

<div class="border mb-4"></div>

<div class="row">
    <div class="col-md-12">
        <table id="tabel-pelanggan" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ID Pelanggan</th>
                    <th>Nama Pelanggan</th>
                    <th>No. HP</th>
                    <th></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- modal form data pelanggan -->
<div class="modal fade" id="modalPelanggan" tabindex="-1" role="dialog" aria-labelledby="modalPelanggan"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit title-icon"></i><span id="modalLabel"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- isi form data pelanggan -->
            <form id="formPelanggan">
                <div class="modal-body">
                    <input type="hidden" id="id_pelanggan" name="id_pelanggan">

                    <div class="form-group">
                        <label> Nama Pelanggan </label>
                        <input type="text" class="form-control" id="nama" name="nama" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label> No HP </label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" maxlength="13"
                            onkeypress="return goodchars(event, '0123456789', this)" autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-submit" id="btnSimpan">Simpan</button>
                    <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        //view
        //datatables plugins untuk membuat nomor urut tabel
        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
            return {
                "iStart": oSetting._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilterTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.cell(oSettings._iDisplayStart / oSettings._iDisplayLength)
            };
        };

        // datatables server side processing
        var table = $('#tabel-pelanggan').DataTable({
            
        })

    });
</script>