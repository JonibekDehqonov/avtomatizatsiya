<x-layouts.main>
    <x-header></x-header>
    <x-slot name='title'>
        Create Order
    </x-slot>

    <main id="main" class="main">

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Default Tabs</h5>

                    <!-- Default Tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                                type="button" role="tab" aria-controls="home" aria-selected="true">
                                Основное</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false"> Таблица
                                товаров </button>
                    </ul>
                    <div class="tab-content pt-2" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <form id="orderForm" method="POST">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <div class="form-group">
                                    <input type="datetime-local" class="form-control change_date" name="date"
                                        id="date">
                                    <label for="name">Klent</label>
                                    <div class="row mb-3 d-flex">
                                        <div class="col-sm-10 ">
                                            <select class="form-select product_id" id="product-select" name="product_id"
                                                aria-label="Default select example">
                                                <option></option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" data-name="{{ $user->name }}">
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <input type="text" class="form-control" id="comment" name="comment">
                                </div>

                            </form>
                            <div class="input-checkset">
                                <label class="inputcheck">
                                    <span>Печать чека</span>
                                    <input type="checkbox" id="check1" checked="">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            {{-- end --}}
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                            {{-- start --}}

                            <div class="tab-pane fade active show" id="products" role="tabpanel"
                                aria-labelledby="tab2">
                                <div class="card">
                                    <div class="card-body">


                                        <div class="row">
                                            <div class="table-responsive">
                                                <div class="row mb-3">
                                                    <div class="col-sm-10">
                                                        <select class="form-select product_id" id="product_select"
                                                            name="product_id" aria-label="Default select example">
                                                            <Option></Option>
                                                            @foreach ($products as $product)
                                                                <option  value="{{ $product->id }}"
                                                                    data-name="{{ $product->name }}" data-price="{{ $product->price }}"data-quantity="{{ $product->quantity }}">
                                                                    {{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <table class="table table-hover" id="order_table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">№</th>
                                                            <th class="text-center">Продукт</th>
                                                            <th class="text-center">Кол-во</th>
                                                            <th class="text-center">Цена</th>
                                                            <th class="summa_column text-center">Сумма</th>
                                                            <th>actiop</th>
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
                                        </div>

                                    </div>
                                </div>
                            </div>
                            {{-- end --}}
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <a href="" class="btn btn-cancel"> <i class="fa fa-times me-2"></i> Отмена</a>
                        <button id="save" class="btn btn-submit"> <i class="fa fa-save me-2"></i> Сохранить
                        </button>
                    </div>
                </div><!-- End Default Tabs -->

            </div>
        </div>


    </main>

    {{-- Modal Orders create --}}


    </div>
    <div class="modal-footer">
    </div>
    </div>
    </div>
    </div>




    <script>
        let i=1;
        $('#product_select').change(function() {
    let productId = $(this).val();
    let productName = $(this).find(':selected').data('name');
    let productPrice= $(this).find(':selected').data('price');
    let productQuantity = $(this).find(':selected').data('quantity');

    if(productId){
        let newRow = `
                <tr data-id="${productId}">
                    <td>${i++}</td>
                    <td>${productName}</td>
                    <td><input type="number" class="quantity" value="1" min="1"></td>
                    <td class="price">${productPrice}</td>
                    <td class="total">${productPrice}</td>
                    <td><button class="btn btn-danger remove">X</button></td>
                </tr>
            `;
            $('#order_table tbody').append(newRow);
        }
});

$(document).on('input', '.quantity', function() {
        let row = $(this).closest('tr');
        let price = parseFloat(row.find('.price').text());
        let quantity = parseInt($(this).val());
        let total= (price * quantity).toFixed(2)
        row.find('.total').text(total);
        updateGrandTotal();

    });

    function updateGrandTotal() {
        let grandTotal = 0;

        $('.total').each(function() {
            let value = parseFloat($(this).text()) || 0;
            grandTotal += value;
        });

        $('#total_price').text(grandTotal.toFixed(2));
    }
    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

    $('#save').click(function() {
    const orderData = {
        user_id: $('#product-select').val(),
        date: $('#date').val(),
        comment: $('#comment').val(),
        print_check: $('#check1').is(':checked'),
        products: []
    };

    // Mahsulotlarni yig'ish
    $('#order_table tbody tr').each(function() {
        const row = $(this);
        orderData.products.push({
            product_id: row.data('id'),
            quantity: parseInt(row.find('.quantity').val()),
            price: parseFloat(row.find('.price').text())
        });
    });

    // AJAX so'rov
    $.ajax({
        url: "{{ route('orders.store') }}",
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: 'application/json',
        dataType: 'json',
        data: JSON.stringify(orderData),
        success: function(data) {
            console.log(orderData);
            if(data.message) {
                alert(data.message);
                window.location.href = '/orders';
            }
        },
        error: function(xhr) {
            console.error('Xatolik:', xhr.responseText);
        }
    });
});
    </script>
</x-layouts.main>
