<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Maker;
use App\User;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		Maker::truncate();
		User::truncate();
		DB::table('oauth_clients')->truncate();
		Model::unguard();

		$this->call('MakerSeed');
		$this->call('VehiclesSeed');
		$this->call('UsersSeed');
		$this->call('OauthClientSeed');
	}

}
