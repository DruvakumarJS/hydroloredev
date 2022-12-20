<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Questions;

use Illuminate\Support\Facades\Hash;


class QuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
               ['question'=>"I'm having technical issues regarding the POD"],
               ['question'=>"I'm having issues with the plants"],
               ['question'=>"I need to replenish my plants in the POD"],
               ['question'=>"It's working well, but need guidance"]
            ];
            foreach ($data as $key => $value) {
               Questions::create($value);
           }
        

    }
}
