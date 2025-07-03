<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Admin;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first admin or create one
        $admin = Admin::first();
        
        $blogs = [
            [
                'title' => 'What information is needed for shipping?',
                'slug' => 'what-information-is-needed-for-shipping',
                'excerpt' => 'Learn about the essential information required for smooth and efficient shipping processes in e-commerce.',
                'content' => 'When it comes to shipping products, having the right information is crucial for a smooth delivery process. Here are the key details you need to provide:

**Customer Information:**
- Full name of the recipient
- Complete shipping address with postal code
- Phone number for delivery updates
- Email address for tracking notifications

**Product Details:**
- Accurate product descriptions
- Weight and dimensions
- Quantity of items
- Special handling requirements

**Shipping Preferences:**
- Preferred delivery time
- Special delivery instructions
- Signature requirements
- Insurance options

By providing complete and accurate shipping information, you ensure faster delivery times and reduce the risk of shipping errors.',
                'featured_image' => null,
                'category' => 'eCommerce',
                'author' => 'Admin Team',
                'tags' => 'shipping, delivery, ecommerce, logistics',
                'status' => 'active',
                'featured' => true,
                'views' => 156,
                'sort_order' => 1,
                'published_at' => now()->subDays(5),
                'admin_id' => $admin?->id,
            ],
            [
                'title' => 'Interesting facts about gaming consoles',
                'slug' => 'interesting-facts-about-gaming-consoles',
                'excerpt' => 'Discover fascinating facts about gaming consoles that will surprise even the most dedicated gamers.',
                'content' => 'Gaming consoles have revolutionized the entertainment industry. Here are some fascinating facts you might not know:

**Historical Facts:**
- The first gaming console was the Magnavox Odyssey, released in 1972
- Nintendo originally started as a playing card company in 1889
- The PlayStation was originally designed as a Nintendo accessory

**Technical Achievements:**
- Modern consoles are more powerful than supercomputers from the 1990s
- The Xbox Series X can process 12 teraflops of computing power
- Gaming consoles helped advance CD and DVD technology

**Market Impact:**
- The gaming industry generates more revenue than movies and music combined
- Over 3 billion people worldwide play video games
- Gaming consoles have sold over 1 billion units globally

**Fun Facts:**
- The PlayStation 2 is the best-selling console of all time with 155 million units sold
- Many famous game developers started as hobbyists
- Gaming has been proven to improve cognitive abilities and problem-solving skills

These facts show how gaming consoles have not only entertained millions but also driven technological innovation forward.',
                'featured_image' => null,
                'category' => 'Gaming',
                'author' => 'Tech Writer',
                'tags' => 'gaming, consoles, technology, facts',
                'status' => 'active',
                'featured' => false,
                'views' => 89,
                'sort_order' => 2,
                'published_at' => now()->subDays(3),
                'admin_id' => $admin?->id,
            ],
            [
                'title' => 'Electronics, instrumentation & control engineering',
                'slug' => 'electronics-instrumentation-control-engineering',
                'excerpt' => 'An overview of electronics, instrumentation, and control engineering in modern technology applications.',
                'content' => 'Electronics, instrumentation, and control engineering form the backbone of modern technological systems. This field combines multiple disciplines to create sophisticated solutions.

**Electronics Engineering:**
Electronics engineering focuses on the design and development of electronic systems and devices. Key areas include:
- Circuit design and analysis
- Semiconductor technology
- Digital and analog systems
- Power electronics
- Communication systems

**Instrumentation Engineering:**
This branch deals with measurement and control instruments:
- Sensor technology and calibration
- Data acquisition systems
- Process monitoring equipment
- Industrial automation tools
- Measurement accuracy and precision

**Control Engineering:**
Control systems ensure optimal performance of various processes:
- Feedback control systems
- Process control and optimization
- Robotics and automation
- System stability analysis
- Advanced control algorithms

**Applications:**
These fields are essential in numerous industries:
- Manufacturing and industrial automation
- Aerospace and defense systems
- Medical devices and healthcare technology
- Automotive electronics and control systems
- Smart home and IoT devices

**Career Opportunities:**
Professionals in this field can work as:
- Electronics design engineers
- Control systems engineers
- Instrumentation specialists
- Automation engineers
- Research and development engineers

The integration of these three disciplines continues to drive innovation in technology, making our world more connected and automated.',
                'featured_image' => null,
                'category' => 'Technology',
                'author' => 'Engineering Team',
                'tags' => 'electronics, engineering, instrumentation, control systems',
                'status' => 'active',
                'featured' => false,
                'views' => 234,
                'sort_order' => 3,
                'published_at' => now()->subDays(1),
                'admin_id' => $admin?->id,
            ],
        ];

        foreach ($blogs as $blogData) {
            Blog::create($blogData);
        }
    }
}
