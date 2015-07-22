<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2015 OA Wu Design
 */

class Demo extends Site_controller {

  public function __construct () {
    parent::__construct ();

    $this->data2 = array (
      "100-台北市中正區-6300500",
      "103-台北市大同區-6300600",
      "104-台北市中山區-6300400",
      "105-台北市松山區-6300100",
      "106-台北市大安區-6300300",
      "108-台北市萬華區-6300700",
      "110-台北市信義區-6300200",
      "111-台北市士林區-6301100",
      "112-台北市北投區-6301200",
      "114-台北市內湖區-6301000",
      "115-台北市南港區-6300900",
      "116-台北市文山區-6300800",
      "200-基隆市仁愛區-1001704",
      "201-基隆市信義區-1001707",
      "202-基隆市中正區-1001701",
      "203-基隆市中山區-1001705",
      "204-基隆市安樂區-1001706",
      "205-基隆市暖暖區-1001703",
      "206-基隆市七堵區-1001702",
      "207-新北市萬里區-6502800",
      "208-新北市金山區-6502700",
      "209-連江縣南竿鄉-0900701",
      "210-連江縣北竿鄉-0900702",
      "211-連江縣莒光鄉-0900703",
      "212-連江縣東引鄉-0900704",
      "220-新北市板橋區-6500100",
      "221-新北市汐止區-6501100",
      "222-新北市深坑區-6501800",
      "223-新北市石碇區-6501900",
      "224-新北市瑞芳區-6501200",
      "226-新北市平溪區-6502400",
      "227-新北市雙溪區-6502500",
      "228-新北市貢寮區-6502600",
      "231-新北市新店區-6500600",
      "232-新北市坪林區-6502000",
      "233-新北市烏來區-6502900",
      "234-新北市永和區-6500400",
      "235-新北市中和區-6500300",
      "236-新北市土城區-6501300",
      "237-新北市三峽區-6500900",
      "238-新北市樹林區-6500700",
      "239-新北市鶯歌區-6500800",
      "241-新北市三重區-6500200",
      "243-新北市泰山區-6501600",
      "244-新北市林口區-6501700",
      "247-新北市蘆洲區-6501400",
      "248-新北市五股區-6501500",
      "242-新北市新莊區-6500500",
      "249-新北市八里區-6502300",
      "251-新北市淡水區-6501000",
      "252-新北市三芝區-6502100",
      "253-新北市石門區-6502200",
      "260-宜蘭縣宜蘭市-1000201",
      "261-宜蘭縣頭城鎮-1000204",
      "262-宜蘭縣礁溪鄉-1000205",
      "263-宜蘭縣壯圍鄉-1000206",
      "264-宜蘭縣員山鄉-1000207",
      "265-宜蘭縣羅東鎮-1000202",
      "266-宜蘭縣三星鄉-1000210",
      "267-宜蘭縣大同鄉-1000211",
      "268-宜蘭縣五結鄉-1000209",
      "269-宜蘭縣冬山鄉-1000208",
      "270-宜蘭縣蘇澳鎮-1000203",
      "272-宜蘭縣南澳鄉-1000212",
      "300-新竹市東區-1001801",
      "300-新竹市香山區-1001803",
      "300-新竹市北區-1001802",
      "302-新竹縣竹北市-1000401",
      "303-新竹縣湖口鄉-1000405",
      "304-新竹縣新豐鄉-1000406",
      "305-新竹縣新埔鎮-1000403",
      "306-新竹縣關西鎮-1000404",
      "307-新竹縣芎林鄉-1000407",
      "308-新竹縣寶山鄉-1000410",
      "310-新竹縣竹東鎮-1000402",
      "311-新竹縣五峰鄉-1000413",
      "312-新竹縣橫山鄉-1000408",
      "313-新竹縣尖石鄉-1000412",
      "314-新竹縣北埔鄉-1000409",
      "315-新竹縣峨眉鄉-1000411",
      "320-桃園市中壢區-6800200",
      "324-桃園市平鎮區-6801000",
      "325-桃園市龍潭區-6800900",
      "326-桃園市楊梅區-6800400",
      "327-桃園市新屋區-6801100",
      "328-桃園市觀音區-6801200",
      "330-桃園市桃園區-6800100",
      "333-桃園市龜山區-6800700",
      "334-桃園市八德區-6800800",
      "335-桃園市大溪區-6800300",
      "336-桃園市復興區-6801300",
      "337-桃園市大園區-6800600",
      "338-桃園市蘆竹區-6800500",
      "350-苗栗縣竹南鎮-1000504",
      "351-苗栗縣頭份鎮-1000505",
      "352-苗栗縣三灣鄉-1000516",
      "353-苗栗縣南庄鄉-1000511",
      "354-苗栗縣獅潭鄉-1000517",
      "356-苗栗縣後龍鎮-1000506",
      "357-苗栗縣通霄鎮-1000503",
      "358-苗栗縣苑裡鎮-1000502",
      "360-苗栗縣苗栗市-1000501",
      "361-苗栗縣造橋鄉-1000515",
      "362-苗栗縣頭屋鄉-1000512",
      "363-苗栗縣公館鄉-1000509",
      "364-苗栗縣大湖鄉-1000508",
      "365-苗栗縣泰安鄉-1000518",
      "366-苗栗縣銅鑼鄉-1000510",
      "367-苗栗縣三義鄉-1000513",
      "368-苗栗縣西湖鄉-1000514",
      "369-苗栗縣卓蘭鎮-1000507",
      "400-台中市中區-6600100",
      "401-台中市東區-6600200",
      "402-台中市南區-6600300",
      "403-台中市西區-6600400",
      "404-台中市北區-6600500",
      "406-台中市北屯區-6600800",
      "407-台中市西屯區-6600600",
      "408-台中市南屯區-6600700",
      "411-台中市太平區-6602700",
      "412-台中市大里區-6602800",
      "413-台中市霧峰區-6602600",
      "414-台中市烏日區-6602300",
      "420-台中市豐原區-6600900",
      "421-台中市后里區-6601500",
      "422-台中市石岡區-6602000",
      "423-台中市東勢區-6601000",
      "424-台中市和平區-6602900",
      "426-台中市新社區-6601900",
      "427-台中市潭子區-6601700",
      "428-台中市大雅區-6601800",
      "429-台中市神岡區-6601600",
      "432-台中市大肚區-6602400",
      "433-台中市沙鹿區-6601300",
      "434-台中市龍井區-6602500",
      "435-台中市梧棲區-6601400",
      "436-台中市清水區-6601200",
      "437-台中市大甲區-6601100",
      "438-台中市外埔區-6602100",
      "439-台中市大安區-6602200",
      "500-彰化縣彰化市-1000701",
      "502-彰化縣芬園鄉-1000709",
      "503-彰化縣花壇鄉-1000708",
      "504-彰化縣秀水鄉-1000707",
      "505-彰化縣鹿港鎮-1000702",
      "506-彰化縣福興鄉-1000706",
      "507-彰化縣線西鄉-1000704",
      "508-彰化縣和美鎮-1000703",
      "509-彰化縣伸港鄉-1000705",
      "510-彰化縣員林鎮-1000710",
      "511-彰化縣社頭鄉-1000717",
      "512-彰化縣永靖鄉-1000716",
      "513-彰化縣埔心鄉-1000715",
      "514-彰化縣溪湖鎮-1000711",
      "515-彰化縣大村鄉-1000713",
      "516-彰化縣埔鹽鄉-1000714",
      "520-彰化縣田中鎮-1000712",
      "521-彰化縣北斗鎮-1000719",
      "522-彰化縣田尾鄉-1000721",
      "523-彰化縣埤頭鄉-1000722",
      "524-彰化縣溪州鄉-1000726",
      "525-彰化縣竹塘鄉-1000725",
      "526-彰化縣二林鎮-1000720",
      "527-彰化縣大城鄉-1000724",
      "528-彰化縣芳苑鄉-1000723",
      "530-彰化縣二水鄉-1000718",
      "540-南投縣南投市-1000801",
      "541-南投縣中寮鄉-1000808",
      "542-南投縣草屯鎮-1000803",
      "544-南投縣國姓鄉-1000810",
      "545-南投縣埔里鎮-1000802",
      "546-南投縣仁愛鄉-1000813",
      "551-南投縣名間鄉-1000806",
      "552-南投縣集集鎮-1000805",
      "553-南投縣水里鄉-1000811",
      "555-南投縣魚池鄉-1000809",
      "556-南投縣信義鄉-1000812",
      "557-南投縣竹山鎮-1000804",
      "558-南投縣鹿谷鄉-1000807",
      "600-嘉義市西區-1002002",
      "600-嘉義市東區-1002001",
      "602-嘉義縣番路鄉-1001016",
      "603-嘉義縣梅山鄉-1001015",
      "604-嘉義縣竹崎鄉-1001014",
      "605-嘉義縣阿里山鄉-1001018",
      "606-嘉義縣中埔鄉-1001013",
      "607-嘉義縣大埔鄉-1001017",
      "608-嘉義縣水上鄉-1001012",
      "611-嘉義縣鹿草鄉-1001011",
      "612-嘉義縣太保市-1001001",
      "613-嘉義縣朴子市-1001002",
      "614-嘉義縣東石鄉-1001009",
      "615-嘉義縣六腳鄉-1001008",
      "616-嘉義縣新港鄉-1001007",
      "621-嘉義縣民雄鄉-1001005",
      "622-嘉義縣大林鎮-1001004",
      "623-嘉義縣溪口鄉-1001006",
      "624-嘉義縣義竹鄉-1001010",
      "625-嘉義縣布袋鎮-1001003",
      "630-雲林縣斗南鎮-1000902",
      "631-雲林縣大埤鄉-1000908",
      "632-雲林縣虎尾鎮-1000903",
      "633-雲林縣土庫鎮-1000905",
      "634-雲林縣褒忠鄉-1000915",
      "635-雲林縣東勢鄉-1000914",
      "636-雲林縣台西鄉-1000916",
      "637-雲林縣崙背鄉-1000912",
      "638-雲林縣麥寮鄉-1000913",
      "640-雲林縣斗六市-1000901",
      "643-雲林縣林內鄉-1000910",
      "646-雲林縣古坑鄉-1000907",
      "647-雲林縣莿桐鄉-1000909",
      "648-雲林縣西螺鎮-1000904",
      "649-雲林縣二崙鄉-1000911",
      "651-雲林縣北港鎮-1000906",
      "652-雲林縣水林鄉-1000920",
      "653-雲林縣口湖鄉-1000919",
      "654-雲林縣四湖鄉-1000918",
      "655-雲林縣元長鄉-1000917",
      "700-台南市中西區-6703700",
      "701-台南市東區-6703200",
      "702-台南市南區-6703300",
      "704-台南市北區-6703400",
      "708-台南市安平區-6703600",
      "709-台南市安南區-6703500",
      "710-台南市永康區-6703100",
      "711-台南市歸仁區-6702800",
      "712-台南市新化區-6701800",
      "713-台南市左鎮區-6702600",
      "714-台南市玉井區-6702300",
      "715-台南市楠西區-6702400",
      "716-台南市南化區-6702500",
      "717-台南市仁德區-6702700",
      "718-台南市關廟區-6702900",
      "719-台南市龍崎區-6703000",
      "720-台南市官田區-6701000",
      "721-台南市麻豆區-6700700",
      "722-台南市佳里區-6701200",
      "723-台南市西港區-6701400",
      "724-台南市七股區-6701500",
      "725-台南市將軍區-6701600",
      "726-台南市學甲區-6701300",
      "727-台南市北門區-6701700",
      "730-台南市新營區-6700100",
      "731-台南市後壁區-6700500",
      "732-台南市白河區-6700300",
      "733-台南市東山區-6700600",
      "734-台南市六甲區-6700900",
      "735-台南市下營區-6700800",
      "736-台南市柳營區-6700400",
      "737-台南市鹽水區-6700200",
      "741-台南市善化區-6701900",
      "742-台南市大內區-6701100",
      "743-台南市山上區-6702200",
      "744-台南市新市區-6702000",
      "745-台南市安定區-6702100",
      "800-高雄市新興區-6400600",
      "801-高雄市前金區-6400700",
      "802-高雄市苓雅區-6400800",
      "803-高雄市鹽埕區-6400100",
      "804-高雄市鼓山區-6400200",
      "805-高雄市旗津區-6401000",
      "806-高雄市前鎮區-6400900",
      "807-高雄市三民區-6400500",
      "811-高雄市楠梓區-6400400",
      "812-高雄市小港區-6401100",
      "813-高雄市左營區-6400300",
      "814-高雄市仁武區-6401700",
      "815-高雄市大社區-6401600",
      "820-高雄市岡山區-6401900",
      "821-高雄市路竹區-6402400",
      "822-高雄市阿蓮區-6402300",
      "823-高雄市田寮區-6402200",
      "824-高雄市燕巢區-6402100",
      "825-高雄市橋頭區-6402000",
      "826-高雄市梓官區-6402900",
      "827-高雄市彌陀區-6402800",
      "828-高雄市永安區-6402700",
      "829-高雄市湖內區-6402500",
      "830-高雄市鳳山區-6401200",
      "831-高雄市大寮區-6401400",
      "832-高雄市林園區-6401300",
      "833-高雄市鳥松區-6401800",
      "840-高雄市大樹區-6401500",
      "842-高雄市旗山區-6403000",
      "843-高雄市美濃區-6403100",
      "844-高雄市六龜區-6403200",
      "845-高雄市內門區-6403500",
      "846-高雄市杉林區-6403400",
      "847-高雄市甲仙區-6403300",
      "848-高雄市桃源區-6403700",
      "849-高雄市那瑪夏區-6403800",
      "851-高雄市茂林區-6403600",
      "852-高雄市茄萣區-6402600",
      "880-澎湖縣馬公市-1001601",
      "881-澎湖縣西嶼鄉-1001604",
      "882-澎湖縣望安鄉-1001605",
      "883-澎湖縣七美鄉-1001606",
      "884-澎湖縣白沙鄉-1001603",
      "885-澎湖縣湖西鄉-1001602",
      "890-金門縣金沙鎮-0902002",
      "891-金門縣金湖鎮-0902003",
      "892-金門縣金寧鄉-0902004",
      "893-金門縣金城鎮-0902001",
      "894-金門縣烈嶼鄉-0902005",
      "896-金門縣烏坵鄉-0902006",
      "900-屏東縣屏東市-1001301",
      "901-屏東縣三地門鄉-1001326",
      "902-屏東縣霧台鄉-1001327",
      "903-屏東縣瑪家鄉-1001328",
      "904-屏東縣九如鄉-1001308",
      "905-屏東縣里港鄉-1001309",
      "906-屏東縣高樹鄉-1001311",
      "907-屏東縣鹽埔鄉-1001310",
      "908-屏東縣長治鄉-1001306",
      "909-屏東縣麟洛鄉-1001307",
      "911-屏東縣竹田鄉-1001314",
      "912-屏東縣內埔鄉-1001313",
      "913-屏東縣萬丹鄉-1001305",
      "920-屏東縣潮州鎮-1001302",
      "921-屏東縣泰武鄉-1001329",
      "922-屏東縣來義鄉-1001330",
      "923-屏東縣萬巒鄉-1001312",
      "924-屏東縣崁頂鄉-1001318",
      "925-屏東縣新埤鄉-1001315",
      "926-屏東縣南州鄉-1001320",
      "927-屏東縣林邊鄉-1001319",
      "928-屏東縣東港鎮-1001303",
      "929-屏東縣琉球鄉-1001322",
      "931-屏東縣佳冬鄉-1001321",
      "932-屏東縣新園鄉-1001317",
      "940-屏東縣枋寮鄉-1001316",
      "941-屏東縣枋山鄉-1001325",
      "942-屏東縣春日鄉-1001331",
      "943-屏東縣獅子鄉-1001332",
      "944-屏東縣車城鄉-1001323",
      "945-屏東縣牡丹鄉-1001333",
      "946-屏東縣恆春鎮-1001304",
      "947-屏東縣滿州鄉-1001324",
      "950-台東縣台東市-1001401",
      "951-台東縣綠島鄉-1001411",
      "952-台東縣蘭嶼鄉-1001416",
      "953-台東縣延平鄉-1001413",
      "954-台東縣卑南鄉-1001404",
      "955-台東縣鹿野鄉-1001405",
      "956-台東縣關山鎮-1001403",
      "957-台東縣海端鄉-1001412",
      "958-台東縣池上鄉-1001406",
      "959-台東縣東河鄉-1001407",
      "961-台東縣成功鎮-1001402",
      "962-台東縣長濱鄉-1001408",
      "963-台東縣太麻里鄉-1001409",
      "964-台東縣金峰鄉-1001414",
      "965-台東縣大武鄉-1001410",
      "966-台東縣達仁鄉-1001415",
      "970-花蓮縣花蓮市-1001501",
      "971-花蓮縣新城鄉-1001504",
      "972-花蓮縣秀林鄉-1001511",
      "973-花蓮縣吉安鄉-1001505",
      "974-花蓮縣壽豐鄉-1001506",
      "975-花蓮縣鳳林鎮-1001502",
      "976-花蓮縣光復鄉-1001507",
      "977-花蓮縣豐濱鄉-1001508",
      "978-花蓮縣瑞穗鄉-1001509",
      "979-花蓮縣萬榮鄉-1001512",
      "981-花蓮縣玉里鎮-1001503",
      "982-花蓮縣卓溪鄉-1001513",
      "983-花蓮縣富里鄉-1001510");
  }

  public function town6 () {
    
  $keys = array (
    array (
      'postal_code' => 902,
      'cate_name' => '屏東縣',
      'town_name' => '雾台乡',
      'cwb_town_id' => '1001327',
      'is_pass' => true
    )
  );
    foreach ($keys as $data) {
      if (!($result = $this->town_info ($data['cate_name'], $data['town_name'], $data['postal_code'], $data['is_pass']))) {
        echo color ('=> 錯誤', 'r') . ' 取不到 Google 資訊！'. $data['postal_code'] . "\n";
        TownLog::log ('取不到 Google 資訊！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Yahoo');
        continue;
      }
      echo "-> 新增 " . $data['cate_name'] . ' - ' . $data['town_name'] . ' - ' . $data['postal_code'] . "\n";
      
      if (!(($cate = TownCategory::find ('one', array ('conditions' => array ('name = ?', $result['info']['cate_name'])))) || verifyCreateOrm ($cate = TownCategory::create (array ('name' => $result['info']['cate_name']))))) {
        echo color ('=> 錯誤', 'r') . " 無鄉鎮分類！" . $result['info']['cate_name'] . "\n";        
        TownLog::log ('無鄉鎮分類！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
        continue;
      }

      if ($town = Town::find ('one', array ('conditions' => array ('town_category_id = ? AND name = ?', $cate->id, $result['info']['town_name'])))) {
        echo color ('=> 警告', 'r') . " 重複鄉鎮！" . $result['info']['town_name'] . "\n";        
        TownLog::log ('重複鄉鎮！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');
      } else {
        if (!verifyCreateOrm ($town = Town::create (array (
          'town_category_id' => $cate->id, 
          'name' => $result['info']['town_name'], 
          'postal_code' => $result['info']['postal_code'], 
          'latitude' => $result['location']['lat'], 
          'longitude' => $result['location']['lng'], 
          'pic' => '',
          'cwb_town_id' => $data['cwb_town_id'])))) {
          echo color ('=> 錯誤', 'r') . " 新增鄉鎮失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
          continue;
        }
        if (!$town->put_pic ()) {
          $town->destroy ();
          echo color ('=> 錯誤', 'r') . " 新增鄉鎮靜態圖失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮靜態圖失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
          continue;          
        }
      }

      echo "新增鄉鎮成功！" . $result['info']['town_name'] . "\n";        

      if (!$result['bounds']) {
        echo color ('=> 警告', 'g') . " 尚未取得到鄉鎮範圍值！" . $result['info']['town_name'] . "\n";        
        TownLog::log ('尚未取得到鄉鎮範圍值！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
        continue;
      }

      if ($town->bound) {
        $town->bound->northeast_latitude = $result['bounds']['northeast']['lat'];
        $town->bound->northeast_longitude = $result['bounds']['northeast']['lng'];
        $town->bound->southwest_latitude = $result['bounds']['southwest']['lat'];
        $town->bound->southwest_longitude = $result['bounds']['southwest']['lng'];
        if (!$town->bound->save ()) {
          echo color ('=> 警告', 'b') . " 更新鄉鎮範圍值失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('更新鄉鎮範圍值失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');          
        }
      } else {
        if (!verifyCreateOrm (TownBound::create (array (
                            'town_id' => $town->id,
                            'northeast_latitude' => $result['bounds']['northeast']['lat'],
                            'northeast_longitude' => $result['bounds']['northeast']['lng'],
                            'southwest_latitude' => $result['bounds']['southwest']['lat'],
                            'southwest_longitude' => $result['bounds']['southwest']['lng']
                          )))) {
          echo color ('=> 警告', 'b') . " 新增鄉鎮範圍值失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮範圍值失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');          
        }
      }
      echo "-----------------------------------------\n";
      sleep (1);
    }

  }
  public function town5 () {
    $this->data2 = array_map (function ($t) {
      $t = explode ('-', $t);
      return array (
        'postal_code' => $t[0],
        'cate_name' => mb_substr ($t[1], 0, 3),
        'town_name' => mb_substr ($t[1], 3),
        'cwb_town_id' => $t[2],
        'is_pass' => true
        );
    }, $this->data2);

    $keys = array ();
    foreach ($logs = TownLog::find ('all', array ('conditions' => array ('type = ?', 'Google'))) as $log) {
      $key = explode ('！', $log->message);
      $key = explode ('-', $key[1]);
      $key = $key[2];

      foreach ($this->data2 as $data)
        if ($data['postal_code'] == $key)
          array_push ($keys, $data);
    }

    foreach ($keys as $data) {
      if (!($result = $this->town_info ($data['cate_name'], $data['town_name'], $data['postal_code'], $data['is_pass']))) {
        echo color ('=> 錯誤', 'r') . ' 取不到 Google 資訊！'. $data['postal_code'] . "\n";
        TownLog::log ('取不到 Google 資訊！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Yahoo');
        continue;
      }
      echo "-> 新增 " . $data['cate_name'] . ' - ' . $data['town_name'] . ' - ' . $data['postal_code'] . "\n";
      
      if (!(($cate = TownCategory::find ('one', array ('conditions' => array ('name = ?', $result['info']['cate_name'])))) || verifyCreateOrm ($cate = TownCategory::create (array ('name' => $result['info']['cate_name']))))) {
        echo color ('=> 錯誤', 'r') . " 無鄉鎮分類！" . $result['info']['cate_name'] . "\n";        
        TownLog::log ('無鄉鎮分類！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
        continue;
      }

      if ($town = Town::find ('one', array ('conditions' => array ('town_category_id = ? AND name = ?', $cate->id, $result['info']['town_name'])))) {
        echo color ('=> 警告', 'r') . " 重複鄉鎮！" . $result['info']['town_name'] . "\n";        
        TownLog::log ('重複鄉鎮！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');
      } else {
        if (!verifyCreateOrm ($town = Town::create (array (
          'town_category_id' => $cate->id, 
          'name' => $result['info']['town_name'], 
          'postal_code' => $result['info']['postal_code'], 
          'latitude' => $result['location']['lat'], 
          'longitude' => $result['location']['lng'], 
          'pic' => '',
          'cwb_town_id' => $data['cwb_town_id'])))) {
          echo color ('=> 錯誤', 'r') . " 新增鄉鎮失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
          continue;
        }
        if (!$town->put_pic ()) {
          $town->destroy ();
          echo color ('=> 錯誤', 'r') . " 新增鄉鎮靜態圖失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮靜態圖失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
          continue;          
        }
      }

      echo "新增鄉鎮成功！" . $result['info']['town_name'] . "\n";        

      if (!$result['bounds']) {
        echo color ('=> 警告', 'g') . " 尚未取得到鄉鎮範圍值！" . $result['info']['town_name'] . "\n";        
        TownLog::log ('尚未取得到鄉鎮範圍值！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
        continue;
      }

      if ($town->bound) {
        $town->bound->northeast_latitude = $result['bounds']['northeast']['lat'];
        $town->bound->northeast_longitude = $result['bounds']['northeast']['lng'];
        $town->bound->southwest_latitude = $result['bounds']['southwest']['lat'];
        $town->bound->southwest_longitude = $result['bounds']['southwest']['lng'];
        if (!$town->bound->save ()) {
          echo color ('=> 警告', 'b') . " 更新鄉鎮範圍值失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('更新鄉鎮範圍值失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');          
        }
      } else {
        if (!verifyCreateOrm (TownBound::create (array (
                            'town_id' => $town->id,
                            'northeast_latitude' => $result['bounds']['northeast']['lat'],
                            'northeast_longitude' => $result['bounds']['northeast']['lng'],
                            'southwest_latitude' => $result['bounds']['southwest']['lat'],
                            'southwest_longitude' => $result['bounds']['southwest']['lng']
                          )))) {
          echo color ('=> 警告', 'b') . " 新增鄉鎮範圍值失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮範圍值失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');          
        }
      }
      echo "-----------------------------------------\n";
      sleep (1);
    }

  }
  public function town4 () {
    $this->data2 = array_map (function ($t) {
      $t = explode ('-', $t);
      return array (
        'postal_code' => $t[0],
        'cate_name' => mb_substr ($t[1], 0, 3),
        'town_name' => mb_substr ($t[1], 3),
        'cwb_town_id' => $t[2],
        'is_pass' => isset($t[3]) && ($t[3] == '!') ? true : false,
        );
    }, $this->data2);

    foreach ($this->data2 as $data) {
      if (!($result = $this->town_info ($data['cate_name'], $data['town_name'], $data['postal_code'], $data['is_pass']))) {
        echo color ('=> 錯誤', 'r') . ' 取不到 Google 資訊！'. $data['postal_code'] . "\n";
        TownLog::log ('取不到 Google 資訊！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Google');
        continue;
      }
      echo "-> 新增 " . $data['cate_name'] . ' - ' . $data['town_name'] . ' - ' . $data['postal_code'] . "\n";
      
      if (!(($cate = TownCategory::find ('one', array ('conditions' => array ('name = ?', $result['info']['cate_name'])))) || verifyCreateOrm ($cate = TownCategory::create (array ('name' => $result['info']['cate_name']))))) {
        echo color ('=> 錯誤', 'r') . " 無鄉鎮分類！" . $result['info']['cate_name'] . "\n";        
        TownLog::log ('無鄉鎮分類！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
        continue;
      }

      if ($town = Town::find ('one', array ('conditions' => array ('town_category_id = ? AND name = ?', $cate->id, $result['info']['town_name'])))) {
        echo color ('=> 警告', 'r') . " 重複鄉鎮！" . $result['info']['town_name'] . "\n";        
        TownLog::log ('重複鄉鎮！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');
      } else {
        if (!verifyCreateOrm ($town = Town::create (array (
          'town_category_id' => $cate->id, 
          'name' => $result['info']['town_name'], 
          'postal_code' => $result['info']['postal_code'], 
          'latitude' => $result['location']['lat'], 
          'longitude' => $result['location']['lng'], 
          'pic' => '',
          'cwb_town_id' => $data['cwb_town_id'])))) {
          echo color ('=> 錯誤', 'r') . " 新增鄉鎮失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
          continue;
        }
        if (!$town->put_pic ()) {
          $town->destroy ();
          echo color ('=> 錯誤', 'r') . " 新增鄉鎮靜態圖失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮靜態圖失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
          continue;          
        }
      }

      echo "新增鄉鎮成功！" . $result['info']['town_name'] . "\n";        

      if (!$result['bounds']) {
        echo color ('=> 警告', 'g') . " 尚未取得到鄉鎮範圍值！" . $result['info']['town_name'] . "\n";        
        TownLog::log ('尚未取得到鄉鎮範圍值！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Error');
        continue;
      }

      if ($town->bound) {
        $town->bound->northeast_latitude = $result['bounds']['northeast']['lat'];
        $town->bound->northeast_longitude = $result['bounds']['northeast']['lng'];
        $town->bound->southwest_latitude = $result['bounds']['southwest']['lat'];
        $town->bound->southwest_longitude = $result['bounds']['southwest']['lng'];
        if (!$town->bound->save ()) {
          echo color ('=> 警告', 'b') . " 更新鄉鎮範圍值失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('更新鄉鎮範圍值失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');          
        }
      } else {
        if (!verifyCreateOrm (TownBound::create (array (
                            'town_id' => $town->id,
                            'northeast_latitude' => $result['bounds']['northeast']['lat'],
                            'northeast_longitude' => $result['bounds']['northeast']['lng'],
                            'southwest_latitude' => $result['bounds']['southwest']['lat'],
                            'southwest_longitude' => $result['bounds']['southwest']['lng']
                          )))) {
          echo color ('=> 警告', 'b') . " 新增鄉鎮範圍值失敗！" . $result['info']['town_name'] . "\n";        
          TownLog::log ('新增鄉鎮範圍值失敗！ ' . $data['cate_name'] . '-' . $data['town_name'] . '-' . $data['postal_code'], 'Warning');          
        }
      }
      echo "-----------------------------------------\n";
      sleep (1);
    }
  }
  public function town_info ($cate, $town, $code, $is_pass) {
    $url = "https://maps.google.com/maps/api/geocode/json?sensor=false&address=" . urlencode ($cate . $town) . "&language=zh-TW&key=" . Cfg::setting ('google', ENVIRONMENT, 'server_key');
    $resp_json = file_get_contents ($url);
    $result = json_decode ($resp_json, true);

    if (!(isset ($result['results']) && isset ($result['status']) && ($result['status'] == 'OK') && count ($result = $result['results']) && count ($result = $result[0]) && isset ($result['address_components']) && isset ($result['geometry']['location']['lat']) && isset ($result['geometry']['location']['lng'])))
      return array ();

    $cate_name = '';
    $town_name = '';
    $postal_code = '';
    foreach ($result['address_components'] as $component) {
      if ($component['long_name'] == $town)
        $town_name = $component['long_name'];
      if ($component['long_name'] == $cate)
        $cate_name = $component['long_name'];
      if (in_array ('postal_code', $component['types']) && ($component['long_name'] == $code))
        $postal_code = $component['long_name'];
    }
    if ($is_pass)
      $cate_name = $cate;
    if ($is_pass)
      $postal_code = $code;

    if (!($cate_name && $town_name && $postal_code))
      return array ();
    return array (
        'info' => array ('cate_name' => $cate_name, 'town_name' => $town_name, 'postal_code' => $postal_code),
        'bounds' => isset ($result['geometry']['bounds']['northeast']['lat']) && isset ($result['geometry']['bounds']['northeast']['lng']) && isset ($result['geometry']['bounds']['southwest']['lat']) && isset ($result['geometry']['bounds']['southwest']['lng']) ? $result['geometry']['bounds'] : array (),
        'location' => $result['geometry']['location'],
      );
  }
  public function town2 () {
    $this->data2 = array_map (function ($t) {
      $t = explode ('-', $t);
      return array (
        'postal_code' => $t[0],
        'cate' => mb_substr ($t[1], 0, 3),
        'cate_key' => mb_substr ($t[1], 0, 2),
        'name' => mb_substr ($t[1], 3),
        'name_key'=> mb_substr ($t[1], 3, -1),
        'data_id' => $t[2],
        );
    }, $this->data2);

    // echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
    // var_dump ($this->data2);
    // exit ();

    foreach ($this->data2 as $data) {
      if (!($cate = TownCategory::find ('one', array ('conditions' => array ('name LIKE CONCAT("%", ? ,"%")', $data['cate_key'])))))
        continue;

      if (!($town = Town::find ('one', array ('conditions' => array ('town_category_id = ? AND name LIKE CONCAT("%", ? ,"%")', $cate->id, $data['name_key'])))))
        continue;
echo $data['name_key'] . "\n";
      $town->name = $data['name'];
      $town->postal_code = $data['postal_code'];
      $town->data_id = $data['data_id'];
      $town->save ();
    }
  }
  public function town () {
    foreach ($this->data as $value) {
      $cate_name = $value[0];
      $town_name = $value[1];
      $lat = $value[3];
      $lng = $value[2];

      if (!(($cate = TownCategory::find ('one', array ('conditions' => array ('name = ?', $cate_name)))) || verifyCreateOrm ($cate = TownCategory::create (array ('name' => $cate_name)))))
        continue;

      if (!($town = Town::find ('one', array ('conditions' => array ('name = ?', $town_name)))))
        if (verifyCreateOrm ($town = Town::create (array ('town_category_id' => $cate->id, 'name' => $town_name, 'postal_code' => uniqid (), 'latitude' => $lat, 'longitude' => $lng, 'pic' => ''))))
          if (!$town->put_pic ())
            $town->destroy ();
    }
  }
  public function color2 () {
    $pics = GoalPicture::find ('all', array ('select' => '*, COUNT(id) AS count', 'order' => 'count DESC', 'group' => 'ROUND(color_red / 30), ROUND(color_green / 30), ROUND(color_blue / 30)', 'conditions' => array ('')));

    $this->set_method ('index')->load_view (array (
        'pics' => $pics
      ));
  }

  public function color () {
    $pics = GoalPicture::find ('all');
    foreach ($pics as $pic) {
      $pic->update_color ();
    }
    $this->set_method ('index')->load_view (array (
        'pics' => $pics
      ));
  }
  public function test () {
    // foreach (Goal::all () as $goal) {
    //   if ($goal->view)
    //     $goal->view->pic->put_url ('http://dev.go.ioa.tw/' . implode ('/', $goal->view->pic->path ()));

    //   $goal->pic->put_url ('http://dev.go.ioa.tw/' . implode ('/', $goal->pic->path ()));
    //   echo $goal->id . "\n";
    // }
    
    // echo "===================================== \n";

    // foreach (GoalPicture::all () as $pic) {
    //   $pic->name->put_url ('http://dev.go.ioa.tw/' . implode ('/', $pic->name->path ()));
    //   echo $pic->id . "-\n";
    // }
    $this->load->library ('CreateDemo');

    foreach (Goal::all () as $goal) {
      $comments = range (0, rand (0, 10));
      echo "\n   新增 " . count ($comments) . "筆 GoalComment\n   ---------------------------------------\n";
      foreach ($comments as $comment)
        if ($user = User::find ('one', array ('select' => 'id', 'order' => 'RAND()', 'conditions' => array ())))
          if (verifyCreateOrm ($comment = GoalComment::create (array ('goal_id' => $goal->id, 'user_id' => $user->id, 'content' => CreateDemo::text (10, 500)))))
            echo " Create a GoalComment, id: " . $comment->id . "\n";
    }
  }
  public function create () {
    $lat = 25.03684951358938;
    $lng = 121.54878616333008;

    $this->load->library ('CreateDemo');

    $times = range (3, rand (3, 10));
    echo "\n 新增 " . count ($times) . "筆 User\n==========================================\n";
    foreach ($times as $time)
      if (verifyCreateOrm ($user = User::create (array ('uid' => uniqid (), 'name' => CreateDemo::text (4, 10)))))
        echo " Create a User, id: " . $user->id . "\n";

    $user_count = User::count ();

    $times = range (3, rand (3, 10));
    echo "\n 新增 " . count ($times) . "筆 GoalTagCategory\n==========================================\n";
    foreach ($times as $time)
      if (verifyCreateOrm ($cate = GoalTagCategory::create (array ('name' => CreateDemo::text (2, 6)))))
        echo " Create a GoalTagCategory, id: " . $cate->id . "\n";

    $cate_count = GoalTagCategory::count ();

    $times = range (10, rand (10, 30));
    echo "\n 新增 " . count ($times) . "筆 GoalTag\n==========================================\n";
    foreach ($times as $time) {
      if (!rand (0, $cate_count))
        $cate = GoalTagCategory::find ('one', array ('select' => 'id', 'order' => 'RAND()', 'conditions' => array ()));
      else
        $cate = null;

      if (verifyCreateOrm ($tag = GoalTag::create (array ('goal_tag_category_id' => $cate ? $cate->id : 0, 'name' => CreateDemo::text (2, 6)))))
        echo " Create a GoalTag, id: " . $tag->id . "\n";
    }

    $tag_count = GoalTag::count ();

    $times = range (1, rand (50, 100));
    echo "\n 新增 " . count ($times) . "筆 Goal\n==========================================\n";
    foreach ($times as $time) {
      $user = User::find ('one', array ('select' => 'id', 'order' => 'RAND()', 'conditions' => array ()));
      $params = array (
          'user_id' => $user->id,
          'title' => CreateDemo::text (10, 50),
          'address' => CreateDemo::text (30, 80),
          'introduction' => CreateDemo::text (100, 500),
          'score' => 0,
          'pageview' => rand (0, 500),
          'latitude' => $lat + (rand (-99999999, 99999999) * 0.000000001),
          'longitude' => $lng + (rand (-99999999, 99999999) * 0.000000001),
          'pic' => ''
        );
      if (verifyCreateOrm ($goal = Goal::create ($params)) && $goal->put_pic ()) {
        echo " Create a Goal, id: " . $goal->id . "\n";

        $limit = rand (0, $tag_count / 2);
        echo "\n   新增 " . $limit . "筆 GoalTag\n   ---------------------------------------\n";
        if ($limit)
          foreach (GoalTag::find ('all', array ('select' => 'id', 'order' => 'RAND()', 'limit' => $limit, 'conditions' => array ())) as $tag)
            if (verifyCreateOrm ($goal_tag_map = GoalTagMap::create (array ('goal_id' => $goal->id, 'goal_tag_id' => $tag->id)))) 
              echo "   Create a GoalTagMap, id: " . $goal_tag_map->id . "\n";

        $pics = CreateDemo::pics (0, 5, $tags = array ('貓咪', '貓', '貓星人', '柴犬', '可愛', '狗', '寵物', '台灣', '名人'));
        echo "\n   新增 " . count ($pics) . "筆 GoalPicture\n   ---------------------------------------\n";
        foreach ($pics as $pic)
          if (verifyCreateOrm ($picture = GoalPicture::create (array ('goal_id' => $goal->id, 'name' => '', 'gradient' => 1, 'color_red' => -1, 'color_green' => -1, 'color_blue' => -1, 'ori_url' => $pic['url']))))
            if (!$picture->name->put_url ($pic['url']))
              $picture->destroy ();
            else {
              $picture->update_gradient_and_color ();
              echo "   Create a GoalPicture, id: " . $picture->id . "\n";
            }

        $links = range (1, rand (1, 5));
        echo "\n   新增 " . count ($links) . "筆 GoalLink\n   ---------------------------------------\n";
        foreach ($links as $link)
          if (verifyCreateOrm ($link = GoalLink::create (array ('goal_id' => $goal->id, 'value' => CreateDemo::password (50)))))
            echo " Create a GoalLink, id: " . $link->id . "\n";

        $limit = rand (0, $user_count / 2);
        echo "\n   新增 " . $limit . "筆 Score\n   ---------------------------------------\n";
        foreach (User::find ('all', array ('select' => 'id', 'order' => 'RAND()', 'limit' => $limit, 'conditions' => array ())) as $user)
          $goal->add_score ($user->id, rand (0, 100));

        $comments = range (0, rand (0, 10));
        echo "\n   新增 " . count ($comments) . "筆 GoalComment\n   ---------------------------------------\n";
        foreach ($comments as $comment)
          if ($user = User::find ('one', array ('select' => 'id', 'order' => 'RAND()', 'conditions' => array ())))
            if (verifyCreateOrm ($comment = GoalComment::create (array ('goal_id' => $goal->id, 'user_id' => $user->id, 'content' => CreateDemo::text (10, 500)))))
              echo " Create a GoalComment, id: " . $comment->id . "\n";

        echo "\n";
      } else {
        $goal->destroy ();
      }
    }
  }
}
