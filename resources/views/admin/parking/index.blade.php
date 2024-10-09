@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Parking</h4>
                        <div class="page-title-right">
                            <a href="{{ route('parking.addNew') }}" class="btn btn-primary">Add New Parking</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('error')" />
                    <x-success-message :message="session('success')" />
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="able table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Building</th>
                                        <th>Unit Number</th>
                                        <th>Plan</th>
                                        <th>Start Date</th>
                                        <th>License Plate</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(function() {
            $('.select2').select2();

            let unitsTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/parkings/data',
                    type: 'GET',
                    data: function(d) {
                        d.building = $('#building').val();
                    }
                },
                columns: [{
                    data: null,
                        render: function(data, type, row) {
                            return `<a href="/parking-booked/${row.id}" target="blank">${row.id}</a>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.building;
                        }
                    },
                    {
                        data: 'unit_number'
                    },
                    {
                        data: 'plan'
                    },
                    {
                        data: 'start_date'
                    },
                    {
                        data: 'license_plate'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'phone_number'
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        render: function(data, type, row) {
                            let invoiceUrl = `{{ route('booked-parking', ':id') }}`.replace(':id', row.id);
                            let editUrl = `{{ route('parking.edit', ':id') }}`.replace(':id', row.id);
                            let deleteUrl = `{{ route('parking.destroy', ':id') }}`.replace(
                                ':id', row.id);

                            return `
                                <button data-path="${invoiceUrl}" class="btn btn-primary printButton">Print</button>
                                <a href="${editUrl}" class="btn btn-primary">Edit</a>
                                <form action="${deleteUrl}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            `;
                        }
                    }
                ],
                order: [[0, 'desc']]
            });

            
            $('#building').change(function() {
                const buildingId = $(this).val();
                unitsTable.ajax.reload();
            });

            $(document).on('click', '.printButton', function() {
                let invoiceUrl = $(this).data('path');

                // Create an iframe to load the content
                let $iframe = $('<iframe>', {
                    src: invoiceUrl,
                    style: 'display:none;'
                }).on('load', function() {
                    console.log(this)
                    this.contentWindow.print();
                    //$(this).remove(); // Clean up the iframe after printing
                });

                console.log('iframe', $iframe); // For debugging

                // Append the iframe to the body
                $('body').append($iframe);
            });


        })
    </script>
@endsection
