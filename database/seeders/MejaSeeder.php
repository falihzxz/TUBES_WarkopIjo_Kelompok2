<?php

namespace Database\Seeders;

use App\Models\Meja;
use Illuminate\Database\Seeder;

class MejaSeeder extends Seeder
{
	public function run(): void
	{
		$meja_list = ['A1','A2','B1','B2','C1'];
		foreach($meja_list as $nomor){
			Meja::firstOrCreate(
				['nomor_meja' => $nomor],
				['status' => 'tersedia']
			);
		}
	}
}

