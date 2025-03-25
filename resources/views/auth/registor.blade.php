<x-layouts.main>
    <x-slot name='title'>
        Registration
    </x-slot>
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                                        <p class="text-center small">Enter your personal details to create account</p>
                                    </div>

                                    <form class="row g-3 needs-validation" id="handleAjax"
                                        method="POST" >
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <div class="col-12">
                                            <label for="yourName" class="form-label">Your Name</label>
                                            <input type="text" name="name" class="form-control" id="yourName"
                                                required>
                                            <div class="invalid-feedback">Please, enter your name!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourEmail" class="form-label">Your Email</label>
                                            <input type="email" name="email" class="form-control" id="yourEmail"
                                                required>
                                            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100"  type="submit">Create
                                                Account</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already have an account? <a
                                                    href="#" id="ajaxLogin">Log in</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>



                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>
    <script type="text/javascript">
        $(document).on("submit", "#handleAjax", function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('post.registor') }}",
                // data:  $(this).serialize() + '_token='  $('meta[name="csrf-token"]').attr('content'),
                data: $(this).serialize() + "&_token=" + $('meta[name="csrf-token"]').attr('content'),
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        window.location.href = response.redirect;
                    } else {
                        $(".alert").remove();
                        $.each(response.errors, function(key, val) {
                            $("#errors-list").append("<div class='alert alert-danger'>" + val +
                                "</div>");
                            });
                        }

                    }
                });

                return false;
            });

    $(document).ready(function () {
        $("#ajaxLogin").click(function (e) {
        e.preventDefault();
        window.location.href = "{{ route('login') }}"; 
    });
    });
    </script>
</x-layouts.main>
