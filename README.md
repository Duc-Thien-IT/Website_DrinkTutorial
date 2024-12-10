# Website_DrinkTutorial
Website Manage Information App DrinkTutorial
                         SET UP
- Install Full PHP version 8.2 and lastest, Composer
- Install Full Package for PHP Laravel: grpc [https://pecl.php.net/package/gRPC/1.68.0/windows]
- Enable package in php.ini:
	extension=grpc
	extension=sodium
	extension=zip
- Create Firebase Database Realtime and add app for website with name website application your choose.
- Project setting -> General (scrool down general and save firebase config)
- Project setting -> service account -> generate new private key (save key in folder PC)
- Enable authentication with Google/Password
                        SETTING
- Run terminal: 
  1. composer update
	2. copy .env.example .env
	3. php artisan key:generate
- Add config in file .env [FIREBASE_API_KEY, FIREBASE_AUTH_DOMAIN, FIREBASE_DATABASE_URL, FIREBASE_PROJECT_ID,
FIREBASE_STORAGE_BUCKET, FIREBASE_MESSAGING_SENDER_ID FIREBASE_APP_ID, FIREBASE_MEASUREMENT_ID) same code in general firebase project setting.

- Add full ("generate new private key.json") download in "resources\credentials\firebase_credentials.json"
- Run project: php artisan serve
