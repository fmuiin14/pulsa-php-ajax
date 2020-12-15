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
    $(document).ready(function () {
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
            "scrollY": '45vh', //vertikal scroll pada table
            "scrollCollapse": true,
            "processing": true, //tampilkan loading pada saat proses data
            "serverSide": true,
            "ajax": 'modules/pelanggan/data.php', //panggil file data.php untuk menampilkan data pelanggan dari database
            // menampilkan data
            "columnDefs": [{
                    "targets": 0,
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "width": '30px',
                    "className": 'center'
                },
                {
                    "targets": 1,
                    "visible": false
                },
                {
                    "targets": 2,
                    "width": '180px'
                },
                {
                    "targets": 3,
                    "width": '100px',
                    "className": 'center'
                },
                {
                    "targets": 4,
                    "data": null,
                    "orderable": false,
                    "searchable": false,
                    "width": '70px',
                    "className": 'center',
                    // tombol ubah dan hapus
                    "render": function (data, type, row) {
                        var btn = "<a style=\"margin-right:7px\" title=\"Ubah\" class=\"btn btn-info btn-sm getUbah\" href=\"javascript:void(0);\"><i class=\"fas fa-edit\"></i></a><a title=\"Hapus\" class=\"btn btn-danger btn-sm btnHapus\" href=\"javascript:void(0);\"><i class=\"fas fa-trash\"></i></a>";
                        return btn;
                    }
                }
            ],
            "order": [
                [1, "desc"]
            ], //urutkan data berdasarkan id_pelanggan secara desc
            "iDisplayLength": 10, //tampilkan 10 data per halaman
            // membuat nomor urut table
            "rowCallback": function (row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }

        });


        // form
        // tampilkan modal form entry data
        $('#btnTambah').click(function () {
            // reset form
            $('#formPelanggan')[0].reset();
            // judul form
            $('#modalLabel').text('Entri Data Pelanggan');
        });

        // tampilkan modal form ubah data
        $('#tabel-pelanggan tbody').on('click', '.getUbah', function () {
            // judul form
            $('#modalLabel').text('Ubah Data Pelanggan');

            var data = table.row($(this).parents('tr')).data();
            // membuat variabel untuk menampung data id_pelanggan
            var id_pelanggan = data[1];

            $.ajax({
                type: "GET", //kirim data method get
                url: "modules/pelanggan/get_data.php", //proses get data pelanggan berdasarkan id_pelanggan
                data: {
                    id_pelanggan: id_pelanggan //data yg dikirim
                },
                dataType: "JSON", //tipe data json
                success: function (result) { //ketika sukses get data
                    // tampilkan modal ubah data pelanggan
                    $('#modalPelanggan').modal('show');
                    // tampilkan data pelanggan
                    $('#id_pelanggan').val(result.id_pelanggan);
                    $('#nama').val(result.nama);
                    $('#no_hp').val(result.no_hp);
                }
            });
        });

        // insert dan update
        // proses simpan data
        $('#btnSimpan').click(function () {
            // validasi form input
            // jika nama pelanggan kosong
            if ($('#nama').val() == "") {
                // focus ke input nama pelanggan
                $("#nama").focus();
                // tampilkan peringatan data tidak boleh kosong
                swal("Peringatan!", "Nama Pelanggan tidak boleh kosong.", "warning");
            }

            // jika no hp kosong
            if ($('#no_hp').val() == "") {
                // focus ke input nama pelanggan
                $("#no_hp").focus();
                // tampilkan peringatan data tidak boleh kosong
                swal("Peringatan!", "No HP Pelanggan tidak boleh kosong.", "warning");
            } else {
                // jika form entri data pelanggan yang ditampilkan, jalanakn perintah insert
                if($('#modelLabel').text() == "Entri Data Pelanggan") {
                    var data = $('#formPelanggan').serialize();

                    $.ajax({
                        type: "POST",
                        url: "modules/pelanggan/insert.php",
                        data: data,
                        success: function(result) {
                            if(result === "sukses") {
                                // reset form
                                $('#formPelanggan')[0].reset();
                                // tutup modal entri data pelanggan
                                $('#modalPelanggan').modal('hide');
                                // tampilkan pesan sukses simpan data
                                swal("Sukses!", "Data Pelanggan berhasil di simpan.", "success");
                                // tampilkan data pelanggan
                                var table = $('#tabel-pelanggan').DataTable();
                                table.ajax.reload(null, false);
                            } else {
                                // tampilkan pesan gagal simpan data
                                swal("Gagal!", "Data Pelanggan gagal disimpan.", "Error");
                            }
                        }
                    });
                    return false;
                }

                // jika form ubah data pelanggan yang ditampilkan, jalankan perintah update
                else if ($('#modalLabel').text() == "Ubah Data Pelanggan") {
                    // variabel untuk menampung data dari form ubah data
                    var data = $('#formPelanggan').serialize();

                    $.ajax({
                        type: "POST",
                        url: "modules/pelanggan/update.php",
                        data: data,
                        success: function(result) {
                            if(result === "sukses") {
                                // reset form
                                $('#formPelanggan')[0].reset();

                                // tutup modal
                                $('#modalPelanggan').modal('hide');

                                // tampilkan pesan sukses ubah data
                                swal("Sukses!", "Data Pelanggan berhasil diubah.", "success");

                                // tampilkan data pelanggan
                                var table = $('#tabel-pelanggan').DataTable();
                                table.ajax.reload(null, false);
                            } else {
                                swal("Gagal!", "Data Pelanggan tidak bisa di ubah", "error");
                            }
                        }
                    });
                    return false;
                }
            }
        });

        // delete
        $('#tabel-pelanggan tbody').on('click', '.btnHapus', function () {
            var data = table.row($(this).parents('tr')).data();
            // tampilkan notifikasi saat akan menghapus data
            swal({
                title: "Apakah anda yakin?",
                text: "Anda akan menghapus data pelanggan : " + data[2] + "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya, Hapus!",
                closeOnConfirm: false
            },
            // jika pilih ya, maka hapus data
            function() {
                // variabel untuk menampung data id_pelanggan
                var id_pelanggan = data[1];

                $.ajax({
                    type: "POST",
                    url: "modules/pelanggan/delete.php",
                    data: {
                        id_pelanggan: id_pelanggan
                    },
                    success: function(result) {
                        if(result === "sukses") {
                            // pesan sukses hapus data
                            swal("Sukses!", "Data Pelanggan berhasil di hapus", "success");

                            // data pelanggan
                            var table = $('#tabel-pelanggan').DataTable();
                            table.ajax.reload(null, false);
                        } else {
                            // pesan gagal hapus data
                            swal("Gagal!", "Data Pelanggan tidak bisa di hapus", "error");
                        }
                    }
                });
            });
        });

    });
</script>