<?= $this->extend('Supervisor/Layouts') ?>
<?= $this->section('content') ?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Penilaian</li>
                </ol>
            </div>
            <h4 class="page-title">Penilaian</h4>
        </div>

    </div>
</div>
<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card ribbon-box shadow-sm mt-2">
            <div class="card-body">
                <div class="ribbon ribbon-success float-start shadow-sm"><i class="mdi mdi-table me-1"></i> Perhitungan
                    Metode MAUT</div>
                <div class="ribbon-content">

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="periode_id">Periode Penilaian</label>
                                <select id="periode_id" class="form-control mb-3">
                                    <option value="">Periode Penilaian</option>
                                    <?php
                        if (!empty(Periode())) {
                            foreach (Periode() as $p) {
                               ?>
                                    <option value="<?=$p['id']?>" <?=$p['is_active']==1 ? 'selected' : null ?>>
                                        <?=$p['tahun_akademik']?> - <?=$p['periode']?></option>
                                    <?php
                            }
                        }

                        ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-lg-4 mt-3 mb-2">
                            <button onclick="CetakLaporan()" class="btn-cetak btn btn-info">Cetak</button>
                        </div>
                    </div>

                    <div id="table_nilai_alternatif"></div>

                </div>
            </div>
        </div> <!-- Card -->
    </div>
</div>
<!--Row-->

<script>
var periodeAktif = $('#periode_id').val(); // Mendapatkan nilai awal periode
$(document).ready(function() {
    TableNilaiAlternatif(periodeAktif); // Memanggil fungsi dengan nilai awal periode
    $('#periode_id').change(function(e) {
        e.preventDefault();
        // Lakukan sesuatu saat terjadi perubahan
        periodeAktif = $(this).val(); // Mengambil nilai yang baru dipilih
        TableNilaiAlternatif(periodeAktif); // Memanggil fungsi dengan periode yang baru dipilih
    });
});

function TableNilaiAlternatif(periode_id) {
    $.ajax({
        url: "<?=base_url('superv/skors/nilai-alternatif')?>",
        data: {
            periode_id: periode_id
        },
        dataType: "json",
        success: function(response) {
            $('#table_nilai_alternatif').html(response.list_alternatif);
        }
    });
}

// Cetak 
$('#periode_id').change(function(e) {
    e.preventDefault();
    if ($(this).val() !== "") {
        $('.btn-cetak').removeClass('d-none')
    } else {
        $('.btn-cetak').addClass('d-none')
    }

});

function CetakLaporan() {
    const periode_id = $('#periode_id').val();
    const sekolah_id = <?=UserLogin()->sekolah_id?>;
    if (periode_id == "" || sekolah_id == "") {
        alert('Periode Penilian Atau Sekolah Belum dipilih.')
    } else {
        const url = `<?= base_url('report/pkg/') ?>${periode_id}/${sekolah_id}`;
        const newTab = window.open(url, '_blank');
        if (newTab) {
            newTab.focus(); // Fokuskan tab baru jika berhasil dibuka
        } else {
            // Jika browser memblokir popup, berikan pesan ke pengguna
            alert('Popup diblokir oleh browser. Silakan izinkan pop-up untuk membuka laporan.');
        }
    }


}
</script>


<?= $this->endSection() ?>