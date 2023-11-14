<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:55:09',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'Experience enhanced comfort with our AC CoolCare services, ensuring optimal cooling performance for your space.🔩 🪛',
                    'ar' => 'جرب الراحة المحسّنة مع خدماتنا للعناية بالتكييف، مما يضمن الأداء التبريد المثالي لمساحتك.🔩 🪛',
                ],
                'id' => 9,
                'is_featured' => 1,
                'name' => [
                    'en' => 'AC CoolCare',
                    'ar' => 'رعاية التبريد',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/ac_coolcare.png'),
                'updated_at' => '2023-09-04 12:55:15',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:56:14',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Tailor category guides you through the art of fabric manipulation and garment construction, from sewing basics to advanced techniques, helping you create perfectly tailored pieces. 🧥🥻👔',
                    'ar' => 'توجّهك فئة الخياط من خلال فن تلاعب القماش وبناء الملابس، من الأساسيات في الخياطة إلى التقنيات المتقدمة، مما يساعدك على إنشاء قطع مصمّمة بشكل مثالي. 🧥🥻👔',
                ],
                'id' => 10,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Tailor',
                    'ar' => 'خياط',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/tailor.png'),
                'updated_at' => '2023-09-04 12:56:14',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:57:10',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Smart Home category delves into the realm of interconnected devices and automation, transforming living spaces into efficient and tech-savvy environments. 📱',
                    'ar' => 'تعمق فئة المنزل الذكي في مجال الأجهزة المتصلة والتحكم التلقائي، مما يحول الأماكن السكنية إلى بيئات فعالة ومتطورة تقنيًا. 📱',
                ],
                'id' => 11,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Smart Home',
                    'ar' => 'المنزل الذكي',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/smart_home.png'),
                'updated_at' => '2023-09-04 12:57:10',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:57:44',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'Ensure safety and peace of mind with our Security Guard services, providing vigilant protection for your premises.👮🏻',
                    'ar' => 'تأكد من السلامة والطمأنينة مع خدمات حراسة الأمان لدينا، التي توفر حماية متيقظة لممتلكاتك.👮🏻',
                ],
                'id' => 12,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Security Guard',
                    'ar' => 'حارس أمن',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/security_guard.png'),
                'updated_at' => '2023-09-04 12:57:44',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:58:07',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Sanitization category offers expert guidance on maintaining clean and hygienic environments through effective cleaning and disinfection practices.🧴',
                    'ar' => 'تقدم فئة التطهير إرشادات خبيرة للحفاظ على بيئات نظيفة وصحية من خلال ممارسات التنظيف والتطهير الفعالة.🧴',
                ],
                'id' => 13,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Sanitization',
                    'ar' => 'تطهير',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/sanitization.png'),
                'updated_at' => '2023-09-04 12:58:07',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:58:27',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Salon category is a hub of beauty and grooming expertise, offering insights into hairstyling, skincare, and personal care routines for a confident and polished you. ✂️',
                    'ar' => 'تعتبر فئة الصالون مركزًا لخبرة التجميل والعناية بالمظهر، حيث تقدم رؤى حول تصفيف الشعر والعناية بالبشرة وروتينات العناية الشخصية لتكون واثقًا ومتألقًا. ✂️',
                ],
                'id' => 14,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Salon',
                    'ar' => 'صالون',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/salon.png'),
                'updated_at' => '2023-09-04 12:58:27',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:58:53',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Photography category captures the essence of visual storytelling, offering tips on composition, editing, and equipment to help you create captivating images. 📸',
                    'ar' => 'تقتنص فئة التصوير جوهر السرد البصري، حيث تقدم نصائح حول التكوين والتحرير والمعدات لمساعدتك في إنشاء صور جذابة. 📸',
                ],
                'id' => 15,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Photography',
                    'ar' => 'التصوير الفوتوغرافي',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/photography.png'),
                'updated_at' => '2023-09-04 12:58:53',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:59:13',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Pest Control category equips you with effective strategies to manage and eliminate pests, ensuring a pest-free environment and peace of mind. 🪲🪳',
                    'ar' => 'تزوّدك فئة مكافحة الآفات بالاستراتيجيات الفعّالة لإدارة والقضاء على الآفات، مما يضمن بيئة خالية من الآفات والراحة النفسية. 🪲🪳',
                ],
                'id' => 16,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Pest Control',
                    'ar' => 'مكافحة الآفات',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/pest_control.png'),
                'updated_at' => '2023-09-04 12:59:13',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 12:59:31',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Pandit category offers spiritual guidance, rituals, and insights rooted in ancient traditions, assisting individuals in their journey towards deeper understanding and connection.🔥',
                    'ar' => 'تقدم فئة البانديت الإرشاد الروحي والطقوس والرؤى المتجذرة في التقاليد القديمة، مما يساعد الأفراد في رحلتهم نحو فهم أعمق واتصال أكبر. 🔥',
                ],
                'id' => 17,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Pandit',
                    'ar' => 'بانديت',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/pandit.png'),
                'updated_at' => '2023-09-04 12:59:31',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:00:04',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Painter category celebrates the world of colors and creativity, offering guidance on techniques, styles, and mediums for both aspiring and seasoned artists.🖌️🎨',
                    'ar' => 'تحتفي فئة الرسام بعالم الألوان والإبداع، وتقدم الإرشاد حول التقنيات والأنماط والوسائط لكل من الفنانين الطامحين والمحترفين. 🖌️🎨',
                ],
                'id' => 18,
                'is_featured' => 1,
                'name' => [
                    'en' => 'Painter',
                    'ar' => 'رسام',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/painter.png'),
                'updated_at' => '2023-09-04 13:06:10',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:00:26',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'Experience the convenience of pristine garments with our comprehensive Laundry services, ensuring freshness and care for your clothing.🧼',
                    'ar' => 'استمتع براحة الملابس النقية مع خدماتنا الشاملة للغسيل، مما يضمن الانتعاش والعناية بملابسك. 🧼',
                ],
                'id' => 19,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Laundry',
                    'ar' => 'غسيل الملابس',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/laundry.png'),
                'updated_at' => '2023-09-04 13:00:26',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:00:55',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Gardener category cultivates a wealth of knowledge on plant care, landscaping, and sustainable gardening practices to help enthusiasts foster thriving green spaces. 🏡⛏️',
                    'ar' => 'تطوّر فئة البستاني معرفة غنية حول رعاية النباتات والتنسيق البستاني وممارسات الحدائق المستدامة لمساعدة الهواة على تعزيز الفضاءات الخضراء المزدهرة. 🏡⛏️',
                ],
                'id' => 20,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Gardener',
                    'ar' => 'بستاني',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/gardener.png'),
                'updated_at' => '2023-09-04 13:05:54',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:01:27',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'Experience top-notch Automotive Care for your vehicle\'s longevity and performance. From maintenance to repairs, our experts ensure your ride stays at its best. 🚛🚙',
                    'ar' => 'استمتع برعاية سيارات متميزة لطول عمر وأداء مركبتك. من الصيانة إلى الإصلاحات، يضمن خبراؤنا بقاء رحلتك في أفضل حالاتها. 🚛🚙',
                ],
                'id' => 21,
                'is_featured' => 0,
                'name' => [
                    'en' => 'Automotive Care',
                    'ar' => 'رعاية السيارات',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/automotive_care.png'),
                'updated_at' => '2023-09-04 13:01:27',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:02:07',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Cooking category offers a delightful exploration of culinary techniques, recipes, and kitchen tips, catering to both novice cooks and seasoned chefs. 🫕🍲',
                    'ar' => 'تقدم فئة الطهي استكشافًا ممتعًا لتقنيات الطهي والوصفات ونصائح المطبخ، مما يلبي احتياجات الطهاة المبتدئين والمطهوين المحترفين على حد سواء. 🫕🍲',
                ],
                'id' => 22,
                'is_featured' => 1,
                'name' => [
                    'en' => 'Cooking',
                    'ar' => 'الطهي',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/cooking.png'),
                'updated_at' => '2023-09-04 13:02:10',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:02:07',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'The Cooking category offers a delightful exploration of culinary techniques, recipes, and kitchen tips, catering to both novice cooks and seasoned chefs. 🫕🍲',
                    'ar' => 'تقدم فئة الطهي استكشافًا ممتعًا لتقنيات الطهي والوصفات ونصائح المطبخ، مما يلبي احتياجات الطهاة المبتدئين والمطهوين المحترفين على حد سواء. 🫕🍲',
                ],
                'id' => 23,
                'is_featured' => 1,
                'name' => [
                    'en' => 'Cooking 2',
                    'ar' => ' 2الطهي',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/cooking.png'),
                'updated_at' => '2023-09-04 13:02:10',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:03:21',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'Efficiently remove dirt and grime with our cleaning products, restoring surfaces to their pristine condition. 🧼🧽🧹🧻',
                    'ar' => 'قم بإزالة الأوساخ والشوائب بكفاءة باستخدام منتجات التنظيف لدينا، واستعيد الأسطح إلى حالتها النقية. 🧼🧽🧹🧻',
                ],
                'id' => 24,
                'is_featured' => 1,
                'name' => [
                    'en' => 'Cleaning',
                    'ar' => 'تنظيف',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/cleaning.png'),
                'updated_at' => '2023-09-04 13:03:21',
            ],            
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:04:01',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'Delve into the Electrician category to illuminate your understanding of electrical systems, from wiring complexities to safety essentials. 💡🪛🔌',
                    'ar' => 'تفضل بالانغماس في فئة الكهربائي لتنير فهمك للأنظمة الكهربائية، من تعقيدات التوصيلات إلى الأساسيات الأمنية. 💡🪛🔌',
                ],
                'id' => 25,
                'is_featured' => 1,
                'name' => [
                    'en' => 'Electrician',
                    'ar' => 'كهربائي',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/electrician.png'),
                'updated_at' => '2023-09-04 13:06:04',
            ],
            [
                'color' => '#000000',
                'created_at' => '2023-09-04 13:04:41',
                'deleted_at' => NULL,
                'description' => [
                    'en' => 'A carpenter is a skilled tradesperson who specializes in working with wood to construct, install, and repair structures and objects. 🪛 🪚',
                    'ar' => 'النجار هو حرفي ماهر يتخصص في العمل مع الخشب لبناء وتركيب وإصلاح الهياكل والأشياء. 🪛 🪚',
                ],
                'id' => 26,
                'is_featured' => 1,
                'name' => [
                    'en' => 'Carpenter',
                    'ar' => 'نجار',
                ],
                'status' => 1,
                'category_image' => public_path('/images/category-images/carpenter.png'),
                'updated_at' => '2023-09-04 13:04:53',
            ],
        ];
        
        foreach ($data as $key => $val) {
            $featureImage = $val['category_image'] ?? null;
            $categoryData = Arr::except($val, ['category_image']);
            $category = Category::create($categoryData);
            if (isset($featureImage)) {
                $this->attachFeatureImage($category, $featureImage);
            }
        } 
    }

    private function attachFeatureImage($model, $publicPath)
    {

        $file = new \Illuminate\Http\File($publicPath);

        $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('category_image');

        return $media;

    }
}