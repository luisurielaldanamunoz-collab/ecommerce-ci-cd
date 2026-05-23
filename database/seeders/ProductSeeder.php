<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name'=>'Camiseta shooting','slug'=>'camiseta-shooting','description'=>'Camiseta cómoda para uso diario.','price'=>1999,'image'=>'https://picsum.photos/seed/p1/640/480','inventory'=>50],
            ['name'=>'Pantalón urban','slug'=>'pantalon-urban','description'=>'Pantalón resistente con estilo urbano.','price'=>4999,'image'=>'https://picsum.photos/seed/p2/640/480','inventory'=>20],
            ['name'=>'Zapatillas running','slug'=>'zapatillas-running','description'=>'Máxima amortiguación en cada paso.','price'=>8999,'image'=>'https://picsum.photos/seed/p3/640/480','inventory'=>30],
            ['name'=>'Chaqueta adaptativa','slug'=>'chaqueta-adaptativa','description'=>'Para clima frío y con forro interior cálido.','price'=>7599,'image'=>'https://picsum.photos/seed/p4/640/480','inventory'=>15],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['slug'=>$product['slug']], $product);
        }
    }
}
