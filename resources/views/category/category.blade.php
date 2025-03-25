<x-layouts.main>
    <x-header></x-header>    
    <x-slot name='title'>
        Category
    </x-slot>

<main id="main" class="main">
    <div class="col">

        <div class="card">
            <div class="card-body">
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
                    <button type="button" id="savCategory" class="btn btn-success m-2">Save</button>
                </form>
            </div>
        </div>

</main>
<script>
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
            success: function (response) {
                  console.log(response);
                  if (response.status) {
                      window.location.href = response.redirect;
                  }else{
                      $(".alert").remove();
                      $.each(response.errors, function (key, val) {
                          $("#errors-list").append("<div class='alert alert-danger'>" + val + "</div>");
                      });
                  }

                },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Error occurred');
            }
        });
    });
});
;
</script>
</x-layouts.main>   