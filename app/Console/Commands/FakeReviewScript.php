<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Console\Command;

class FakeReviewScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fake-review-script';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function generateEnglishReview($rating)
    {
        if ($rating == 5) {
            // 5 STAR - EXCELLENT
            $openings = [
                'Excellent quality product! Totally exceeded my expectations.',
                'Best in class efficiency and performance. Really happy with the purchase.',
                'Absolutely delighted with this item. It is exactly as shown in the images.',
                'Genuine review after using it for 10 days: This is a masterpiece.',
                'Superb quality and value for money. A must-buy for everyone.',
                'Latest model with premium finish. Adds a great look to my collection.',
                'I was searching for this quality for a long time, finally found it here.',
                'Mind-blowing performance! I am fully satisfied with the results.',
                'Bought this as a gift for my family, and they absolutely loved it.',
                'Packaging was excellent and the product looks very premium.',
                'Five stars are not enough for this product, it is that good.',
                'Simply the best in this price range. Nothing comes close.',
                'Wow! The quality is far better than what I saw in local markets.',
                'Very impressed with the fast shipping and the authenticity of the item.',
                'This product is a game-changer. Highly effective and durable.',
                'Just received it today and the first impression is fantastic.',
                'The design is sleek, modern, and very practical for daily use.',
                'Exceptional build quality. You can feel the sturdiness instantly.',
                'A perfect combination of style and functionality.',
            ];
            $bodies = [
                'The build quality is sturdy and feels very premium in hand. Works perfectly without any lag.',
                'It works flawlessly even under heavy usage. The features are very user-friendly.',
                "The fabric is soft, lightweight, and very comfortable. Colors haven't faded even after washing.",
                'Service quality is super and installation was done on time. The team was very professional.',
                'Connectivity is fast and it matches all the specifications mentioned in the description.',
                'I was skeptical at first, but the performance is top-notch. It handles everything smoothly.',
                'The battery backup is amazing, lasts much longer than claimed by the company.',
                'Installation was a breeze. I set it up myself in less than 10 minutes.',
                'The fitting is perfect, feels like it was custom made for me.',
                'Sound quality is crystal clear with good bass. A treat for music lovers.',
                'It is very energy efficient and does not heat up even after long hours of use.',
                'The texture is smooth and the stitching is top-notch. No loose threads anywhere.',
                'Customer support was very helpful when I had a small query regarding the setup.',
                'The storage capacity is sufficient and the read/write speeds are impressive.',
                'It looks very elegant in the living room. Matches perfectly with the decor.',
                'Very easy to clean and maintain. Does not require much effort.',
                'The scent is mild yet long-lasting, exactly what I was looking for.',
                'Compact design makes it easy to carry around while traveling.',
                'The display is vibrant and sharp. Watching videos is a delight.',
            ];
            $closings = [
                'Highly recommended! Totally worth the price.',
                "Don't think twice, just go for it. 5 stars from my side.",
                'Very happy with this purchase. Will definitely buy again.',
                'Great experience overall. Delivery was also very fast.',
                'Best deal I got online. Thank you for such a great product.',
                'If you are looking for quality, this is the best choice.',
                'Kudos to the seller for selling such genuine products.',
                'Will recommend this to all my friends and colleagues.',
                "Value for money deal. You won't regret buying this.",
                'Thank you Amazon for the quick delivery and great service.',
                'I am a happy customer. Will surely shop from this brand again.',
                'Go for it blindly. You will not be disappointed.',
                'A big thumbs up! Keeps up the brand reputation.',
                'Super satisfied! Looking forward to buying more items.',
                'Just go for it. It is a steal at this price point.',
                'Excellent experience. Keep up the good work.',
                'Totally worth every penny spent. 10/10 rating.',
                'The best investment I made this year. Love it!',
                'Simply amazing. Do not miss this deal.',
            ];
        } else {
            // 4 STAR - GOOD BUT GROUNDED
            $openings = [
                'Good product overall. Meets most of my requirements.',
                'Nice quality and decent performance for the price.',
                'Value for money purchase. Satisfied with the quality.',
                'Received the product in good condition. Looks exactly like the pictures.',
                'Pretty good experience. Better than other brands in this range.',
                'Decent buy. I have been using it for a week now.',
                'Not the best, but definitely a solid choice for this budget.',
                'Happy with the purchase, though delivery took a bit long.',
                'First impressions are positive. Looks durable enough.',
                'A reliable product. Does what it claims to do.',
                'Good choice for daily usage. Simple and effective.',
                'Ordered this for my office use and it serves the purpose well.',
                'The product is genuine and the packaging was secure.',
                'Reviewing after 3 days of usage. So far, so good.',
                'Comparison wise, it is better than the previous model I used.',
                'Quite satisfied with the look and feel of the product.',
                'Standard quality product. Nothing to complain about significantly.',
                'It is a good deal if you get it on offer price.',
            ];
            $bodies = [
                'The quality is good but the packaging could have been slightly better.',
                'Works well for daily use. No major complaints so far.',
                'Features are good but setup took some time to understand.',
                'Design is nice and modern, though the finish is average.',
                'Performance is satisfactory. It does the job well for this price point.',
                'Everything is fine, just the size is slightly different from what I expected.',
                'Color is slightly darker than the image shown, but it looks good.',
                'The wire length is a bit short, otherwise, the device works perfectly.',
                'Material is comfortable but requires careful washing.',
                'Battery life is decent, lasts about a day with moderate usage.',
                'The sound is clear but the bass could have been punchier.',
                'Installation guide was missing, but I figured it out easily.',
                'Speed is good but it heats up a little while charging.',
                'The fit is okay, but I would suggest ordering one size larger.',
                'Delivery was delayed by 2 days, but the product arrived safely.',
                'Buttons are a bit hard to press initially but they loosen up with use.',
                'Plastic quality is decent, not very premium but durable.',
                'It is lightweight and easy to handle, which is a plus point.',
            ];
            $closings = ['Overall a good deal. Giving 4 stars for the quick delivery.', 'Recommended if you are on a budget. Good job.', 'Worth buying during the sale. Happy with it.', 'Good service and support. Would recommend it.', 'Nice product. Hope it lasts long.', 'Satisfactory experience. A solid 4-star product.', 'Removing one star just for the packaging. Otherwise great.', 'Good buy for beginners. You can go for it.', 'Will update the review after using it for a month.', 'If you can ignore minor flaws, this is a great product.', 'Decent purchase. No regrets.', 'A reliable choice. Good for the price.', 'Can be improved slightly, but overall I am happy.', 'Good value for money. Thanks to the seller.', 'Would have given 5 stars if delivery was faster.', 'Nice addition to my home. looks good.', 'Overall satisfied. Will try other products from this brand.', 'A balanced product with good features.'];
        }

        $part1 = fake()->randomElement($openings);
        $part2 = fake()->randomElement($bodies);
        $part3 = fake()->randomElement($closings);

        return "$part1 $part2 $part3";
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Create Fake Users (agar pehle se nahi hain toh)
        // Aapne 100-200 reviews bola hai, toh hum users badha dete hain.
        // for ($i = 0; $i < 30; $i++) {
        //     User::factory()->create([
        //         "name"    => fake('en_IN')->name(),
        //         "is_fake" => 1,
        //         "email"   => fake()->unique()->safeEmail(),
        //         "mobile"  => "9" . fake()->numberBetween(100000000, 999999999),
        //         "role"    => "user",
        //     ]);
        // }

        $products = Product::where('id', 60)->get();

        foreach ($products as $product) {
            // Har product ke liye 15-20 reviews
            $count = rand(10, 20);
            $fakeUsers = User::where('is_fake', 1)->inRandomOrder()->limit($count)->get();

            foreach ($fakeUsers as $user) {
                // Sirf 4 ya 5 star rating
                $rating = fake()->numberBetween(4, 5);

                // Helper function se lamba review generate karein
                $remarks = $this->generateEnglishReview($rating);

                ProductReview::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'ratings' => $rating,
                    'remarks' => $remarks,
                    'status' => 1,
                ]);
            }
        }

        $this->info('Fake reviews generated successfully!');
    }
}
