<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            "title" => "Nasıl Başladık",
            "content" => "Müşterinin adipoz işlemine dikkat etmesi çok önemlidir.
            Onun tiksintileri, dedi ama zahmetli, Bu nedenle, irtifak hakkı rahatlığıyla zorluklar giderilse bile,
            hiç kimse mimarı eğitemez. ondan daha şiddetli olanlar takip etmekten kaçsın. Ve uçuşta,
            bozuk vücudun hatası alınacak bazılarımız kim Suçlayanın acısı affedeninkinden daha mı büyük?
            O en değerlidir, ama hiçbiri yok bazıları tarafından reddedilmek ve en küçük övgücüler tarafından itilmek.",
            "image" => null,
            "channel" => "https://"
        ]);
    }
}
