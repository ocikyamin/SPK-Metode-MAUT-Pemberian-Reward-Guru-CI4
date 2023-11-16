<div id="modal-kriteria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
           

            <div class="modal-header">
                <h4 class="modal-title">
                Edit Kriteria
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form id="form-kriteria" method="post">
                <?=csrf_field()?>
                <input type="hidden" name="id" value="<?=$data['id']?>">
                <input type="hidden" name="oldkode" value="<?=$data['kode']?>">
            <div class="modal-body">
            <div class="alert alert-light shadow-sm">
                Nilai Bobot Berdasarkan Tingkat Kepentingan / Prioritas
            </div>
            <hr>

            <div class="form-group mb-2">
                <label for="kode">Kode Kriteria</label>
                <input type="text" class="form-control" id="kode" name="kode" value="<?=$data['kode']?>" placeholder="Ex : K001">
                <div class="kode invalid-feedback"></div>
            </div>
            
            <div class="form-group mb-2">
                <label for="kriteria">Nama Kriteria</label>
                <textarea class="form-control" id="kriteria" name="kriteria" rows="4" placeholder="Ex : Pedagogik"><?=$data['kriteria']?></textarea>
                <div class="kriteria invalid-feedback"></div>
            </div>
            
            <div class="form-group">
                <label for="bobot">Bobot</label>
                <input type="text" class="form-control" id="bobot" name="bobot" value="<?=$data['bobot']?>" placeholder="1-100">
                <div class="bobot invalid-feedback"></div>
                
            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-rounded btn-sm shadow-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="btn-update" class="btn btn-primary btn-rounded btn-sm shadow-sm">Save Changes</button>
            </div>
            </form> <!-- Form //-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
 $('#form-kriteria').submit(function (e) { 
    e.preventDefault();
    $.ajax({
        type: "post",
        url: "<?=base_url('admin/kriteria/update')?>",
        data: $(this).serialize(),
        dataType: "json",
                    beforeSend: function() {
                    $('#btn-update').prop('disabled', true);
                    $('#btn-update').html(
                    `<div class="text-center"><div class="spinner-border spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                    </div></div>`
                    );
                    },
                    complete: function() {
                    $('#btn-update').prop('disabled', false);
                    $('#btn-update').html(`Save Changes`);
                    },
        success: function (response) {
            if (response.error) {
            if (response.error.kode) {
                $('#kode').addClass('is-invalid')
                $('.kode').html(response.error.kode)
            }
            if (response.error.kriteria) {
                $('#kriteria').addClass('is-invalid')
                $('.kriteria').html(response.error.kriteria)
            }
            if (response.error.bobot) {
                $('#bobot').addClass('is-invalid')
                $('.bobot').html(response.error.bobot)
            }

            } // end Error

            if (response.status) {
            $.toast({
            position :'top-right',
            heading: 'Berhasil',
            text: response.msg,
            showHideTransition: 'slide',
            hideAfter: 1000,
            icon: 'success',
            afterHidden: function () {
                $('#modal-kriteria').modal('hide')
                TableKriteria();
            }
            })
            }
        }
    });
    
 });
</script>