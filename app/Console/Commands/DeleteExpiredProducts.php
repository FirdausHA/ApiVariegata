<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Carbon\Carbon;

class DeleteExpiredProducts extends Command
{

    protected $signature = 'productcrousell:delete';
    protected $description = 'Delete expired products';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Hapus produk yang waktu kedaluwarsa lebih awal dari waktu saat ini
        Product::where('expiry_time', '<', Carbon::now())->delete();
        $this->info('Expired products deleted successfully.');
    }

}
