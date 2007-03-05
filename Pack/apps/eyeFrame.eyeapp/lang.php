<?PHP
/* Application language file 
   */
   
$AppLanguages = array (
'english' => array (), // 3 strings
'arabic' => array ( // 3 strings
	"Help for %0" => "المعاون ل %0",
	"Viewing %0" => "إظهار %0",
	"Print" => "طباعة",
),
'bahasa melayu' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'bangla' => array ( // 3 strings
	"Help for %0" => "%0 এর জন্য সহায়িকা",
	"Viewing %0" => "%0 প্রদর্শিত হচ্ছে",
	"Print" => "প্রিন্ট",
),
'brasileiro/português' => array ( // 3 strings
	"Help for %0" => "Ajuda para %0",
	"Viewing %0" => "Visualizando %0",
	"Print" => "Imprimir",
),
'bulgarian' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'català' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'český' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'chinese' => array ( // 3 strings
	"Help for %0" => "%0的說明",
	"Viewing %0" => "檢視%0",
	"Print" => "列印",
),
'croatian' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'dansk' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'deutsch' => array ( // 3 strings
	"Help for %0" => "Hilfe für %0",
	"Viewing %0" => "Geöffnet: %0",
	"Print" => "Drucken",
),
'español' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'euskara' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'français' => array ( // 3 strings
	"Help for %0" => "Aide sur %0",
	"Viewing %0" => "Visualisation de %0",
	"Print" => "Imprimer",
),
'galego' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'greek' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'italiano' => array ( // 3 strings
	"Help for %0" => "Βοήθεια για %0",
	"Viewing %0" => "Εμφάνιση %0",
	"Print" => "Εκτύπωση",
),
'japanese' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'korean' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'magyar' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'nederlands' => array ( // 3 strings
	"Help for %0" => "Hulp voor %0",
	"Viewing %0" => "Bekijken van %0",
	"Print" => "Printen",
),
'norsk' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'polski' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'português' => array ( // 3 strings
	"Help for %0" => "Ajuda para %0",
	"Viewing %0" => "Vendo %0",
	"Print" => "Imprimir",
),
'românesc' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'russian' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'slovenský' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'suomalainen' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'svensk' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
'türk' => array ( // 3 strings
	"Help for %0" => "%0 hakkında yardım",
	"Viewing %0" => "%0 izleniyor",
	"Print" => "Yazdır",
),
'ukrainian' => array ( // 3 strings
	"Help for %0" => "Допомога при %0",
	"Viewing %0" => "Переглянути %0",
	"Print" => "Надрукувати",
),
'việt' => array ( // 0 strings
	"Help for %0" => "",
	"Viewing %0" => "",
	"Print" => "",
),
);
   global $Translations;
   if (isset ($AppLanguages[$select = !empty ($_SESSION['lang']) ? $_SESSION['lang'] : DEFAULTLANG]))
      $Translations = array_merge ($Translations, $AppLanguages[$select]);   
?>
