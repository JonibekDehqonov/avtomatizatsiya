<x-layouts.main>
    {{-- @section('content')   --}}
    <x-slot name='title'>
        Login
    </x-slot>
    <main>

        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form class="row g-3 needs-validation" id="handleAjax" method="POST" novalidate>
                                        <meta name="csrf-token" content="{{ csrf_token() }}">
                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" id="yourEmail"
                                                required>


                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                            {{-- @if ($errors->has('email')) --}}
                                            {{-- <span class="text-danger">{{ $errors->first('email') }}</span>
                  @endif --}}
                                        </div>


                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="#"
                                                    id="ajaxRegistor">Create an account</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>



                        </div>
                    </div>
                </div>

                <!-- Bootstrap Modal -->
                <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="errorModalLabel">Error!</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p id="error-message"></p> 
                                <ul id="error-list"></ul> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


        </div>
    </main>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on("submit", "#handleAjax", function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('post.login') }}",
                data: $(this).serialize() + "&_token=" + $('meta[name="csrf-token"]').attr('content'),
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        window.location.href = response.redirect;
                    } else {
                        let errorMessage = response.message;
                        $("#error-message").text(errorMessage); 
                        $("#error-list").html(""); 
                        if (response.errors) {
                            $.each(response.errors, function(key, val) {
                                $("#error-list").append("<li class='text-danger'>" + val +
                                    "</li>");
                            });
                        }

                        $("#errorModal").modal("show");

                    }

                }
            });

            return false;
        });
        $(document).ready(function() {
            $("#ajaxRegistor").click(function(e) {
                e.preventDefault();
                window.location.href = "{{ route('registor') }}";
            });
        });
    </script>
    {{-- @endsection --}}

</x-layouts.main>
