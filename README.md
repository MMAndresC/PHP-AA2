## Configuración  
  
### Archivo .htaccess  
  
Para controlar los errores HTTP de manera customizada este fichero permite al servidor apache redirigir a una vista de errores cuando hay un error HTTP.  

El archivo permite al servidor escribir la ruta del proyecto en el archivo **error_http.php** ya que la ruta de la vista de errores está especificada como ruta relativa a la carpeta del proyecto.  

En el caso de que esto falle puede ser que el archivo **error_http.php** no tenga los permisos necesarios para que el servidor sobreescriba la ruta, en este caso ejecutar en la consola de comandos:  

`CMD: icacls forum\view\error_http.php /grant Users:R`  
  
`Linux: chmod 644 forum/view/error_http.php`

