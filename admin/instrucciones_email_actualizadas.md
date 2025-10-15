# 📧 Guía Actualizada: Configuración de Email para Sistema de Reservas

## 🔄 Mejoras Implementadas

Se han realizado las siguientes mejoras en el sistema de envío de emails:

1. **Código simplificado**: Se ha unificado el sistema de envío de emails para evitar conflictos.
2. **Mejor diagnóstico**: Se ha creado una herramienta específica para diagnosticar problemas.
3. **Registro de errores**: Se registran los intentos de envío para facilitar la solución de problemas.

## 🔧 Configuración de Gmail SMTP

### 1. **Verificar la cuenta de Gmail**

Para que el sistema funcione correctamente, debes:

- Usar una cuenta de Gmail
- Tener activada la verificación en 2 pasos
- Generar una contraseña de aplicación específica

### 2. **Verificar/Actualizar la contraseña de aplicación**

Las contraseñas de aplicación pueden expirar o ser revocadas. Para verificar o crear una nueva:

1. Ve a [Seguridad de Google](https://myaccount.google.com/security)
2. Busca "Contraseñas de aplicaciones" (solo aparece si tienes verificación en 2 pasos activada)
3. Verifica si existe una contraseña para "Sistema de Reservas" o crea una nueva:
   - Selecciona "Correo" como aplicación
   - Selecciona "Otro" como dispositivo
   - Escribe "Sistema de Reservas" como nombre
   - Haz clic en "Generar"
4. Copia la contraseña generada (16 caracteres sin espacios)
5. Actualiza el archivo `config_email.php` con la nueva contraseña:

```php
define('SMTP_USERNAME', 'tu-email@gmail.com');     // ← Tu Gmail
define('SMTP_PASSWORD', 'abcdefghijklmnop');       // ← Nueva contraseña de app (16 caracteres)
define('SMTP_FROM_EMAIL', 'tu-email@gmail.com');   // ← Tu Gmail
```

## 🔍 Diagnóstico de Problemas

### Usar la herramienta de diagnóstico

Se ha creado una herramienta específica para diagnosticar problemas con el envío de emails:

1. Accede a: `/citas/admin/test_conexion_smtp.php`
2. La herramienta realizará automáticamente:
   - Verificación de la configuración
   - Prueba de conexión SMTP
   - Prueba de envío de email
3. Sigue las instrucciones que aparecen en pantalla según los resultados

### Problemas comunes y soluciones

| Problema | Posible Causa | Solución |
|----------|---------------|----------|
| "Authentication failed" | Contraseña incorrecta o expirada | Generar nueva contraseña de aplicación |
| "Must issue a STARTTLS command first" | Configuración de puerto incorrecta | Verificar que el puerto sea 587 |
| "Connection refused" | Firewall o antivirus bloqueando | Desactivar temporalmente firewall/antivirus |
| "Verification in 2 steps required" | No tienes verificación en 2 pasos | Activar verificación en 2 pasos en Google |
| No llegan los correos | Pueden estar en spam | Revisar carpeta de spam |

## ✅ Probar el Sistema Completo

Una vez que la herramienta de diagnóstico muestre resultados exitosos:

1. Ve al panel de administración: `/citas/admin/mod_reservas.php`
2. Cambia el estado de una reserva a "Confirmado" o "Cancelado"
3. Verifica que:
   - El estado se actualice en la base de datos
   - El cliente reciba el email de notificación

## 📱 Formato de los Emails

Los clientes recibirán emails con:

- Diseño profesional en HTML
- Detalles completos de su reserva
- Estado actualizado (Confirmado/Cancelado)
- Instrucciones según el nuevo estado

## 🚨 Consideraciones Importantes

- **Nunca** uses tu contraseña normal de Gmail, siempre usa una contraseña de aplicación
- Si cambias la contraseña de tu cuenta de Gmail, las contraseñas de aplicación seguirán funcionando
- Si desactivas la verificación en 2 pasos, todas las contraseñas de aplicación dejarán de funcionar
- Gmail tiene límites de envío (500 emails/día para cuentas personales)
- Para volúmenes mayores, considera usar un servicio especializado como SendGrid o Mailgun