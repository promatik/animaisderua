<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FriendCardModalitiesSeeder extends Seeder
{
	private const MONTHLY = 'monthly';
	private const YEARLY = 'yearly';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();

		DB::table('friend_card_modalities')->truncate();

        DB::table('friend_card_modalities')->insert([
	        [
	        	'name' => json_encode([
		            'pt' => 'Modalidade básica',
		            'en' => 'Basic'
		        ]),
	        	'description' => json_encode([
		            'pt' => 'O aderente tem direito ao cartão (renovável todos os anos), com todos os descontos disponíveis.',
		            'en' => ''
		        ]),
	        	'paypal_code' => 'Op. 1',
	        	'amount' => 3,
	        	'type' => self::MONTHLY,
	        	'created_at' => $date,
	        	'updated_at' => $date
	    	],
	        [
	        	'name' => json_encode([
		            'pt' => 'Modalidade básica',
		            'en' => 'Basic'
		        ]),
	        	'description' => json_encode([
		            'pt' => 'o aderente tem direito ao cartão (renovável todos os anos), com todos os descontos disponíveis e recebe a agenda da Animais de Rua do ano seguinte.',
		            'en' => ''
		        ]),
	        	'paypal_code' => 'Op. 2',
	        	'amount' => 36,
	        	'type' => self::YEARLY,
	        	'created_at' => $date,
	        	'updated_at' => $date
	    	],
	        [
	        	'name' => json_encode([
		            'pt' => 'Modalidade intermédia',
		            'en' => 'Intermediate'
		        ]),
	        	'description' => json_encode([
		            'pt' => 'O aderente tem direito ao cartão (renovável todos os anos), com todos os descontos disponíveis e recebe a agenda da Animais de Rua do ano seguinte, juntamente com um cheque-oferta da Loja da Animais de Rua no valor de 10€.',
		            'en' => ''
		        ]),
	        	'paypal_code' => 'Op. 3',
	        	'amount' => 5,
	        	'type' => self::MONTHLY,
	        	'created_at' => $date,
	        	'updated_at' => $date
	    	],
	        [
	        	'name' => json_encode([
		            'pt' => 'Modalidade intermédia',
		            'en' => 'Intermediate'
		        ]),
	        	'description' => json_encode([
		            'pt' => 'O aderente tem direito ao cartão (renovável todos os anos), com todos os descontos disponíveis, recebe a agenda da Animais de Rua do ano seguinte, juntamente com um cheque-oferta da Loja da Animais de Rua no valor de 15€.',
		            'en' => ''
		        ]),
	        	'paypal_code' => 'Op. 4',
	        	'amount' => 60,
	        	'type' => self::YEARLY,
	        	'created_at' => $date,
	        	'updated_at' => $date
	    	],
	        [
	        	'name' => json_encode([
		            'pt' => 'Modalidade avançada',
		            'en' => 'Advanced'
		        ]),
	        	'description' => json_encode([
		            'pt' => 'O aderente tem direito ao cartão (renovável todos os anos), com todos os descontos disponíveis e recebe a agenda da Animais de Rua do ano seguinte, juntamente com um cheque-oferta da Loja da Animais de Rua no valor de 20€.',
		            'en' => ''
		        ]),
	        	'paypal_code' => 'Op. 5',
	        	'amount' => 15,
	        	'type' => self::MONTHLY,
	        	'created_at' => $date,
	        	'updated_at' => $date
	    	],
	        [
	        	'name' => json_encode([
		            'pt' => 'Modalidade avançada',
		            'en' => 'Advanced'
		        ]),
	        	'description' => json_encode([
		            'pt' => 'O aderente tem direito ao cartão (renovável todos os anos), com todos os descontos disponíveis, recebe a agenda da Animais de Rua do ano seguinte, juntamente com um cheque-oferta da Loja da Animais de Rua no valor de 25€.',
		            'en' => ''
		        ]),
	        	'paypal_code' => 'Op. 6',
	        	'amount' => 180,
	        	'type' => self::YEARLY,
	        	'created_at' => $date,
	        	'updated_at' => $date
	    	],
    	]);

    }
}