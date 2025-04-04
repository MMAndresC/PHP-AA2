## Aplicación forum

### Especificaciones  
  
#### PHP (Versiones empleadas en el desarrollo)
  - PHP language level 8.3 
  - CLI interpreter 8.3.15  
#### CSS  
  - Bulma  
    https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css  
  - Awesome fonts 5  
    https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css 
  
#### XAMP (Apache y mySQL)

### Archivo .htaccess  
  
Para controlar los errores HTTP de manera customizada este fichero permite al servidor apache redirigir a una vista de errores cuando hay un error HTTP.  

El archivo permite al servidor escribir la ruta del proyecto en el archivo **error_http.php** ya que la ruta de la vista de errores está especificada como ruta relativa a la carpeta del proyecto.  

En el caso de que esto falle puede ser que el archivo **error_http.php** no tenga los permisos necesarios para que el servidor sobreescriba la ruta, en este caso ejecutar en la consola de comandos:  

`CMD: icacls forum\view\error_http.php /grant Users:R`  
  
`Linux: chmod 644 forum/view/error_http.php`  
  
### Base de datos  
El archivo para configurar la base de datos es:  
`/config/db_connection.php`  
Tiene la configuración por defecto para funcionar en local y por el puerto por defecto de mySQL 3306.  
Si no es la configuración adecuada, modificar las variables con los valores correctos.  

No es necesarío crear la base de datos Forum o las tablas antes, está configurado para que en el index.php realice todas las operaciones necesarias.  
También se ejecuta en un primer arranque un seeder que guarda en las tablas unos registros de prueba para facilitar poder comprobar la funcionalidad de la aplicación.

#### Usuarios de prueba:  
Email: admin@example.com  Password: 1234  Rol: admin  
Email: super_pro99@example.com  Password: 1234  Rol: moderator  
Email: gg@example.com  Password: 1234  Rol: user  
  
### Sendmail 
Para activar un nuevo usuario es necesarío tener el servicio email de **XAMP** configurado para que pueda mandar el email.  
Para configurarlo hay que editar el archivo **apache/php.ini**, buscar las opciones indicadas abajo y editar los valores como se muestra abajo para una configuración con correo de Google:  

[mail function]  
SMTP=smtp.gmail.com  
smtp_port=587

; For Win32 only.  
sendmail_from =xxxxxxxxxx@gmail.com (Remitente del email)  

El otro archivo que hay que editar es **sendmail/sendmail.ini**, estos son los valores que hay que modificar:  

smtp_server=smtp.gmail.com  
smtp_ssl=tls  
smtp_port=587  
auth_username=xxxxxxxxxx@gmail.com (Remitente del email)  
auth_password= Contraseña de aplicación que se genera en la cuenta de Google  
force_sender=xxxxxxxxxx@gmail.com (Remitente del email)  



  




