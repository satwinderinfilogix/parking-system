@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Units</h4>
                        <div class="page-title-right d-flex align-items-center">
                            <a href="{{ url('download-units-sample') }}" class="btn btn-primary me-2">Units Sample File</a>
                            <form id="importForm" action="{{ route('units.import') }}" method="POST" enctype="multipart/form-data" class="me-2">
                                @csrf
                                <button type="button" class="btn btn-primary" id="importButton">
                                    <i data-feather="upload" class="me-2"></i>
                                    Import Csv
                                </button>
                                <input type="file" id="fileInput" name="file" accept=".csv" style="display:none;">
                            </form>
                            <a href="{{ route('unit.create') }}" class="btn btn-primary">Add New Units</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('error')" />
                    <x-success-message :message="session('success')" />
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                            <select name="building" id="building" class="form-control select2 mb-3">
                                <option value="">All Buildings</option>
                                @foreach ($buildings as $building)
                                    <option value="{{$building->id}}">{{$building->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-body">
                            <table id="datatable" class="able table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Building Name</th>
                                        <th>Unit Name</th>
                                        <th>Unit Code</th>
                                        <th>30 Days Cost</th>
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
                    url: '/units/data',
                    type: 'GET',
                    data: function(d) {
                        d.building = $('#building').val();
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.building.name;
                        }
                    },
                    {
                        data: 'unit_number'
                    },
                    {
                        data: 'security_code'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            let cost = row['30_days_cost'];

                            if(cost < 1){
                                cost = 'FREE';
                            } else {
                                cost = `$${cost}`;
                            }

                            return cost;
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        render: function(data, type, row) {
                            let editUrl = `{{ route('unit.edit', ':id') }}`.replace(':id', row
                                .id);
                            let deleteUrl = `{{ route('unit.destroy', ':id') }}`.replace(
                                ':id', row.id);

                            return `
                                <a href="${editUrl}" class="btn btn-primary">Edit</a>
                                <form action="${deleteUrl}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            `;
                        }
                    }
                ]
            });

            
            $('#building').change(function() {
                const buildingId = $(this).val();
                unitsTable.ajax.reload();
            });
        })

        $(document).ready(function() {
            $('#importButton').on('click', function() {
                $('#fileInput').click();
            });

            $('#fileInput').on('change', function(event) {
                var file = $(this).prop('files')[0];
                if (file && file.type === 'text/csv') {
                    $('#importForm').submit();
                } else {
                    alert('Please select a valid CSV file.');
                }
            });
        });
    </script>
@endsection
