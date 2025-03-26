<x-layouts.main>
    <x-header></x-header>

    {{-- @dd($categorys); --}}

    <main id="main" class="main">

        <div class="col">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Table with stripped rows</h5>

                    <div class="container mt-5">
                        <h2>Products Table</h2>
                        <button class="btn btn-success mb-2" type="button" data-bs-toggle="modal"
                            data-bs-target="#basicModal">Create</button>
                        <table id="products-table" class="table table-striped data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
         </main>

    <!-- Modal Start  create-->
    <!-- Modal Start - Create -->
    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" id="price" name="price" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" id="stock" name="stock" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Category</label>
                            <select class="form-select category_id" id="category_select" name="category_id">
                            <option></option>
                            @foreach ($categorys as $category)
                                <option id="category" value="{{ $category->id }}" data-name="{{ $category->name_category }}"data-id="{{ $category->id }}">
                                    {{ $category->name_category }}
                                </option>
                            @endforeach
                            </select>
                         
                        </div>
                        <div class="form-group">
                            <label for="pimage" class="form-label">Изображение</label>
                            <input class="form-control"  type="file" id="image"  name="image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveProduct">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Start - Update -->
    <div class="modal fade" id="basicModalEdite" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editeForm">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <input type="hidden" id="product_id" name="product_id">
                        <div class="form-group">
                            <label for="edit_name">Name</label>
                            <input type="text" id="edit_name" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_price">Price</label>
                            <input type="number" step="0.01" id="edit_price" name="price" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_stock">Stock</label>
                            <input type="number" id="edit_stock" name="stock" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Category</label>
                            <select class="form-select category_id" id="category_update" name="category_id">
                            <option></option>
                            @foreach ($categorys as $category)
                                <option id="category" value="{{ $category->id }}" data-name="{{ $category->name_category }}"data-id="{{ $category->id }}">
                                    {{ $category->name_category }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pimage" class="form-label">Изображение</label>
                            <input class="form-control"  type="file" id="edit_image" name="image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editeProduct">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->
    <script>
        $(document).ready(function() {
            let table = $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products-data') }}",
                columns: [{
                        data: 'id'
                    },
                    { 
                        data: 'name',
                        render: function(data, type, row) {
                            let imgSrc = row.image ? `${row.image}` : '/images/default.png'; // Agar rasm mavjud bo'lmasa, default rasm qo'yiladi
                            return `<img src="${imgSrc}" width="30" height="30" style="border-radius: 50%; margin-right: 5px;"> ${data}`;
                        }
                    },
                    
                    {
                        data: 'price'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return data ? new Date(data).toLocaleString() : '';
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                scrollX: true,
                autoWidth: false,
            });

            // Create Product
            $('#saveProduct').on('click', function() {
                // let category = $('#category_select').find(':selected').data('name');
                // alert(category);
                let formData = new FormData();
                    formData.append('name', $('#name').val());
                    formData.append('price', $('#price').val());
                    formData.append('stock', $('#stock').val());
                    formData.append('category_id', $('#category_select').val());
                    formData.append('image', $('#image')[0].files[0]); // Faylni qo'shish
                    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));


                $.ajax({
                    url: "{{ route('products.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,  
                    processData: false,  
                    success: function() {
                        $('#basicModal').modal('hide');
                        $('#productForm')[0].reset();
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log('Xatolik javobi:', xhr.responseText);
                       console.log('Status:', status);
                     console.log('Error:', error);
    }
                });
            });

            // Edit Product
            $(document).on("click", ".edit", function() {
                let id = $(this).data('id');
                $.get(`/products/${id}/edit`, function(data) {
                    $('#product_id').val(data.id);
                    $('#edit_name').val(data.name);
                    $('#edit_price').val(data.price);
                    $('#edit_stock').val(data.stock);
                    $('#category_update').val(data.category_id);
                    $('#basicModalEdite').modal('show');
                });
            });

            // Update Product
            $('#editeProduct').on('click', function() {
                let id = $('#product_id').val();
                let formData = new FormData(); // Fayllar uchun FormData ishlatami
                formData.append('_method', 'PUT'); // Laravel PATCH yoki PUT uchun
                formData.append('name', $('#edit_name').val());
                formData.append('price', $('#edit_price').val());
                formData.append('stock', $('#edit_stock').val());
                formData.append('category_id', $('#category_update').val());
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                let image = $('#edit_image')[0].files[0];
                if (image) {
                    formData.append('image', image);
                     }
                $.ajax({
                    url: `/products/${id}`,
                    type: "POST",
                    data: formData,
                    contentType: false,  
                    processData: false,
                    success: function() {
                        // console.log(data);
                        $('#basicModalEdite').modal('hide');
                        $('#editeForm')[0].reset();
                        table.ajax.reload();
                    },
                    error: function() {
                        alert('Error occurred');
                    }
                });
            });

            // Delete Product
            $(document).on("click", ".delete", function() {
                let id = $(this).data('id');
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: `/products/${id}`,
                        type: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: "DELETE"
                        },
                        success: function() {
                            table.ajax.reload();
                        },
                        error: function() {
                            alert("Error occurred");
                        }
                    });
                }
            });
        });
    </script>
</x-layouts.main>
