# Laravel Facebook API Application

Ceci est une application qui vous permettra de publier des articles, directemement sur vos pages Facebook



## Installation et configuration

```bash
  git clone https://github.com/sidiki123/laravel_facebook_api_app.git
```


```bash
  cd laravel_facebook_api_app
  composer install
  copy .env.example .env
  php artisan key:generate
```

Ajouter ces variables d'environnement si elles sont inexistantes
```bash
  FACEBOOK_APP_ID =
  FACEBOOK_APP_SECRET =
  FACEBOOK_REDIRECT =
```

    
## configuration compte Meta developpers
Se rendre à l'adresse https://developers.facebook.com/apps et créer une nouvelle application

![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/1.png)
  
Selectionner le type d'application
![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/2.png)

Donner un nom à votre application
![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/3.png)

Selectionner une plateforme pour votre application(website dans notre cas)
![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/4.png)

Renseigner l'adresse locale ou distante de votre application. En rappel celle-ci servira comme valeur
 de notre variable d'environnement FACEBOOK_REDIRECT 
![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/5.png)

Configurer la suite de votre applicationen y ajoutant un produit
![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/7.png)

Ajouter une URI de redirection OAuth valide à votre application
![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/8.png)

configuration des variables d'environnement cités en haut
![App Screenshot](https://raw.githubusercontent.com/sidiki123/laravel_facebook_api_app/master/public/captures/6.png)
