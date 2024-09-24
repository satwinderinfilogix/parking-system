<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DataTable extends Component
{
    public $data;
    public $columns;
    public $editRoute;
    public $deleteRoute;

    public function __construct($data, $columns, $editRoute = null, $deleteRoute = null)
    {
        $this->data = $data;
        $this->columns = $columns;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
    }

    public function render()
    {
        return view('components.data-table', [
            'data' => $this->data,
            'columns' => $this->columns,
            'editRoute' => $this->editRoute,
            'deleteRoute' => $this->deleteRoute,
        ]);
    }
}
