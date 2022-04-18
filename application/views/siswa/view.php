<section class="content">
    <div class="row">

        <!-- filter data-->
        <div class="col-xs-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Filter Data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Jurusan</td>
                        <td>
                            <?php echo cmb_dinamis('jurusan', 'tbl_jurusan', 'nama_jurusan', 'kd_jurusan', null, "id='filter_jurusan' onChange='loadKelas()'") 
                            ?>        
                        </td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>    
                            <div id="kelas"></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"> 
                           <?php
                                echo anchor('siswa/add', '<button class="btn bg-navy btn-flat margin">Tambah Data</button>');
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <!-- data tabel siswa -->
        <div class="col-xs-12">
          <div class="box box-primary">
                <div class="box-header  with-border">
                    <h3 class="box-title">Data Table Siswa</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <div id="dataSiswa"></div>

                </div>
                <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<script>
    function loadKelas()
    {
        //var tingkatan_kelas = $("#filter_tingkatan").val();
        var jurusan         = $("#filter_jurusan").val();
        
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>kelas/combobox_kelas',
            data    : 'kd_jurusan='+jurusan,
            success : function(html) {
                $("#kelas").html(html);
                var kelas   = $("#cbkelas").val();
                loadSiswa(kelas);
            }
        })
    }

    function loadSiswa(kelas)
    {   
        var kelas   = $("#cbkelas").val();
        $.ajax({
            type    : 'GET',
            url     : '<?php echo base_url() ?>siswa/loadDataSiswa',
            data    : 'kd_kelas='+kelas,
            success : function(html) {
                $("#dataSiswa").html(html);
            }
        })
    }

</script>

<script type="text/javascript">
    $(document).ready(function(){
        loadKelas();
    });
</script>