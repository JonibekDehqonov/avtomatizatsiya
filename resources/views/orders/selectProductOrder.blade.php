<x-layouts.main>
    <x-slot name='title'>
        Sepect Order
    </x-slot>
    <x-header></x-header>
<main id="main" class="main">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Table with stripped rows</h5>
            </div>
            <div class="container mt-5">
                <h2> Select Order Table</h2>
                <table id="selectOrder" class="table table-striped data-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-arrow-repeat refresh-table"></i> </th> <!-- ID yoki refresh -->
                            <th>Data</th> <!-- Sana (date) -->
                            <th>Name</th> <!-- Foydalanuvchi ismi (user_name) -->
                            <th>Comment</th> <!-- Izoh -->
                            <th>Price</th> <!-- Narx (total) -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>




        </div>
    </div>
    {{-- <div id="order-modal" style="display:none; position:fixed; top:20%; left:30%; background:#fff; padding:20px; border:1px solid black;">
        <h3>Buyurtma Tafsilotlari</h3>
        <div id="order-details"></div>
        <button onclick="$('#order-modal').hide()">Yopish</button>
    </div> --}}
</main>
{{--Modal stars  --}}
<div class="modal fade" id="modalShow" tabindex="-1">
    <div class="modal-dialog ">
        <div class="modal-content close">
            <div class="modal-header">
                <h5 class="modal-title">Product Form</h5>
                <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover" id="order_table">
                    <thead>
                        <tr>
                            <th class="text-center">Продукт</th>
                            <th class="text-center">Кол-во</th>
                            <th class="text-center">Цена</th>
                        </tr>

                    </thead>
                    <tbody id="table_data">
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="5" class="text-center" id="totaltable">
                                ИТОГО</th>
                            <th class="text-center summa_column" id="total_price">
                                0
                            </th>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close" id="btn-close" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
{{-- model end --}}
<script>
    $(document).ready(function(){
        let table = $('#selectOrder').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders-data') }}",
        columns: [
            {data: 'action', orderable: false, searchable: false},
            {data: 'date', name: 'date'},
            {data: 'user_name', name: 'user_name'},
            {data: 'comment', name: 'comment'},
            {data: 'total', name: 'total'},
        ],
        scrollX: true,
        autoWidth: false,
    });

         $(document).on('click','.close', function(){
          $('#table_data').html('');
  
        });
        $(document).on('click','.show', function(){
            let id= $(this).data('id');
          
            $.get(`/orders/${id}`, function(data){
              
                    let orderInfo = '';
                            data.forEach(item => {
                      
                                    orderInfo +=`<tr>
                                        <td>${item.product.name}</td>
                                        <td>${item.quantity}</td>
                                        <td>${item.price}</td>
                                    </tr>`
                                  
                                });
                      

                                $("#table_data").append(orderInfo);
                        $("#modalShow").modal('show');
                });

        });
});

</script>



</x-layouts.main>
