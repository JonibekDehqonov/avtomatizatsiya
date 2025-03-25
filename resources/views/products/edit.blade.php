<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Basic Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="editeForm">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <div class="form-gro formDataup">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" id="price" name="price"
                            class="form-control"required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" class="form-control" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
  $('#editeForm').submit(function(e) {
                    e.preventDefault();
                    let formData = {
                        name: $('#name').val(),
                        price: $('#price').val(),
                        stock: $('#stock').val(),
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: "PUT"
                    };
                    console.log('.editeForm');
                    if (editId) {
                        $.ajax({
                            url: `/products/${editId}`,
                            type: "POST",
                            data: formData,
                            success: function() {
                                alert('success');
                                $('#basicModal').modal('hide');
                                
                                // location.reload();
                            },
                            error: function() {
                                alert("Update error!");
                            }
                        });
                    }
                });
      



</script>