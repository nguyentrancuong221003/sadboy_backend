<?php

namespace Modules\Admin\Product\seeders;

use Illuminate\Database\Seeder;
use Modules\Admin\Product\src\Models\ProductDetails;
class ProductDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productDetails = [
            [
                'product_id' => 1,
                'sort_description' => 'Dưa hấu có vỏ xanh sọc, ruột đỏ ngọt mát, nhiều nước và hạt đen nhỏ. Đây là loại quả giải khát tuyệt vời mùa hè, giàu vitamin, tốt cho sức khỏe, thường được ăn tươi, ép nước và mang ý nghĩa may mắn trong ngày Tết.'
            ],
            [
                'product_id' => 2,
                'sort_description' => 'Cam có vỏ màu vàng cam, ruột mọng nước, vị ngọt thanh hoặc chua dịu. Đây là loại quả giàu vitamin C, giúp tăng sức đề kháng, giải khát và thường được ăn tươi hoặc ép lấy nước.'
            ],
            [
                'product_id' => 3,
                'sort_description' => 'Nước ép lựu có màu đỏ tươi đẹp mắt, vị ngọt thanh xen lẫn chua nhẹ. Thức uống này giàu chất chống oxy hóa, vitamin và khoáng chất, tốt cho tim mạch, làn da và mang lại cảm giác tươi mát.'
            ],
            [
                'product_id' => 4,
                'sort_description' => 'Xúp lơ có màu trắng hoặc xanh, hoa nhỏ li ti, giòn ngọt, giàu vitamin và khoáng chất, thường được chế biến trong các món xào, luộc hoặc nấu canh.'
            ],
            [
                'product_id' => 5,
                'sort_description' => 'Bánh mỳ có lớp vỏ giòn vàng, ruột mềm xốp, thơm ngon, tiện lợi và giàu năng lượng, thường dùng làm bữa sáng nhanh gọn.'
            ],
            [
                'product_id' => 6,
                'sort_description' => 'Nho sữa có vỏ mỏng, ruột mọng nước, vị ngọt thanh, thơm nhẹ, giàu vitamin và chất chống oxy hóa, giúp tăng cường sức khỏe.'
            ],
            [
                'product_id' => 7,
                'sort_description' => 'Chuối có vỏ vàng, ruột mềm ngọt, giàu kali, vitamin và chất xơ, dễ ăn, tốt cho tiêu hóa và thường dùng làm món tráng miệng.'
            ],
            [
                'product_id' => 8,
                'sort_description' => 'Nước ép táo có vị ngọt dịu, thơm mát, giàu vitamin và chất chống oxy hóa, giúp thanh lọc cơ thể và tăng sức đề kháng.'
            ],
            [
                'product_id' => 9,
                'sort_description' => 'Khoai tây chiên vàng giòn, thơm bùi, béo ngậy, là món ăn vặt phổ biến, hấp dẫn mọi lứa tuổi.'
            ],
            [
                'product_id' => 10,
                'sort_description' => 'Gà chiên giòn có lớp vỏ vàng rụm, thịt mềm ngọt, hương vị đậm đà, là món ăn khoái khẩu được yêu thích rộng rãi.'
            ],
            [
                'product_id' => 11,
                'sort_description' => 'Bánh ngọt có hương vị thơm ngon, mềm xốp, nhiều loại nhân đa dạng như kem, socola, trái cây, mang đến cảm giác ngọt ngào và hấp dẫn.'
            ],
            [
                'product_id' => 12,
                'sort_description' => 'Nước ép dứa có vị ngọt chua hài hòa, màu vàng tươi mát, giàu vitamin C, giúp giải khát, tăng sức đề kháng và hỗ trợ tiêu hóa.'
            ],
            [
                'product_id' => 13,
                'sort_description' => 'Bắp cải có lá cuộn tròn, giòn ngọt, giàu vitamin và chất xơ, thường dùng để xào, nấu canh, muối chua hoặc ăn sống trong salad.'
            ],
            [
                'product_id' => 14,
                'sort_description' => 'Xu hào có thân củ giòn ngọt, màu xanh nhạt, giàu vitamin và khoáng chất, thường được dùng để nấu canh, xào hoặc muối dưa.'
            ],
            [
                'product_id' => 15,
                'sort_description' => 'Cà chua có màu đỏ tươi, mọng nước, vị chua ngọt, giàu vitamin C và lycopene, tốt cho sức khỏe và hay dùng trong nhiều món ăn.'
            ],
            [
                'product_id' => 16,
                'sort_description' => 'Nước ép nho có vị ngọt thanh, hương thơm dịu, giàu chất chống oxy hóa, giúp thanh mát cơ thể và tốt cho tim mạch.'
            ],
            [
                'product_id' => 17,
                'sort_description' => 'Quả đào có vỏ mịn hồng cam, ruột mềm ngọt, mọng nước, thơm dịu, chứa nhiều vitamin, giúp giải khát và làm đẹp da.'
            ],
            [
                'product_id' => 18,
                'sort_description' => 'Táo có vỏ mịn, nhiều màu sắc như đỏ, xanh, vàng, ruột giòn ngọt, giàu vitamin và chất xơ, tốt cho tiêu hóa và sức khỏe.'
            ],
            [
                'product_id' => 19,
                'sort_description' => 'Nước ép dưa hấu có màu đỏ tươi, vị ngọt mát, giàu vitamin và khoáng chất, là thức uống giải khát tuyệt vời mùa hè.'
            ],
            [
                'product_id' => 20,
                'sort_description' => 'Dâu tây nhỏ xinh, màu đỏ tươi, vị ngọt chua dịu, giàu vitamin C và chất chống oxy hóa, thường dùng để ăn tươi hoặc làm bánh, nước ép.'
            ],
            [
                'product_id' => 21,
                'sort_description' => 'Nước ép chuối sánh mịn, vị ngọt thơm, giàu kali và vitamin, giúp bổ sung năng lượng, tốt cho tiêu hóa và tim mạch.'
            ],
            [
                'product_id' => 22,
                'sort_description' => 'Nước ép cherry có màu đỏ sẫm, vị ngọt chua hài hòa, giàu chất chống oxy hóa, tốt cho giấc ngủ và sức khỏe tim mạch.'
            ],
            [
                'product_id' => 23,
                'sort_description' => 'Nước ép mận có vị chua ngọt đặc trưng, màu tím đỏ đẹp mắt, giàu vitamin và chất xơ, giúp thanh nhiệt và hỗ trợ tiêu hóa.'
            ],
            [
                'product_id' => 24,
                'sort_description' => 'Việt quất nhỏ, màu xanh tím, vị ngọt chua dịu, giàu chất chống oxy hóa, tốt cho mắt, tim mạch và tăng cường trí nhớ.'
            ],
            [
                'product_id' => 25,
                'sort_description' => 'Nước ép đào có màu vàng cam, vị ngọt dịu, hương thơm thanh mát, giàu vitamin, tốt cho da và hệ tiêu hóa.'
            ],
            [
                'product_id' => 26,
                'sort_description' => 'Măng cụt có vỏ tím sẫm, ruột trắng ngọt thanh, mọng nước, giàu vitamin và khoáng chất, được mệnh danh là “nữ hoàng trái cây”.'
            ],
            [
                'product_id' => 27,
                'sort_description' => 'Me có vỏ nâu, ruột chua ngọt, giàu vitamin C, thường dùng làm gia vị, kẹo hoặc nước giải khát, giúp kích thích tiêu hóa.'
            ],
            [
                'product_id' => 28,
                'sort_description' => 'Hồng xiêm có vỏ nâu, ruột mềm ngọt, thơm dịu, chứa nhiều năng lượng và vitamin, là loại quả bổ dưỡng dễ ăn.'
            ],
            [
                'product_id' => 29,
                'sort_description' => 'Vú sữa có vỏ tím hoặc xanh, ruột trắng ngọt mát, dẻo thơm, giàu vitamin và khoáng chất, mang ý nghĩa tình mẫu tử.'
            ],
            [
                'product_id' => 30,
                'sort_description' => 'Nước ép cà rốt có màu cam tươi, vị ngọt nhẹ, giàu vitamin A và chất chống oxy hóa, tốt cho mắt, da và hệ miễn dịch.'
            ],
            [
                'product_id' => 31,
                'sort_description' => 'Chôm chôm có vỏ đỏ gai mềm, ruột trắng mọng nước, vị ngọt thanh, giàu vitamin và khoáng chất, là loại quả nhiệt đới được ưa chuộng.'
            ],
            [
                'product_id' => 32,
                'sort_description' => 'Roi đỏ có vỏ mỏng, màu đỏ hồng bóng, ruột giòn ngọt, nhiều nước, ít hạt, giúp giải khát tốt trong những ngày hè nóng bức.'
            ],
            [
                'product_id' => 33,
                'sort_description' => 'Sầu riêng có vỏ gai cứng, ruột vàng béo ngậy, hương thơm nồng đặc trưng, giàu năng lượng, được mệnh danh là “vua của các loại trái cây”.'
            ],
            [
                'product_id' => 34,
                'sort_description' => 'Kiwi có vỏ nâu lông mịn, ruột xanh hoặc vàng, vị chua ngọt hài hòa, giàu vitamin C, tốt cho da và hệ miễn dịch.'
            ],
            [
                'product_id' => 35,
                'sort_description' => 'Bơ có vỏ xanh hoặc tím, ruột vàng kem, béo ngậy, giàu chất béo tốt, vitamin và khoáng chất, thường dùng làm sinh tố hoặc salad.'
            ],
            [
                'product_id' => 36,
                'sort_description' => 'Hamburger gồm bánh mỳ kẹp thịt, rau, phô mai và sốt, tiện lợi, giàu năng lượng, là món ăn nhanh phổ biến trên toàn thế giới.'
            ],
            [
                'product_id' => 37,
                'sort_description' => 'Nước ép ổi có vị ngọt thơm, hơi chua dịu, giàu vitamin C và chất xơ, giúp tăng đề kháng, làm đẹp da và hỗ trợ tiêu hóa.'
            ],
            [
                'product_id' => 38,
                'sort_description' => 'Dừa có vỏ xanh hoặc nâu, chứa nước ngọt mát và cơm dừa béo, giàu khoáng chất, là loại quả giải khát đặc trưng vùng nhiệt đới.'
            ],
            [
                'product_id' => 39,
                'sort_description' => 'Hồng táo có vỏ đỏ nâu, ruột ngọt dẻo hoặc giòn tùy loại, giàu vitamin và khoáng chất. Đây là loại quả bổ dưỡng, thường được ăn tươi, sấy khô hoặc dùng trong các bài thuốc dân gian.'
            ],
            [
                'product_id' => 40,
                'sort_description' => 'Nho trái tim có hình dáng trái tim độc đáo, vỏ mỏng, ruột ngọt mọng nước, giàu vitamin và chất chống oxy hóa, rất được ưa chuộng.'
            ]
        ];
        foreach ($productDetails as $product) {
            ProductDetails::factory()->create([
                'product_id' => $product['product_id'],
                'sort_description' => $product['sort_description'],
            ]);
        }

    }
}
