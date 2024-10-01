<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Booked Parking Invoice</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/frontend/css/style.css') }}" rel="stylesheet" type="text/css" />
</head>

<body data-sidebar="dark">
    <div id="layout-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="row fs-3">
                                    <div class="col-sm-9 mx-auto">
                                        <div class="dashed-border">

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <address>
                                                        <strong>Building:</strong> {{ $parking->building->name }}<br>
                                                        <strong>Unit:</strong> {{ $parking->unit->unit_number }}<br>
                                                    </address>
                                                    <address>
                                                        <strong>Booking Date:</strong><br>
                                                        {{ $parking->created_at->format('d-m-Y') }}<br>
                                                    </address>
                                                </div>
                                                <div class="col-sm-6 text-sm-end">
                                                    <address>
                                                        <strong>Starts from:</strong><br>
                                                        {{ $parking->start_date }}<br>
                                                    </address>
                                                    <address>
                                                        <strong>End date:</strong><br>
                                                        @if ($parking->plan == '3days')
                                                            {{ \Carbon\Carbon::parse($parking->start_date)->addDays(3)->format('d-m-Y') }}<br>
                                                        @else
                                                            {{ \Carbon\Carbon::parse($parking->start_date)->addDays(30)->format('d-m-Y') }}<br>
                                                        @endif
                                                    </address>
                                                </div>
                                            </div>

                                            <img src="{{ route('generate-qrcode', $parking->id) }}"
                                                class="d-block mx-auto w-100" alt="QR Code">

                                        </div>

                                        @if($parking->transaction_id)
                                        <div class="mt-3">
                                            <p class="fs-5">Transaction ID: {{ $parking->transaction_id }}</p>
                                        </div>
                                        @endif

                                        <div class="py-2 mt-3">
                                            <h3 class="fs-3 fw-bold">Vehicle Details</h3>
                                        </div>
                                        <div class="table-responsive fs-4">
                                            <table class="table table-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td>Car Brand</td>
                                                        <td class="text-end">{{ $parking->car_brand }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Model</td>
                                                        <td class="text-end">{{ $parking->model }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Color</td>
                                                        <td class="text-end">{{ $parking->color }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>License Plate</td>
                                                        <td class="text-end">{{ $parking->license_plate }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()"
                                                    class="btn btn-success waves-effect waves-light me-1"><i
                                                        class="fa fa-print"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
            <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
</body>

</html>
