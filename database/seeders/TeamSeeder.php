<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name' => 'Grace Wright',
            'position' => 'Chief Executive Officer',
            'bio' => 'With over 15 years of experience in e-commerce and business development, Grace leads our team with vision and passion. She is committed to driving innovation and ensuring customer satisfaction.',
            'image' => '/frontend/assets/images/team/team1.jpg',
            'facebook' => 'https://facebook.com/gracewright',
            'twitter' => 'https://twitter.com/gracewright',
            'linkedin' => 'https://linkedin.com/in/gracewright',
            'skype' => 'grace.wright',
            'sort_order' => 1,
            'is_active' => true
        ]);

        Team::create([
            'name' => 'Taylor Jackson',
            'position' => 'Financial Director',
            'bio' => 'Taylor brings extensive expertise in financial planning and strategic business management. She ensures our financial stability and growth while maintaining transparent operations.',
            'image' => '/frontend/assets/images/team/team2.jpg',
            'facebook' => 'https://facebook.com/taylorjackson',
            'twitter' => 'https://twitter.com/taylorjackson',
            'linkedin' => 'https://linkedin.com/in/taylorjackson',
            'skype' => 'taylor.jackson',
            'sort_order' => 2,
            'is_active' => true
        ]);

        Team::create([
            'name' => 'Quinton Cross',
            'position' => 'Marketing Director',
            'bio' => 'Quinton is a creative marketing strategist who drives our brand presence and customer engagement. His innovative campaigns have helped us reach millions of customers worldwide.',
            'image' => '/frontend/assets/images/team/team3.jpg',
            'facebook' => 'https://facebook.com/quintoncross',
            'twitter' => 'https://twitter.com/quintoncross',
            'linkedin' => 'https://linkedin.com/in/quintoncross',
            'skype' => 'quinton.cross',
            'sort_order' => 3,
            'is_active' => true
        ]);

        Team::create([
            'name' => 'Liana Mullen',
            'position' => 'Lead Designer',
            'bio' => 'Liana is our creative genius who designs beautiful and user-friendly experiences. Her attention to detail and artistic vision make our platform both functional and aesthetically pleasing.',
            'image' => '/frontend/assets/images/team/team4.jpg',
            'facebook' => 'https://facebook.com/lianamullen',
            'twitter' => 'https://twitter.com/lianamullen',
            'linkedin' => 'https://linkedin.com/in/lianamullen',
            'skype' => 'liana.mullen',
            'sort_order' => 4,
            'is_active' => true
        ]);
    }
}
