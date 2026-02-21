# oceaNakama — Análisis Técnico de Requisitos

**Fecha:** 20 de febrero de 2026
**Autor:** Análisis de arquitectura de software
**Versión:** 1.1 — Adaptado a Laravel + Blade

---

## 1. Resumen Ejecutivo

**oceaNakama** es una plataforma web orientada a amantes del mar (buceadores, apneistas, aventureros) que centraliza tres verticales de negocio: formación (cursos certificados SSI), venta de equipamiento técnico de buceo y organización de expediciones/viajes. El objetivo principal es convertirse en el punto de confianza único que conecta al usuario con proveedores de alta calidad (Buceo Hondarribia, Born to the Ocean, Mares), eliminando la fricción de navegar entre múltiples webs. La métrica de éxito a 3 meses es alcanzar 20 reservas de cursos confirmadas con envío automático de emails de confirmación sin errores.

---

## 2. Stack Tecnológico Sugerido

### Backend + Frontend (Monolito)
| Tecnología | Justificación |
|---|---|
| **Laravel 11+** | Framework PHP maduro, con ecosistema completo para este tipo de proyecto: Eloquent ORM (relaciones complejas usuario↔reservas↔cursos), sistema de migraciones, validaciones, colas, eventos, políticas de autorización (Gates/Policies). La comunidad hispanohablante es enorme, lo que facilita encontrar ayuda y contratar talento. |
| **Blade** | Motor de plantillas nativo de Laravel. Server-side rendering por defecto (excelente para SEO sin configuración extra). Componentes Blade reutilizables, layouts con `@extends`/`@section`, y soporte para componentes anónimos que mantienen el código limpio. |
| **Tailwind CSS** | Desarrollo rápido de una UI con "marca fuerte" sin necesidad de diseñador a tiempo completo. Integración nativa con Laravel via Vite. |
| **Alpine.js** | Interactividad ligera (dropdowns, modales, carrito, filtros dinámicos) sin la complejidad de React/Vue. Pesa ~15KB y se integra perfectamente con Blade. Ideal para el nivel de interactividad que necesita este proyecto. |
| **Livewire 3** | Para componentes más complejos como filtros en tiempo real, búsqueda dinámica o actualización del carrito sin recargar página. Se puede añadir solo donde haga falta sin reescribir nada. |

### Base de Datos
| Tecnología | Justificación |
|---|---|
| **MySQL 8 / MariaDB** | Elección natural con Laravel. Eloquent lo soporta de forma nativa sin configuración extra. MySQL es más económico de alojar que PostgreSQL en la mayoría de proveedores. Para 200-5.000 usuarios/mes es más que suficiente. Soporta JSON para campos flexibles (ej: "qué incluye" en viajes). |
| **Alternativa: PostgreSQL** | Si se prefiere. Laravel lo soporta igual de bien. Recomendable si se necesitan consultas geoespaciales a futuro (destinos de viajes en mapa). |

### Autenticación
| Tecnología | Justificación |
|---|---|
| **Laravel Breeze** | Scaffolding de auth completo (registro, login, reset password, verificación email) con vistas Blade + Tailwind listas para usar. Incluye middleware de verificación de email. Ligero y sin opiniones fuertes, ideal para customizar. |
| **Spatie Laravel-Permission** | Gestión de roles y permisos (cliente/admin/instructor). Estándar de facto en el ecosistema Laravel. Permite asignar permisos granulares sin reinventar la rueda. |

### Pagos
| Tecnología | Justificación |
|---|---|
| **Laravel Cashier (Stripe)** | Integración oficial Laravel + Stripe. Simplifica pagos únicos, gestión de clientes en Stripe, generación de recibos y webhooks. Cumple con PSD2/SCA (requisito UE). |
| **Stripe Checkout** | Para el flujo de pago: redirige al usuario a una página de pago alojada por Stripe (máxima seguridad, mínimo esfuerzo). Soporta depósitos parciales con metadata personalizada. |

### Infraestructura
| Tecnología | Justificación |
|---|---|
| **Laravel Forge + DigitalOcean** | Forge automatiza el deploy, SSL, colas, cron jobs y backups en un VPS de DigitalOcean (~$12/mes para empezar). Es el estándar para deploy de Laravel en producción. Alternativa: Railway o Render si se prefiere PaaS sin gestionar servidor. |
| **Alternativa: Laravel Cloud** | La nueva plataforma serverless de Laravel (si ya está disponible). Zero-config, auto-scaling. Ideal si se quiere cero gestión de infraestructura. |

### Emails transaccionales
| Tecnología | Justificación |
|---|---|
| **Laravel Mail + Mailables** | Sistema nativo de Laravel para emails con plantillas Blade. Clases Mailable organizadas, previsualizables en navegador, con soporte para colas (envío asíncrono). |
| **Driver: Resend o Brevo (SMTP)** | Resend tiene SDK para Laravel. Brevo (ex-Sendinblue) si se quiere CRM integrado. Mailgun como alternativa probada. Cualquiera se configura cambiando una línea en `.env`. |

### Almacenamiento de archivos
| Tecnología | Justificación |
|---|---|
| **Laravel Storage + S3 (o DigitalOcean Spaces)** | Filesystem abstraction nativa. En desarrollo: disco local. En producción: S3 o DO Spaces (~$5/mes) para imágenes de productos, cursos y viajes. Cloudinary como alternativa si se quiere optimización automática de imágenes. |

### Colas y Jobs en segundo plano
| Tecnología | Justificación |
|---|---|
| **Laravel Queues + Redis** | Imprescindible para: envío de emails (no bloquear el request), procesamiento de webhooks de Stripe, actualización de plazas. Redis también sirve como caché y session driver. |

### Otros
| Herramienta | Uso |
|---|---|
| **Vite** | Bundler nativo de Laravel para assets (CSS, JS). Viene integrado por defecto. |
| **GA4** | Analytics (imprescindible). |
| **Laravel Lang** | Paquete de traducciones de la interfaz a múltiples idiomas. |
| **Spatie Laravel-Translatable** | Para hacer traducibles los modelos (cursos, viajes, productos) a ES/FR/EN sin duplicar tablas. |
| **Laravel Debugbar** | Debugging en desarrollo (queries, rendimiento, vistas). |
| **DomPDF / Laravel Excel** | Exportación de datos en PDF y Excel. |

---

## 3. Funcionalidades Clave por Módulo

### 3.1 Autenticación y Usuarios
- Registro con email y contraseña
- Login / Logout
- Recuperación de contraseña (email)
- Perfil de usuario: nombre, apellidos, email, teléfono, nivel de certificación, nº inmersiones (opcional), seguro de buceo
- RGPD: consentimiento, borrado de cuenta, exportación de datos

### 3.2 Catálogo Público (sin login)
- **Home**: resumen visual con CTA a cursos, tienda y viajes
- **Cursos**: listado con filtros (nivel, certificación, precio), detalle con plazas disponibles
- **Tienda**: catálogo de equipo con filtros (marca, talla, color, precio), detalle con stock
- **Viajes**: expediciones con filtros (destino, fecha, nivel requerido), detalle con "qué incluye"
- Búsqueda global con filtros
- Paginación en listados

### 3.3 Reservas y Compras
- **Reserva de cursos**: selección → verificación de plazas → pago (Stripe) → confirmación por email
- **Reserva de viajes**: selección → verificación plazas → pago/pre-reserva → confirmación
- **Compra de equipo**: carrito de compra → checkout → pago → actualización de stock → email con factura
- Control de concurrencia (evitar doble reserva de última plaza)
- Política de cancelación: pérdida de depósito si <48h antes

### 3.4 Panel de Usuario (Dashboard)
- Historial de pedidos de equipo (con estados)
- Mis cursos reservados (próximos / completados)
- Mis viajes (próximos / completados)
- Descargar facturas

### 3.5 Panel de Administración (Backoffice)
- CRUD completo de cursos, viajes y productos
- Gestión de estados de pedidos (Pendiente → Pagado → Enviado → Entregado)
- Gestión de plazas (abrir/cerrar)
- Moderación de reseñas (aprobar/rechazar antes de publicar)
- Métricas: ventas del mes, viajes más solicitados, productos con poco interés
- Auditoría: historial de cambios en viajes y pagos

### 3.6 Contenido y SEO
- Blog/Noticias (editor para admin)
- Páginas estáticas: Contacto, Sobre mí, Términos, Privacidad, Cookies

### 3.7 Comunicaciones
- Emails transaccionales: confirmación de reserva, confirmación de compra, bienvenida, reset password, factura
- Botón de WhatsApp (enlace directo `wa.me/`)
- Formulario de contacto

### 3.8 Multi-idioma
- Español (principal), Francés, Inglés
- Contenido traducido para: interfaz, cursos, viajes, productos, blog

### 3.9 Reseñas
- Usuarios pueden escribir reseñas de cursos y equipo
- Moderación previa por admin antes de publicación

### 3.10 Exportación de Datos
- Exportar pedidos/reservas en PDF o Excel (admin)
- Exportar datos personales del usuario (RGPD)

---

## 4. Modelo de Datos

### Entidades y Campos Principales

```
┌──────────────────┐       ┌──────────────────────┐
│     USUARIO      │       │        CURSO          │
├──────────────────┤       ├──────────────────────┤
│ id (PK)          │       │ id (PK)               │
│ nombre           │       │ nombre                │
│ apellidos        │       │ nivel (enum)           │
│ email (unique)   │       │ duracion               │
│ telefono         │       │ precio                 │
│ direccion        │       │ certificacion (SSI)    │
│ certificacion    │       │ plazas_max             │
│ num_inmersiones  │       │ plazas_disponibles     │
│ seguro_buceo     │       │ estado (enum)          │
│ rol (enum)       │       │ descripcion            │
│ idioma_pref      │       │ imagen_url             │
│ created_at       │       │ fechas                 │
│ updated_at       │       └──────────────────────┘
└──────────────────┘
         │                  ┌──────────────────────┐
         │                  │       VIAJE           │
         │                  ├──────────────────────┤
         ├─── 1:N ────────▶│ id (PK)               │
         │   (reservas)     │ destino               │
         │                  │ fecha_ida              │
         │                  │ fecha_vuelta           │
         │                  │ incluye (JSON)         │
         │                  │ nivel_requerido        │
         │                  │ precio                 │
         │                  │ plazas_max             │
         │                  │ plazas_disponibles     │
         │                  │ estado (enum)          │
         │                  │ imagen_url             │
         │                  └──────────────────────┘
         │
         │                  ┌──────────────────────┐
         ├─── 1:N ────────▶│      RESERVA          │
         │                  ├──────────────────────┤
         │                  │ id (PK)               │
         │                  │ usuario_id (FK)        │
         │                  │ tipo (curso/viaje)     │
         │                  │ curso_id (FK, nullable)│
         │                  │ viaje_id (FK, nullable)│
         │                  │ estado (enum)          │
         │                  │ metodo_pago            │
         │                  │ stripe_payment_id      │
         │                  │ created_at             │
         │                  └──────────────────────┘
         │
         │                  ┌──────────────────────┐
         ├─── 1:N ────────▶│       PEDIDO          │
         │                  ├──────────────────────┤
         │                  │ id (PK)               │
         │                  │ usuario_id (FK)        │
         │                  │ estado (enum)          │
         │                  │ total                  │
         │                  │ direccion_envio        │
         │                  │ stripe_payment_id      │
         │                  │ created_at             │
         │                  └──────────────────────┘
         │                           │
         │                           │ 1:N
         │                           ▼
         │                  ┌──────────────────────┐
         │                  │   LINEA_PEDIDO        │
         │                  ├──────────────────────┤
         │                  │ id (PK)               │
         │                  │ pedido_id (FK)         │
         │                  │ producto_id (FK)       │
         │                  │ cantidad               │
         │                  │ precio_unitario        │
         │                  └──────────────────────┘
         │
         │                  ┌──────────────────────┐
         ├─── 1:N ────────▶│       RESEÑA          │
                            ├──────────────────────┤
                            │ id (PK)               │
                            │ usuario_id (FK)        │
                            │ tipo (curso/producto)  │
                            │ referencia_id          │
                            │ texto                  │
                            │ puntuacion (1-5)       │
                            │ estado (pendiente/     │
                            │   aprobada/rechazada)  │
                            │ created_at             │
                            └──────────────────────┘

┌──────────────────────┐    ┌──────────────────────┐
│      PRODUCTO        │    │   AUDITORIA_LOG      │
├──────────────────────┤    ├──────────────────────┤
│ id (PK)              │    │ id (PK)              │
│ nombre               │    │ entidad              │
│ marca                │    │ entidad_id            │
│ talla                │    │ accion               │
│ color                │    │ campo_modificado      │
│ stock                │    │ valor_anterior        │
│ precio               │    │ valor_nuevo           │
│ descripcion_tecnica  │    │ usuario_id (FK)       │
│ categoria            │    │ created_at            │
│ imagen_url           │    └──────────────────────┘
│ estado               │
└──────────────────────┘
```

### Relaciones Clave
- **Usuario 1:N Reservas** (un usuario puede tener muchas reservas de cursos y viajes)
- **Usuario 1:N Pedidos** (un usuario puede tener muchos pedidos de equipo)
- **Pedido 1:N Líneas de Pedido** (un pedido puede contener múltiples productos)
- **Producto 1:N Líneas de Pedido**
- **Curso 1:N Reservas** / **Viaje 1:N Reservas** (relación polimórfica)
- **Usuario 1:N Reseñas**

### Estados (Enums)

| Entidad | Estados |
|---|---|
| Curso/Viaje | `proximo`, `en_curso`, `completado`, `cancelado` |
| Pedido equipo | `pendiente_pago`, `pagado`, `enviado`, `entregado` |
| Reserva viaje | `pre_reserva`, `confirmada`, `lista_espera`, `cancelada` |
| Reserva curso | `pendiente_pago`, `confirmada`, `cancelada` |
| Reseña | `pendiente`, `aprobada`, `rechazada` |

---

## 5. Requisitos No Funcionales

### Rendimiento
- Carga inicial < 3s (First Contentful Paint)
- Imágenes optimizadas (WebP, lazy loading con `loading="lazy"` en Blade)
- Caché de vistas, rutas y config en producción (`php artisan optimize`)
- Caché de queries con Redis para listados de catálogo
- Tráfico esperado: 200-500 usuarios/mes → 5.000/año. Un VPS de DigitalOcean con 2GB RAM maneja esto sin problemas

### Escalabilidad
- Picos en Black Friday (equipo) y pre-verano/Semana Santa (cursos y viajes)
- Redis para caché de queries pesadas y sesiones
- `php artisan route:cache`, `config:cache`, `view:cache` en producción
- CDN para assets estáticos (Cloudflare free tier o DigitalOcean CDN)
- Laravel Octane (opcional post-MVP) para rendimiento extremo si se necesita

### Seguridad
- HTTPS obligatorio
- Autenticación con sesiones (Laravel Breeze, cookie-based — más seguro que JWT para web server-rendered)
- Protección CSRF nativa (`@csrf` en todos los formularios Blade)
- Rate limiting nativo de Laravel (`RateLimiter` en `RouteServiceProvider`)
- Eloquent previene SQL injection por defecto (bindings parametrizados)
- Blade escapa HTML por defecto con `{{ }}` (prevención XSS)
- Middleware de autorización con Gates/Policies (cada usuario solo ve sus datos)
- 2FA: **no prioritario en MVP**, pero preparar con `laravel/fortify` cuando se necesite

### Legal / RGPD
- Banner de cookies con consentimiento granular
- Checkbox de aceptación de términos en registro
- Funcionalidad de borrado de cuenta
- Exportación de datos personales en formato descargable
- Página de Política de Privacidad
- Página de Términos y Condiciones (incluir política de cancelación)
- Textos legales en los 3 idiomas

### Accesibilidad
- WCAG 2.1 nivel AA mínimo
- Contrastes adecuados, tamaño de fuente legible
- Navegación por teclado
- Alt text en imágenes
- Formularios con labels correctos

### Disponibilidad
- Uptime objetivo: 99.5% (media-alta según requisito)
- Backups diarios automáticos de DB (Laravel Forge los configura automáticamente)
- Monitorización de errores con Laravel Telescope (desarrollo) + Sentry o Flare (producción)

---

## 6. Integraciones Externas

| Servicio | Uso | Prioridad |
|---|---|---|
| **Stripe (via Laravel Cashier)** | Pagos únicos, depósitos, facturación, webhooks | MVP |
| **Resend / Brevo / Mailgun** | Driver SMTP para Laravel Mail (confirmación, factura, bienvenida, reset) | MVP |
| **WhatsApp Business** | Botón de contacto directo (`wa.me/numero`) | MVP |
| **GA4** | Analytics de tráfico y conversiones | MVP |
| **DigitalOcean Spaces / S3** | Almacenamiento de imágenes y vídeos (via Laravel Storage) | MVP |
| **Redis** | Colas, caché y sesiones | MVP |
| **DomPDF** | Generación de facturas PDF | Post-MVP |
| **Laravel Excel (Maatwebsite)** | Exportación de datos a Excel | Post-MVP |
| **Spatie Laravel-Translatable** | Contenido multi-idioma en modelos (ES/FR/EN) | Post-MVP |
| **Google Calendar** | Sincronización de fechas de cursos/viajes (no mencionado, pero recomendado) | Post-MVP |
| **Matomo** | Alternativa a GA4 si se quiere privacidad total (RGPD) | Opcional |

---

## 7. Ambigüedades y Preguntas a Resolver

### Críticas (bloquean desarrollo)

1. **Pagos: ¿depósito o pago completo?** Se mencionan "depósitos" en la política de cancelación, pero en pagos dice "pago único". ¿Los cursos y viajes se pagan al 100% por adelantado, o se cobra un depósito primero y el resto después? Esto cambia completamente la lógica de pagos.

2. **Envíos de equipo: ¿quién gestiona la logística?** No se menciona si el equipo se envía desde tu almacén o desde el proveedor. ¿Hay costes de envío? ¿A qué países? ¿Quién gestiona devoluciones?

3. **Precios de productos: ¿los fijas tú o te los da el proveedor?** ¿Tienes stock propio o es dropshipping? Esto afecta al modelo de inventario.

4. **Rol "Instructor"**: Aparece en la sección de permisos ("puede ver la lista de alumnos de su curso") pero no está definido como rol en la sección 2. ¿Existe o no en el MVP?

5. **Multi-idioma: ¿solo interfaz o también contenido?** Traducir la UI es sencillo. Traducir cada curso, viaje y producto a 3 idiomas es un trabajo enorme de contenido. ¿Quién traduce? ¿Se usa traducción automática?

6. **Textos/contenido**: Se confirma que no hay textos listos. ¿Quién los redacta? Esto puede ser el mayor cuello de botella del proyecto.

### Importantes (no bloquean, pero afectan alcance)

7. **Identidad visual**: Está "en ello". Sin logo, colores ni tipografías, no se puede diseñar. ¿Hay deadline para esto?

8. **Blog**: ¿El admin escribe posts o se integra un CMS? ¿Necesita editor WYSIWYG?

9. **Cancelación por clima**: Se menciona "cambio de fecha", pero ¿quién notifica al usuario? ¿Es automático o manual? ¿Se ofrece reembolso alternativo?

10. **Exportar PDF/Excel**: ¿Qué datos exactamente? ¿Solo el admin exporta o también el usuario?

11. **Certificaciones de usuario**: Se menciona que "si un usuario sube su título, guardar cuándo se validó". ¿Los usuarios pueden subir documentos? En la sección de subida de archivos dice "No". Contradicción.

12. **Lista de espera en viajes**: ¿Cómo se gestiona? ¿Se notifica automáticamente cuando hay plaza? ¿Se cobra al entrar desde la lista de espera?

13. **PWA**: El cliente duda de su necesidad. Recomiendo implementarlo como mejora post-MVP. En Laravel se puede añadir un manifest.json y service worker manualmente o con `silviolleite/laravelpwa`, pero no es prioritario.

---

## 8. Riesgos Técnicos

| Riesgo | Impacto | Mitigación |
|---|---|---|
| **Contenido no listo** (textos, fotos, traducciones) | 🔴 ALTO — puede retrasar el lanzamiento semanas | Definir un deadline de entrega de contenido. Lanzar MVP solo en español. |
| **Identidad visual indefinida** | 🔴 ALTO — no se puede diseñar sin dirección visual | Contratar diseñador o definir moodboard antes de empezar frontend. |
| **Concurrencia en reservas** (última plaza) | 🟡 MEDIO — puede generar overbooking | Usar `lockForUpdate()` de Eloquent (pessimistic locking) dentro de `DB::transaction()`. Laravel lo hace trivial. |
| **Stripe + depósitos parciales** | 🟡 MEDIO — lógica de pagos compleja | Definir flujo exacto de pagos antes de implementar. Stripe soporta pagos parciales, pero hay que diseñar bien los estados. |
| **Traducciones a 3 idiomas** | 🟡 MEDIO — multiplicador de esfuerzo de contenido x3 | Lanzar solo en español, añadir idiomas en fase 2. |
| **SEO del blog** | 🟢 BAJO — requiere contenido constante | Blade ya renderiza server-side (SEO nativo). Preparar sitemap con `spatie/laravel-sitemap`, meta tags con `artesaos/seotools`. |
| **Picos de tráfico** | 🟢 BAJO — Laravel con Redis y caché maneja bien | Usar `Route::cache`, `Config::cache`, query caching con Redis. Si el VPS se queda corto, escalar verticalmente en DigitalOcean es un click. |

---

## 9. Estimación de Esfuerzo

| Módulo | Esfuerzo | Detalle |
|---|---|---|
| Setup proyecto + DB + Auth | **S** | `laravel new` + Breeze + migraciones + Spatie Permission + Redis |
| Home + Layout + Navegación | **S** | Layout Blade con `@extends`, componentes Blade, responsive con Tailwind |
| Catálogo de cursos (listado + detalle + filtros) | **M** | Controladores + vistas Blade + filtros con query scopes en Eloquent |
| Catálogo de viajes (listado + detalle + filtros) | **M** | Similar a cursos + lógica de plazas con `lockForUpdate()` |
| Tienda de equipo (catálogo + carrito + checkout) | **L** | Carrito (sesión o DB), gestión de stock, variantes (talla/color) |
| Sistema de pagos (Stripe) | **L** | Laravel Cashier, Stripe Checkout, webhooks, estados, facturas |
| Emails transaccionales | **M** | Clases Mailable con plantillas Blade, colas con Redis |
| Panel de usuario (dashboard) | **M** | Controladores + vistas Blade con relaciones Eloquent |
| Panel de administración (backoffice) | **L** | CRUD con Filament o manual. Métricas, moderación, auditoría con `spatie/laravel-activitylog` |
| Reseñas + moderación | **S** | Modelo + estados + vista admin de aprobación |
| Multi-idioma (3 idiomas) | **L** | `spatie/laravel-translatable` + archivos lang + traducción de contenido |
| Blog | **M** | Modelo Post + editor (TinyMCE/Trix) + vistas Blade + SEO |
| Páginas legales (RGPD, cookies, términos) | **S** | Vistas Blade estáticas + `spatie/laravel-cookie-consent` |
| Exportación PDF/Excel | **S** | `barryvdh/laravel-dompdf` + `maatwebsite/excel` |
| PWA | **S** | `silviolleite/laravelpwa` o configuración manual de manifest + service worker |
| Testing + QA | **M** | Tests con PHPUnit/Pest en flujos críticos (pago, reserva) |

**Leyenda:** S = 1-3 días, M = 3-7 días, L = 1-2 semanas, XL = 2-4 semanas

---

## 10. Plan de Fases

### 🏗️ FASE 0 — Prerequisitos (Semana 0-1)
**Objetivo:** Tener todo lo necesario antes de escribir código.

- Resolver ambigüedades críticas (sección 7, puntos 1-6)
- Definir identidad visual (al menos colores primarios, tipografía y logo provisional)
- Recopilar contenido mínimo: 3 cursos, 3 viajes, 10 productos con fotos y textos
- Definir flujo exacto de pagos (depósito vs. completo)
- Contratar/definir redactor de textos legales

### 🚀 FASE 1 — MVP Core (Semanas 2-6)
**Objetivo:** Primera reserva de curso a través de la web.

**Sprint 1 (Sem 2-3):**
- Setup: `laravel new oceanakama` + Breeze (auth con Blade/Tailwind) + migraciones
- Spatie Permission (roles: cliente, admin)
- Home (con contenido placeholder)
- Layout Blade responsive + navegación + componentes base
- Catálogo de cursos (Modelo, Controlador, vistas Blade, filtros con query scopes)
- Panel admin: CRUD de cursos (Filament o manual)

**Sprint 2 (Sem 4-5):**
- Integración Stripe (Laravel Cashier + Stripe Checkout para pago de cursos)
- Webhooks de Stripe (evento `checkout.session.completed` → confirmar reserva)
- Emails de confirmación (Mailable + cola Redis)
- Panel de usuario básico (mis reservas, vistas Blade)
- Control de plazas con `DB::transaction()` + `lockForUpdate()`
- Botón WhatsApp
- Formulario de contacto

**Sprint 3 (Sem 6):**
- Catálogo de viajes (Modelo, Controlador, vistas Blade)
- Reserva de viajes con pago
- QA de flujos críticos (Pest tests)
- Deploy a producción (Forge + DigitalOcean)

**Entregable MVP:** Web funcional donde un usuario puede registrarse, ver cursos y viajes, reservar y pagar, y recibir confirmación por email.

### 📦 FASE 2 — Tienda + Admin (Semanas 7-10)

- Tienda de equipo completa (catálogo + carrito + checkout)
- Gestión de pedidos (estados, envío)
- Panel admin ampliado (métricas, gestión de pedidos)
- Exportación PDF/Excel
- Política de cancelación automatizada (48h)
- Reseñas + moderación

### 🌍 FASE 3 — Contenido + Idiomas (Semanas 11-14)

- Blog con editor para admin
- Multi-idioma (FR + EN)
- Traducción de contenido
- Páginas legales completas (términos, privacidad, cookies)
- RGPD completo (borrado cuenta, exportación datos)
- Auditoría y logs

### ✨ FASE 4 — Mejoras (Semanas 15+)

- PWA (instalable)
- FAQ
- Galería de fotos
- Opiniones públicas
- Portal de proveedor (vista de alumnos enviados)
- Optimización de rendimiento y SEO avanzado
- 2FA opcional

---

## Notas Finales del Analista

**Lo más crítico ahora mismo no es el código, es el contenido.** Sin identidad visual, textos, fotos de calidad y definición clara del flujo de pagos, cualquier desarrollo va a requerir retrabajo. Recomiendo invertir la primera semana exclusivamente en la Fase 0.

**Laravel + Blade es una elección excelente para este proyecto.** El ecosistema Laravel cubre el 90% de las necesidades out-of-the-box: auth (Breeze), roles (Spatie Permission), pagos (Cashier), emails (Mailables + colas), traducciones (Translatable), exportaciones (DomPDF + Excel), auditoría (Activity Log). No hay que inventar nada. Además, Blade renderiza server-side por defecto, lo que da SEO gratis sin la complejidad de un framework SPA. Alpine.js cubre toda la interactividad que necesita la web sin añadir un bundler pesado.

**El MVP está bien acotado.** La acción principal (reserva de formación) es clara y el flujo de 5 pasos del usuario es lógico. El riesgo real está en el scope creep: la tienda de equipo con carrito, variantes de talla/color y logística de envíos es un proyecto en sí mismo y debería ir en Fase 2.

**Sobre el panel admin:** Valorar usar **Filament** (panel de administración para Laravel). Genera CRUDs completos con relaciones, filtros, métricas y gráficos en horas en lugar de días. Es gratuito, open-source, y ahorra semanas de desarrollo en el backoffice. Si se prefiere control total, se puede hacer manual con Blade, pero Filament es difícil de superar en productividad.

**Sobre la PWA:** el cliente tiene razón en dudar. Para 200-500 usuarios iniciales, una web responsive bien hecha es suficiente. La PWA es un "nice to have" para fidelización posterior.

**Sobre multi-idioma:** lanzar en 3 idiomas desde el día 1 triplica el trabajo de contenido. Recomiendo encarecidamente lanzar solo en español y añadir idiomas cuando haya contenido traducido de calidad. Con `spatie/laravel-translatable`, añadir idiomas después es trivial a nivel técnico; el cuello de botella siempre será el contenido.

**Coste estimado de infraestructura (inicio):** DigitalOcean Droplet ($12/mes) + Laravel Forge ($12/mes) + DO Spaces ($5/mes) + dominio (~$12/año) + driver de email (Resend free tier o Brevo free). Total: ~$30/mes para empezar. Escala suavemente.
