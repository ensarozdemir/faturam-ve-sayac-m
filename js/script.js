var sliderInterval; 

function rotate() {
    var lastChild = $('.slider .box:last-child').clone();

    $('.slider .box').removeClass('firstSlide');
    $('.slider .box:last-child').remove();
    $('.slider').prepend(lastChild);
    $(lastChild).addClass('firstSlide');
}

$(document).ready(function() {
    rotate(); 
    sliderInterval = window.setInterval(function() { 
        rotate();
    }, 6000);
});

const initialDateTimeCached = localStorage.getItem('initialDateTime');


const initialDateTime = initialDateTimeCached ? initialDateTimeCached : new Date().toLocaleDateString('tr-TR') + ' ' + new Date().toLocaleTimeString('tr-TR');

if (!initialDateTimeCached) {
    localStorage.setItem('initialDateTime', initialDateTime);
}

function openModal(haberNo) {
    var modal = document.getElementById('myModal');
    var modalHaberDetaylari = document.getElementById('modalHaberDetaylari');
    var yuklemeTarihiVeSaatiElement = document.getElementById('yuklemeTarihiVeSaati');
	
	clearInterval(sliderInterval);
	
    switch(haberNo) {
        case 1:
            modalHaberDetaylari.innerHTML = 
			"<h2>VASKİ’DEN SU KESİNTİSİ DUYURUSU</h2><p>Van Su ve Kanalizasyon İdaresi(VASKİ) bazı semtlerde su kesintisine gidileceğini duyurdu. DSİ tarafından devam ettirilen “Van Civar Yerleşimler İçme Suyu İsale Hattı İnşaatı” kapsamında 30 bin metreküplük depoya çelik hat bağlantısı yapılacağından bazı semtlerde su kesintisine gidileceği bildirildi. Yapılacak çalışmalardan dolayı 16 Şubat cuma günü sabah 09.00 ile akşam 18.00 saatleri arasında Edremit, Tuşba ve İpekyolu ilçe merkezleri ile Edremit Yeni Toki konutlarında kısmi su kesintisine gidileceği açıklanarak, vatandaşlardan tedbir almaları istendi. Bununla birlikte yapılan diğer bir açıklama ise yapılacak olan yine çalışmalarla birlikte yeni elektrik  kesintilerin yaşanabileceği ve halkın bu konuda önlemler alması gerektiği konusunda uyarıldı halkın ne gibi önlemler alacağı web sitesinde detaylı olarak belirtildiği söylendi</p>";
            break;
        case 2:
            modalHaberDetaylari.innerHTML = 
			"<h2>Karadeniz'deki 1 trilyon dolarlık doğalgaz keşfinin yarısı yabancı şirkete mi gidecek?</h2><p>Cumhurbaşkanı Recep Tayyip Erdoğan’ın duyurduğu 710 milyar m3’lük doğalgaz keşfiyle Türkiye enerji sahasında tarihi bir eşiğe ulaştı. Sözcü gazetesi yazarı Yılmaz Özdil başta olmak üzere muhalefet çevreleri, Karadeniz’deki tarihin en yüksek doğalgaz keşfine gölge düşürmeye çalıştı. 1 trilyon dolar değerindeki keşifteki gelirin yarıya yakınının yabancı şirkete ait olacağı iddiası ortaya atıldı. Karadeniz’deki Akçakoca doğalgaz sahasında arama işletme ruhsatına sahip Park Place Energy Turkey şirketinin hissedarı Trillion Energy üzerinden yürütülen kara propagandanın gerçeği yansıtmadığı, söz konusu şirketin 1 trilyon dolarlık keşfin yapıldığı bölge ile herhangi bir ilişiğinin olmadığı öğrenildi.Cumhurbaşkanı Erdoğan’ın duyurduğu rezervi 710 milyar metreküp olarak açıklanan bölge ise Sakarya Gaz Sahası ve civarı. Ulaşılan bilgilere göre, keşfin yapıldığı “AR/TPO/KD/C26,C27,D26,D27” numaralı ruhsat alanları kıyıdan 175, Akçakoca sahasından 168 kilometre uzaklıkta. Keşfin yapıldığı bölgedeki yatırım ve üretim aşamasında ruhsat ve rezervin %100’ünün Türkiye Petrolleri Anonim Ortaklığı’na (TPAO) ait olduğu bildirildi. Sakarya Gaz Sahası ve civarında herhangi bir ortak şirketin söz konusu olmadığı kaydedildi.</p>";
            break;
        case 3:
            modalHaberDetaylari.innerHTML =
			"<h2>ELEKTRİKLER NEDEN KESİLECEK</h2><p>Doç. Dr. İnci Akkaya Oralhan Bazılarına göre 2024’ün ortalarında bazılarına göre sonlarında tabi ki tam tahmin edemeyiz ama en az 2-3 gün öncesinden güneşteki patlamalar tespit ediliyor. O yüzden bu aktivasyon her zaman vardı. Evet 2024’te biraz maksimuma ulaşacak ama bu sadece neyi etkiler? Özellikle yere yakın uydular güneşten bu yüksek enerjili plazma geldiği zaman dünyamızın manyetik alanı içerisine giriyor. Allah’tan böyle bir manyetik alanımız var, Eğer o manyetik alan olmasaydı güneşten gelen yüksek enerjili fotonlar bizim hayatımızı etkileyecekti belki dünyada da yaşam olmayacaktı. İşte gelen o parçacıklar dünya atmosferine giriyor. Özellikle kuzey kutuplarında görülen kutup ışıkları, hatta Karadeniz’de de görüldü bu ışıklar. En güzel görsel şölen olacak bizim için o ışıklar. O yüzden bizim için zaten tehlikeli bir durumu da yok. Uydular atmosferin kalınlaşmasından dolayı bir miktar yönlerinden sapabilirler. Aşağı yukarı hareket edebilirler. Onun sonucunda da GPS uyduları belki hafif konum bulmakta anlık belki de saatlik sıkıntı olabilir ama bunun haricinde bizim yaşamımızı etkileyen bir şey olmayacak ifadelerini kullandı.Elektrik kesintilerini güneş patlamalarına bağlamak gibi öngörümüz yok Elbette ki elektrik hatlarımızı etkiler mi etkiler. Yani bugün her yerde elektrik kesintisi oluyor ama bunlar kısa sürede halledilebilecek şeyler.”</p>";
            break;
        case 4:
            modalHaberDetaylari.innerHTML = 
			"<h2>KEŞİFLER MAKROEKONOMİYE KATKI SAĞLAYACAK</h2><p>Bulunan yeni rezervler Türkiye’nin makroekonomik rakamlarına da önemli katkı sağlayacaktır. Cari denge bu rezervlerle birlikte daha pozitif etki altına girecektir. Her yıl yaklaşık 50 milyar dolara yakın enerji faturasını yurt dışına ödeyen Türkiye belli oranda bu faturalarını azaltma şansına sahip olacaktır. Bu nedenle, bulunan bu rezervler uluslararası piyasalara göre ister daha pahalıya, ister daha ucuza çıkarılsın milli ekonomi için tercih sebebi olmalıdır. Yani yurt dışından 60 dolara mal olan enerji içeride 70 dolara da mal olsa tercih edilmelidir. Çünkü harcanacak 70 doların tamamı yerli tedarikte kullanılacak ve kaynağın tamamı milli ekonomi içinde kalacaktır. Ekonominin tamamına dolaylı ve doğrudan destek sağlanmış olacaktır. Sadece doğal gazda değil, yerli üretimin tamamında bu mantıkla hareket etmek uzun vadede ekonomide millileşme ve ekonomik bağımsızlığı sağlamada etkili olacaktır. Türkiye için kronik bir sorun olan enflasyon da bu keşiflerden pozitif etkilenecektir. Enflasyonun temel bileşenlerinin yüzdelik katkısına baktığımızda %28 ile gıdanın ardından %14.6 ile enerji ikinci sırada gelmektedir. Rezervler doğrudan dışarı giden döviz miktarını etkileyeceğinden uzun vadede enflasyona pozitif katkı sağlanacaktır. Yani hem maliyet enflasyonu hem de dövizin yurt dışına verilmemesi anlamıyla keşifler enflasyon üzerinde etki sağlayacak önemli katkılara sahiptir.</p>";
            break;
        case 5:
            modalHaberDetaylari.innerHTML =
			"<h2>SON DAKİKA... ELEKTRİK VE DOĞALGAZA İKİ ZAM DAHA</h2><p>30 gün arayla zam Elektrik ve doğalgaz fiyatlarına 1 Mart‘ta da zam gelmişti. Bir ay önce gelen zamda doğalgaza konutlarda yüzde 9, büyük işletmelerde yüzde 14 zam yapılmıştı. Aynı tarihte konutlarda kullanılan elektriğin fiyatına yüzde 9.57, sanayide kullanılan elektriğin fiyatına ise yüzde 9.26 zam yapılmıştı. Yürürlüğe giren son zamlarla birlikte 1 Ağustos‘tan bu yana konutlarda kullanılan doğalgaz toplamda yüzde 18, sanayide kullanılan doğalgaz ise 28 zamlandı. Aynı süre zarfında konutlarda kullanılan elektriğe toplamda yüzde 24.57, sanayide kullanılan elektriğe 24.26 zam yapıldı. Elektrik Mühendisleri Odası (EMO) verilerine göre; yeni zamla birlikte dokuz ayda elektrik fiyatlarındaki artış; konutlar için yüzde 37 olurken, diğer tarife gruplarında yüzde 40‘ı da aştı. Faturalar kabaracak Tencereyi kaynatmayı giderek zorlaştıran elektrik ve doğalgaz zamları en çok dar gelirli haneleri zorlayacak. Çünkü zaten dar gelirli vatandaşların ödemekte zorlandığı elektrik ve doğalgaz faturaları son zamlarla daha da kabaracak. Üstelik gidişata bakılırsa bu zamlar son olmayacak. Zira EPDK normal şartlar altında Ekim ayında yapması gereken fiyat düzenlemesini 1 Eylül‘de gerçekleştirdi. Ancak EPDK‘dan yapılan açıklamada 1 Ekim‘de herhangi bir fiyat düzenlemesi yapılmayacağına dair ifade yer almadı. Bu da gösteriyor ki, 1 Ekim‘de de doğalgaz ve elektriğe zam gelme ihtimali yüksek. </p>";
            break;
        case 6:
            modalHaberDetaylari.innerHTML =
			"<h2>Rekabet Kurulu tıbbi cihaz sektöründe faaliyet gösteren 3 teşebbüse soruşturma açtı</h2><p>Rekabet Kurumunun internet sitesinde yer alan duyuruya göre, Bıçakcılar Tıbbi Cihazlar Sanayi ve Ticaret AŞ, Gazi Kimya Sanayi ve Ticaret AŞ ve Rectus Medikal Ürünler ve Sağlık Hizmetleri Sanayi ve Ticaret Limited Şirketinin Rekabetin Korunması Hakkında Kanun'u ihlal ettikleri iddiasına yönelik yürütülen ön araştırmalar Kurulca karara bağlandı. Elde edilen bilgileri, belgeleri ve yapılan tespitleri müzakere eden Kurul, bulguları ciddi ve yeterli bularak, söz konusu teşebbüsler hakkında soruşturma açılmasına karar verdi. Kurulca alınan soruşturma kararları, hakkında soruşturma açılan teşebbüs ya da teşebbüs birliklerinin Kanun'u ihlal ettikleri ve yaptırımla karşı karşıya kaldıkları veya kalacakları anlamına gelmiyor. ekabet Kurumu yaptığı bir diğer açıklamada ise diğer şirketlere yönelik çalışmaların yapılacağı ve bu şirketlere yönelik de gerekli olan yaptırımların uygulanacağı şeklinde Bir açıklamada bulundu</p>";
            break;
        case 7:
            modalHaberDetaylari.innerHTML = 
			"<h2>Türkiye'den dev petrol ve doğalgaz hamlesi! En büyük pay ayrıldı</h2><p>Bakan Bayraktar, yaptığı yazılı açıklamada, geçen yıla kıyasla enerji sektörüne yapılacak yatırımın 2024'te yüzde 70 artışla 75,7 milyar lira, madencilik sektörüne yapılacak yatırımın da yüzde 34 artışla 106 milyar lira olacağını kaydetti. En büyük yatırımı doğal gaz ile petrol arama ve üretim çalışmaları için yapacaklarını aktaran Bayraktar, Sakarya Gaz Sahası ve Gabar bölgesi başta olmak üzere üretim alanlarımızı genişletmek ve üretimi artırmak için yaklaşık 100 milyar liralık yatırım planlıyoruz. Bu kapsamda 2024'te 327 bin metre arama, 399 bin metre üretim sondajı yapacağız. değerlendirmesinde bulundu.2024'te doğal gaz depolama kapasitelerinin artırılması, doğal gaz iletim hattı yapımı ve modernizasyonu, doğal gaz ulaşmayan yerlere doğal gaz arzı sağlanması gibi faaliyetler kapsamında Boru Hatları ile Petrol Taşıma AŞ (BOTAŞ), 29 milyar lira yatırım gerçekleştirecek. TEİAŞ ise elektrik iletim hatları ve trafo yatırımlarına 28 milyar lira kaynak aktaracak. Böylece diğer yatırımlarla beraber 2024'te enerji ve madencilik sektörüne 181,7 milyar lira kamu yatırımı yapacağız.</p>";
            break;
        default:
            modalHaberDetaylari.innerHTML = "<p>Bu haberin detayları henüz eklenmedi.</p>";
			
	}


    yuklemeTarihiVeSaatiElement.textContent = initialDateTime;
    modal.style.display = "block";
}

function closePanel() {
    var modal = document.getElementById('myModal');
    modal.style.display = "none";

    sliderInterval = window.setInterval(function() { 
        rotate();
    }, 6000);
}

var closeButton = document.getElementsByClassName("close")[0];
if (closeButton) {
    closeButton.onclick = closePanel;
}

window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
        closePanel();
    }
};