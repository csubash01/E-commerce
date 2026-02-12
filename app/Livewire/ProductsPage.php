<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Products - UDhaarO BazaaR')]

class ProductsPage extends Component
{

    use WithPagination;

    #[Url]

    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];
    Public $featured = false;
    public $on_sale = false;

    #[Url]
    Public $price_range = '300000';
    public function render()
    {
        $productQuery = Product::query()->where('is_active', 1);

            if(!empty($this->selected_categories)) {
                $productQuery->whereIn('category_id', $this->selected_categories);
            }
            if(!empty($this->selected_brands)) {
                $productQuery->whereIn('brand_id', $this->selected_brands);
            }

            if($this->featured) {
                $productQuery->where('is_featured', 1);
            }

            if($this->on_sale) {
                $productQuery->where('on_sale', 1);
            }

            if($this->price_range) {
                $productQuery->whereBetween('price', [0, $this->price_range]);
            }

        return view('livewire.products-page', [
            'products' => $productQuery->paginate(9),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
