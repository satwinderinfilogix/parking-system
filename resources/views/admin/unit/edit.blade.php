@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit unit</h4>

                        <div class="page-title-right">
                            <a href="{{ route('unit.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to units</a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('error')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit {{ $units->name }}</h4>
                            <form action="{{ route('unit.update',$units->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <label for="basicpill-building">Building</label>
                                        <select class="form-control select2" name="building_id" required>
                                            <option>Select</option>
                                            @foreach ($buildings as $item)
                                                <option value="{{ $item->id }}" @selected($units->building_id == $item->id)>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="basicpill-building-input">Unit name</label>
                                        <input type="text" value="{{ $units->name }}" class="form-control" name="name" id="basicpill-building-input" placeholder="Enter Unit Name" required>
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <label for="basicpill-building-input">Unit Number</label>
                                        <input type="number" value="{{ $units->unit_number }}" class="form-control" name="unit_number" id="basicpill-building-input" placeholder="Enter Unit Number" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="basicpill-building-input">Security Code</label>
                                        <input type="number" value="{{ $units->security_code }}" class="form-control" name="security_code" id="basicpill-building-input" placeholder="Enter Security Code" required>
                                    </div>
                                </div>
                                <div class="row m-4">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                </div>
                            </form>    
                        </div>    
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
@endsection