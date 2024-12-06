<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PurchaseProvidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('purchase_providers')->delete();
        
        \DB::table('purchase_providers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'rfc' => '1234456',
                'company_name' => 'proveedor 1',
                'street' => 'Aliquid qui quas veritatis in eligendi sed similique necessitatibus in voluptas facilis in harum accusamus dolores rerum accusantium iste laudantium',
                'number' => '24',
                'neighborhood' => 'Ut rem maxime in nisi dolore inventore est ut enim consequat Magni quia',
                'municipality' => 'Consectetur aliquip porro occaecat et nostrum ex',
                'state' => 'Esse amet ut minus delectus a voluptate dolore harum placeat adipisci veniam voluptatem iusto delectus rerum saepe iure eu',
                'country' => 'Nam cupidatat ex esse esse soluta numquam dolores aliquip dolore aliquip qui non voluptate',
                'cp' => 'Eu quod qu',
                'web_company' => 'Waller Talley Inc',
                'status' => 'rechazado',
                'user_request_id' => 199,
                'user_approve_id' => NULL,
                'created_at' => '2024-12-03 16:29:40',
                'updated_at' => '2024-12-03 17:12:45',
            ),
            1 => 
            array (
                'id' => 2,
                'rfc' => '3545465',
                'company_name' => 'proveedor 2',
                'street' => 'Excepturi exercitation quis quibusdam libero eligendi eum praesentium id in tempor vero qui est vitae nisi optio adipisicing et',
                'number' => '860',
                'neighborhood' => 'Magni omnis quis aut sed qui neque aut sint quas adipisci optio atque laudantium alias ut aut reprehenderit',
                'municipality' => 'Quis dolores cillum error tempore placeat sed voluptate qui quia deserunt quis ex corporis quae ducimus aut',
                'state' => 'Quaerat nihil itaque pariatur Cupiditate voluptas quibusdam consectetur nostrum iure quis sint voluptas eiusmod inventore proident in',
                'country' => 'Velit et aliquam magnam placeat optio fugiat dolorem accusantium',
                'cp' => 'Quae asper',
                'web_company' => 'Knight Baldwin LLC',
                'status' => 'rechazado',
                'user_request_id' => 52,
                'user_approve_id' => NULL,
                'created_at' => '2024-12-03 17:11:27',
                'updated_at' => '2024-12-03 17:12:58',
            ),
            2 => 
            array (
                'id' => 3,
                'rfc' => '08909789',
                'company_name' => 'proveerdor 3',
                'street' => 'Sed anim et et dicta iure quibusdam praesentium rem natus',
                'number' => '851',
                'neighborhood' => 'Alias nulla explicabo Dolor labore et fugiat non ipsum dolor officiis dignissimos id',
                'municipality' => 'Sint eu laborum aut fuga Duis dolores laboriosam necessitatibus molestias',
                'state' => 'Et labore odit id nisi distinctio Mollitia deserunt alias',
                'country' => 'Consequatur Enim nisi culpa deserunt tempora esse iste molestias aut quidem et',
                'cp' => 'Tempore v',
                'web_company' => 'Gaines and Ward LLC',
                'status' => 'aprobado',
                'user_request_id' => 274,
                'user_approve_id' => NULL,
                'created_at' => '2024-12-03 17:12:14',
                'updated_at' => '2024-12-03 17:13:10',
            ),
        ));
        
        
    }
}