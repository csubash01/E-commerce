<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Success - UDhaarO BazzaR')]

class SuccessPage extends Component
{
    public function render()
    {
        $latest_order = Order::with('address')->where('user_id',auth()->id);

        return view('livewire.success-page');
    }
}
