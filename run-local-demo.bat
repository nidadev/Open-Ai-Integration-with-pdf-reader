@echo off
set PHP_BIN=C:\Users\SplitArt\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe
set PHP_EXT=C:\Users\SplitArt\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\ext

"%PHP_BIN%" ^
  -d extension_dir="%PHP_EXT%" ^
  -d extension=php_openssl.dll ^
  -d extension=php_curl.dll ^
  -d extension=php_fileinfo.dll ^
  -d extension=php_mbstring.dll ^
  -d extension=php_pdo_sqlite.dll ^
  -d extension=php_sqlite3.dll ^
  -d extension=php_pdo_mysql.dll ^
  -d extension=php_zip.dll ^
  -S 127.0.0.1:8003 ^
  -t public
