<x-layouts.main>
    <x-header></x-header>
    <x-slot name='title'>
        Category
    </x-slot>

    <main id="main" class="main">
        <div class="col">

            <div class="card">
                <div class="card-body">
                    {{-- content --}}
                    <div class="container mt-5">
                        <h2>Products Table</h2>
                        <button class="btn btn-success mb-2" type="button" data-bs-toggle="modal"
                            data-bs-target="#basicModal">Create</button>
                        <table id="category-table" class="table table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

    </main>
    {{-- Modal start --}}
    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" >
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pimage" class="form-label">Изображение</label>
                        <input class="form-control"  type="file" id="myfile" name="image">
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="savCategory" class="btn btn-success m-2">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="basicModalEdite" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Category Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="categoryForm" >
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="edit_name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pimage" class="form-label">Изображение</label>
                        <input class="form-control"  type="file" id="edit_myfile" name="edit_myfile">
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="savCategory" class="btn btn-success m-2">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
             // show category
             let table = $('#category-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('catrgory-data') }}",
                columns: [{
                        data: 'id'
                    },
                    { 
                        data: 'name_category',
                        render: function(data, type, row) {
                            let imgSrc = `${row.img_category}` ?? '/images/default.png'; 
                          return `<img src="${imgSrc}" width="30" height="30" style="border-radius: 50%; margin-right: 5px;"> ${data}`;
                        }
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
        });
        // create Category
            $(document).ready(function() {
            $('#savCategory').on('click', function() {
                let formData = new FormData();
                formData.append('name', $('#name').val());
                formData.append('myfile', $('#myfile')[0].files[0]); // Берем сам файл
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    url: "{{ route('category.store') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#basicModa').modal('hide');
                        $('#categoryForm')[0].reset();
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error occurred');
                    }
                });
            });
            $(document).on("click", ".edit", function() {
                let id = $(this).data('id');
                $.get(`/category/${id}/edit`, function(data) {
                    $('#edit_name').val(data.name_category),
                    // $('#edit_myfile').val(data.img_category),
                    $('#basicModalEdite').modal('show');
                });
                
            });
           
        });
    </script>
</x-layouts.main>
