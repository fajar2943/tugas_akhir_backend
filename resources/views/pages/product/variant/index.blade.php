<x-app>
    <div class="content-wrapper">
        <section class="content py-3">
            <div class="container-fluid">
                <div class="card card-white">
                    <div class="card-header"> 
                        <div class="row">
                            <div class="col-12 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <h5 class="text-center text-lg-left">
                                    <a class="text-secondary" href={{url('dashboard')}}><i class="fas fa-home"></i></a> \
                                    <a class="text-secondary" href="#">
                                      Data Variant
                                    </a>
                                </h5>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="card-tools float-lg-right text-center text-lg-left">
                                    <ul class="nav nav-pills ml-auto justify-content-center">
                                        <li class="nav-item">
                                            <a class="btn btn-default text-black" href='{{ url('categories')}}/{{$id_categories}}/product'><i class="fa fa-arrow-left"></i> Kembali</a>
                                            <a class="btn btn-primary text-white" href='{{ url()->current() }}/form' >Tambah</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                      </div>
                    <div class="card-body">
                        <div class="container-fluid mb-4 overflow-auto">
                            <table id="table_data" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Diskon</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Gambar</th>
                                        <th>Action</th>
                                    </tr>        
                                </thead>
                              </table>
                        </div>              
                    </div>
                </div>
            </div>
         </section>
    </div>
</x-app>
<script type="text/javascript">
$(document).ready(function(){
    var CURRENT_URL = $(location).attr('href')
    var id_product = $('#id_product').val();
    var tabel = $('#table_data').DataTable({
        fixedColumns: true,
        serverSide: true,
        processing: true,
        autoWidth: false,
        sort: true,
        order: [],
        ajax: CURRENT_URL+'/data',
        columns: [
            {data: "DT_RowIndex", orderable: false, searchable: false, width: 20 ,className: "text-center"},
            {data: "name"},
            {data: null , render:function(data){
                return data.discount.type == 'Percent' ? data.discount.value + '%' : 'Rp.'+ parseInt(data.discount.value).toString().toRupiah()
            }},
            {data: null , render:function(data){
                return 'Rp.'+ parseInt(data.price).toString().toRupiah()
            }},
            {data: "stock"},
            {data: "image"},
			{data: "action", orderable: false, searchable: false, width: 50, className: "text-center"}

        ],
    });
    $('#table_data').on("click", '.btn-delete', function() {
        let id = $(this).data('id');
        let name = $(this).data('name')
        Swal.fire({
            title: 'Apakah anda yakin?',
            html: "Menghapus data " + "<b>" + name + " !</b>",
            icon: 'info',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data!',
            cancelButtonText: 'Batal'
        }).then(function(e) {
            if (e.value === true) {
                $.ajax({
                    type: 'GET',
                    url: CURRENT_URL+'/delete/' + id,
                    success: function(results) {
						tabel.ajax.reload();
                        Swal.fire("Berhasil Terhapus!", results.message, "success");
                    }
                });
            } else {
                e.dismiss;
            }

        }, function(dismiss) {
            return false;
        })
    });
});
</script>