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
                                      Data Pesanan
                                    </a>
                                </h5>
                            </div>
                            <div class="col-12 col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="card-tools float-lg-right text-center text-lg-left">
                                    <ul class="nav nav-pills ml-auto justify-content-center">
                                        <li class="nav-item">
                                            <a class="btn btn-primary text-white" href='{{ url()->current() }}/done_order' >Data Pesanan Selesai</a>
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
                                        <th>Invoice</th>
                                        <th>Pembeli</th>
                                        <th>Sub Total</th>
                                        <th>Promo</th>
                                        <th>Total</th>
                                        <th>Status</th>
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
    var tabel = $('#table_data').DataTable({
        fixedColumns: true,
        serverSide: true,
        processing: true,
        autoWidth: false,
        sort: true,
        order: [],
        ajax: "{{url('order/data')}}",
        columns: [
            {data: null, render:function(data){
                return 'INV'+String(data.id).padStart(4, '0');
            }},
            {data: "users.name"},
            {data: null , render:function(data){
                return 'Rp.'+ parseInt(data.subtotals).toString().toRupiah()
            }},
            {data: null , render:function(data){
                if (data.promo == null) {
                    return '0';
                }else{
                    return data.promo.type == 'Percent' ? data.promo.value + '%' : 'Rp.'+ parseInt(data.promo.value).toString().toRupiah()
                }
            }},
            {data: null , render:function(data){
                return 'Rp.'+ parseInt(data.total_price).toString().toRupiah()
            }},
            {data: "status"},
			{data: "action", orderable: false, searchable: false, width: 50, className: "text-center"}

        ],
    });
});
</script>