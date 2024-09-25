<table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th>{{ ucfirst($column) }}</th>
            @endforeach
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                @foreach ($columns as $column)
                    <td>{{ $item->$column }}</td>
                @endforeach
                <td>
                    @if($editRoute)
                        <a href="{{ route($editRoute, $item->id) }}" class="btn btn-primary">Edit</a>
                    @endif
                    @if($deleteRoute)
                        <form action="{{ route($deleteRoute, $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>