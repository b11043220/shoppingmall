<?php

namespace App\Console\Commands;

use App\Models\Product\Product;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class tmpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmpCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = Product::all();
        $cateIds = [3,4,5,6,7,8,9,10,11,13,14,15,16,17,18,19,20,21];
        for ($i=0; $i<500; $i++) {
            foreach ($products as $product) {
                $index = array_rand($cateIds);
                $productObj = new Product();
                $productObj->title = $product->title;
                $productObj->sub_title = $product->sub_title;
                $productObj->cate_id = $cateIds[$index];
                $productObj->market_price = $product->market_price;
                $productObj->sale_price = $product->sale_price;
                $productObj->thumb = $product->thumb;
                $productObj->bannerimgs = $product->bannerimgs;
                $productObj->captionimgs = $product->captionimgs;
                $productObj->updated_at = date('Y-m-d H:i:s');
                $productObj->created_at = date('Y-m-d H:i:s');
                $productObj->save();
            }
            $this->info($i);
        }
    }
}
