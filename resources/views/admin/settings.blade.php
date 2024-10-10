@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Settings</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-danger" id="resetParkingButton">Reset 3 days parkings</button>
                </div>
            </div>

            <x-success-message :message="session('success')" />

            <div class="card mt-4">
                <div class="card-body">
                    <form action="{{ route('password.reset') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-2">
                                <x-form-input type="password" name="change_password" label="Change Password"></x-form-input>
                            </div>
                            <div class="col-12">
                                <x-form-input type="password" name="change_password_confirmation" label="Confirm Password"></x-form-input>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary mt-2">Save Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#resetParkingButton').click(function() {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Once reset, you will not be able to recover the parking data!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, reset it!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Perform the reset action here
                            $.ajax({
                                url: '/api/reset-free-parkings',
                                method: 'POST',
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire(
                                            'Success!',
                                            `${response.resetParkingsCount} Parkings has been reset!`,
                                            'success'
                                        );
                                    } else {
                                        swal("Something went wrong!");
                                    }
                                }
                            })
                            /* Swal.fire(
                                'Success!',
                                'Parking data has been reset!',
                                'success'
                            ); */
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
