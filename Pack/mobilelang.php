<?PHP
if (!defined('SYSINFO')) exit;
if (isset($_REQUEST['ll'])) $lang = strip_tags($_REQUEST['ll']);
else $lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);

$lang_username = "Username";
$lang_password = "Password";
$lang_signin = "sign in";
$lang_desktopver = "Desktop version";
$lang_whatis = "What is eyeOS?";
$lang_theproject = "The eyeOS Project";
$lang_fileintrash = "File moved to trash";
$lang_dirremoved = "Directory removed";
$lang_dirnotempty = "The directory is not empty";
$lang_home = "My Home";
$lang_download = "Download";
$lang_delete = "Delete";
$lang_dirempty = "This directory is empty";
$lang_uploadfile = "Upload a file:";
$lang_upload = "Upload";
$lang_createdir = "Create a directory:";
$lang_create = "create";
$lang_signout = "Sign out";

switch ($lang) {
case "ar" :
    $lang_signout = "إنهاء الجلسة";
break;
case "ms" :
    $lang_signout = "Tutup sesi";
break;
case "bn" :
    $lang_username = "ব্যাবহারকারী";
    $lang_password = "পাসওয়ার্ড";
    $lang_signin = "সাইন-ইন";
    $lang_create = "তৈরী কর";
    $lang_signout = "অধিবেশন বন্ধ কর";
break;
case "pt_BR" :
    $lang_username = "Usuário";
    $lang_password = "Senha";
    $lang_signin = "entrar";
    $lang_create = "criar";
break;
case "bg" :
    $lang_username = "Потребител";
    $lang_password = "Парола";
    $lang_signin = "вход";
    $lang_fileintrash = "Файлът е преместен в кошчето";
    $lang_uploadfile = "Качване на файл:";
    $lang_create = "създаване";
    $lang_signout = "Затваряне на сесията";
break;
case "ca" :
    $lang_username = "Usuari";
    $lang_password = "Contrasenya";
    $lang_signin = "entrar";
    $lang_fileintrash = "Arxiu mogut a la paperera";
    $lang_uploadfile = "Puja un arxiu:";
    $lang_create = "crear";
    $lang_signout = "Tancar la sessió";
break;
case "cs" :
    $lang_signout = "Ukončit sezení";
break;
case "zh" :
    $lang_username = "帳號";
    $lang_password = "密碼";
    $lang_signin = "登入";
    $lang_fileintrash = "文件移动到回收站";
    $lang_uploadfile = "上传一个文件:";
    $lang_create = "創建";
    $lang_signout = "登出";
break;
case "hr" :
    $lang_signout = "Zatvori sesiju";
break;
case "da" :
    $lang_fileintrash = "Filen blev flyttet til Affaldspanden";
    $lang_uploadfile = "Upload en fil:";
break;
case "de" :
    $lang_username = "Benutzername";
    $lang_password = "Passwort";
    $lang_signin = "Anmelden";
    $lang_desktopver = "Desktop-Version";
    $lang_whatis = "Was ist eyeOS?";
    $lang_theproject = "Das eyeOS-Projekt";
    $lang_fileintrash = "Datei in den Papierkorb verschoben";
    $lang_dirremoved = "Ordner gelöscht";
    $lang_dirnotempty = "Der Ordner ist nicht leer";
    $lang_home = "persönliche Dateien";
    $lang_download = "Download";
    $lang_delete = "Löschen";
	$lang_dirempty = "Der Ordner ist leer";
    $lang_uploadfile = "Datei hochladen:";
    $lang_upload = "Hochladen";
    $lang_createdir = "Neuen Ordner anlegen:";
    $lang_create = "Erstellen";
    $lang_signout = "Abmelden";
break;
case "es" :
    $lang_username = "Usuario";
    $lang_password = "Contraseña";
    $lang_signin = "entrar";
    $lang_fileintrash = "Archivo movido a la papelera";
    $lang_uploadfile = "Subir un archivo:";
    $lang_create = "crear";
    $lang_signout = "Cerrar la sessión";
break;
case "eu" :
    $lang_signout = "Saioa amaitu";
break;
case "fr" :
    $lang_username = "Nom d'utilisateur";
    $lang_password = "Mot de passe";
    $lang_signin = "identifier";
    $lang_fileintrash = "Fichier déplacé dans la corbeille";
    $lang_dirremoved = "Répertoire supprimé";
    $lang_dirnotempty = "Le répertoire n'est pas vide";
    $lang_dirempty = "Ce répertoire est vide";
    $lang_uploadfile = "Uploader un fichier:";
    $lang_createdir = "Créer un nouveau répertoire:";
    $lang_create = "Créer";
    $lang_signout = "Fermer la session";
break;
case "gl" :

break;
case "el" :
    $lang_username = "Όνομα Χρήστη";
    $lang_password = "Κωδικός";
    $lang_signin = "Σύνδεση";
    $lang_create = "Δημιουργία";
    $lang_signout = "Κλείσιμο Σύνδεσης";
break;
case "it" :
    $lang_username = "Nome Utente";
    $lang_password = "Password";
    $lang_signin = "entra";
    $lang_fileintrash = "Il file è stato spostato nel cestino";
    $lang_uploadfile = "Carica un file:";
    $lang_create = "crea";
    $lang_signout = "Chiudi sessione";
break;
case "ja" :
    $lang_signout = "セッションを閉じる";
break;
case "ko" :
    $lang_signout = "세션 닫기";
break;
case "hu" :
    $lang_fileintrash = "Fájl a Lomtárba helyezve";
    $lang_uploadfile = "Fájl feltöltése:";
break;
case "nl" :
    $lang_username = "Gebruikersnaam";
    $lang_password = "Wachtwoord";
    $lang_signin = "aanmelden";
    $lang_fileintrash = "Bestand naar prullenbak verplaatst";
    $lang_uploadfile = "Bestand uploaden:";
    $lang_create = "aanmaken";
    $lang_signout = "Sessie beeindigen.";
break;
case "no" :
    $lang_signout = "Avslutt økten";
break;
case "ir" :
    $lang_username = "نام کاربری";
    $lang_password = "کلمه عبور";
    $lang_signin = "ورود";
    $lang_create = "ایجاد";
break;
case "pl" :
    $lang_fileintrash = "Plik został przeniesiony do kosza";
    $lang_uploadfile = "Wgraj plik:";
    $lang_signout = "Zamknij sesję";
break;
case "pt" :
    $lang_username = "Utilizador";
    $lang_password = "Palavra-chave";
    $lang_signin = "entrar";
    $lang_fileintrash = "Documento movido para a lixeira";
    $lang_uploadfile = "Inserir um documento:";
    $lang_create = "criar";
    $lang_signout = "Fechar sessão";
break;
case "ro" :
    $lang_fileintrash = "Fisierul a fost sters";
    $lang_uploadfile = "Incarca un fisier:";
    $lang_signout = "Inchide sesiunea";
break;
case "ru" :
    $lang_username = "Пользователь";
    $lang_password = "Пароль";
    $lang_signin = "войти";
    $lang_fileintrash = "Файл выброшен в мусорник";
    $lang_uploadfile = "Залить файл:";
    $lang_create = "создать";
    $lang_signout = "Завершить сеанс";
break;
case "sk" :
    $lang_username = "Uporabnisko ime";
    $lang_password = "Geslo";
    $lang_signin = "prijava";
    $lang_create = "ustvari";
    $lang_signout = "Ukončiť sedenie";
break;
case "fi" :
    $lang_username = "Käyttäjänimi";
    $lang_password = "Salasana";
    $lang_signin = "kirjaudu";
    $lang_fileintrash = "Tiedosto on siirretty roskakoriin";
    $lang_uploadfile = "Lähetä tiedosto:";
    $lang_create = "lähetä";
    $lang_signout = "Sulje istunto";
break;
case "sv" :
    $lang_username = "Användarnamn";
    $lang_password = "Lösenord";
    $lang_signin = "logga in";
    $lang_fileintrash = "Filen flyttades till papperskorgen";
    $lang_uploadfile = "Ladda upp en fil:";
    $lang_create = "skapa";
    $lang_signout = "Logga ut och avsluta";
break;
case "th" :
    $lang_username = "ชื่อผู้ใช้งาน";
    $lang_password = "รหัสผ่าน";
    $lang_signin = "เข้าระบบ";
    $lang_create = "สร้าง";
break;
case "tr" :
    $lang_username = "Kullanici Adi";
    $lang_password = "Sifre";
    $lang_signin = "giris";
    $lang_fileintrash = "Dosya çöp kutusuna taşındı";
    $lang_uploadfile = "Dosya Gönderimi:";
    $lang_create = "olustur";
    $lang_signout = "Oturumu sonlandır";
break;
case "ua" :
    $lang_username = "Користувач";
    $lang_password = "Пароль";
    $lang_signin = "увійти";
    $lang_create = "створити";
    $lang_signout = "Припинити сесію";
break;
case "vi" :
    $lang_signout = "Zatvori sesiju";
break;
default:
    $lang_username = "Username";
    $lang_password = "Password";
    $lang_signin = "sign in";
    $lang_desktopver = "Desktop version";
    $lang_whatis = "What is eyeOS?";
    $lang_theproject = "The eyeOS Project";
    $lang_fileintrash = "File moved to trash";
    $lang_dirremoved = "Directory removed";
    $lang_dirnotempty = "The directory is not empty";
    $lang_home = "My Home";
    $lang_download = "Download";
    $lang_delete = "Delete";
    $lang_dirempty = "This directory is empty";
    $lang_uploadfile = "Upload a file:";
    $lang_upload = "Upload";
    $lang_createdir = "Create a directory:";
    $lang_create = "create";
    $lang_signout = "Sign out";
break;
}
?>