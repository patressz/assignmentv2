<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index()
    {
        if ( Cache::has('products') && Cache::has('availabilities') ) {
            $products = Cache::get('products');
            $availabilities = Cache::get('availabilities');
        } else {
            return $this->cache_data();
        }

        $categories = [
            5 => 'Erotická bielizeň',
            6 => 'Podprsenky',
            7 => 'Nohavičky',
            10 => 'Podväzky',
            11 => 'Pančuchy',
            12 => 'Harness',
            13 => 'Ramienka',
        ];

        return view('products', compact('products', 'availabilities', 'categories') );
    }

    public function show($slug)
    {
        $products = Cache::get('products');
        $availabilities = Cache::get('availabilities');

        return view('product', compact('products', 'availabilities', 'slug') );
    }

    public function cache_data()
    {
        $products = file_get_contents('https://masterfoxbo.digitalfox.sk/api/eshop/getProducts/14');
        $products = json_decode($products);
        $availabilities = file_get_contents('https://masterfoxbo.digitalfox.sk/api/eshop/getAvailability/14');
        $availabilities = json_decode($availabilities);

        Cache::put('products', $products, 60*60*24);
        Cache::put('availabilities', $availabilities, 60*60*24);

        return redirect()->route('index');
    }

    public function clear_cache()
    {
        Cache::forget('products', 'availabilities');

        return $this->cache_data();
    }
}
