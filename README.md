# LetsGenerate.ai
AI Generation app

Live at [LetsGenerate.ai](https://letsgenerate.ai)

#### WARNING: This repo was primarily built using ChatGPT prompts and hard coded variables. Viewer discretion is advised 😉


## Setup API

CERTBOT
```
sudo apt update
sudo apt install certbot python3-certbot-nginx
sudo certbot certonly --standalone -d your_domain.com
sudo certbot --nginx -d your_domain.com
```

pip install gunicorn
```
gunicorn --certfile=/etc/letsencrypt/live/your_domain.com/fullchain.pem --keyfile=/etc/letsencrypt/live/your_domain.com/privkey.pem --bind 0.0.0.0:443 your_flask_app:app
```



NGINX
```
apt update
apt install nginx
mv /path/to/html /var/www/html/
chmod 644 /var/www/html/index.html
chown www-data:www-data /var/www/html/index.html
ufw allow "nginx full"
sudo nginx -t
systemctl start nginx
```


RUN
```
gunicorn \
--certfile=/etc/letsencrypt/live/your_domain.com/fullchain.pem \
--keyfile=/etc/letsencrypt/live/your_domain.com/privkey.pem \
--bind your_domain.com:5000 \
--workers 4 \
--timeout 1320 \
api:app
```

## Setup Frontend

Serve php files with assets folder from a server that supports php. Such as Apache2.