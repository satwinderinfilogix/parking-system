@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Units</h4>
                        <div class="page-title-right">
                            <a href="{{ route('unit.create') }}" class="btn btn-primary">Add New Units</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('error')" />
                    <x-success-message :message="session('success')" />

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
    </script>
@endsection
