<?php

namespace App\Livewire\Order\Index;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Store;

class Chart extends Component
{
    public Store $store;
    public $dataset = [];

    public function fillDataset()
    {
        $this->store = Store::find(1);

        $results = $this->store->orders()
            ->select(
                DB::raw("DATE_FORMAT(ordered_at, '%Y-%m') as increment"),
                DB::raw('SUM(amount) as total'),
            )
            ->groupBy('increment')
            ->get();

        $this->dataset['values'] = $results->pluck('total')->toArray();
        $this->dataset['labels'] = $results->pluck('increment')->toArray();
    }

    public function render()
    {
        $this->fillDataset();
        return view('livewire.order.index.chart');
    }

    public function placeholder()
    {
        return view('livewire.order.index.chart-placeholder');
    }
}
