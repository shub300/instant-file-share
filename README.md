## Introduction

Instant file share application makes file sharing easy with all viewers who are active on the page. This application makes the best use of Laravel web socket, Broadcasting and Laravel Echo to deliver files instantly with the users active on the page without needing them to refresh the page.

User 1 uploading files
![File Share Screenshot 1](https://github.com/shub300/instant-file-share/blob/master/public/assets/images/ss1.png?raw=true)

Files Uploded and shown on user 1 end
![File Share Screenshot 2](https://github.com/shub300/instant-file-share/blob/master/public/assets/images/ss2.png?raw=true)

User 2 receives files instantly on their end
![File Share Screenshot 3](https://github.com/shub300/instant-file-share/blob/master/public/assets/images/ss3.png?raw=true)

### Technologies Used

- **[Laravel Websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction)**
- **[Laravel Echo](https://laravel.com/docs/8.x/broadcasting)**
- **[Bootstrap & Dropzone js]**

## How To Setup

After downloading the app do the following:

```bash
npm install

composer update
```
For starting WebSocket server:

```bash
php artisan websocket:serve
```
Open the app and start Sharing
