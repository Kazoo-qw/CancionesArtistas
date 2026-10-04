# CONSTITUTION.md — Reglas no negociables del proyecto

> Estas reglas tienen prioridad sobre cualquier otra instrucción de `AGENTS.md`, `MEMORY.md` o de una petición puntual.
> Si una petición las contradice, el agente **debe avisar y pedir confirmación** antes de continuar.
> Origen: apuntes de clase (Unidad I y II de Laravel). Las reglas marcadas con 🔧 son valores por defecto razonables que no vienen textualmente de clase; edítalas si tu profesor pide otra cosa.
> **Actualización del 2026-10-01 (pedida por el estudiante):** versión **Laravel 13** y anclaje de los ejemplos al dominio real del repo (**Songs / Artists / SongsArtists**). El caso de ventas se cita como "caso de clase" y vive en el Anexo de `MEMORY.md`.
> **Enmienda del mismo día:** el **art. 6.2** pasó a admitir la forma `Model::inRandomOrder()->first()->id` que enseñó el profesor para **reutilizar registros existentes** (antes exigía exclusivamente `Model::factory()`). Revísala y déjala así solo si estás de acuerdo.
> **Actualización del 2026-10-02 (pedida por el estudiante):** nuevo **art. 6.6** con el patrón de inserción masiva que enseñó el profesor (`pluck` → `for` → `DB::table()->insert()`), y el **art. 6.2** ahora cuantifica con una medición real el riesgo de la forma aleatoria.
> **Enmienda del mismo día, parte 2 (pedida por el estudiante):** el estudiante pidió usar `SongArtist::factory(200)->create();` tal como se la enseñó el profesor. Para que no reviente contra el `UNIQUE`, **art. 6.2** deja de decir qué fragmento usa este proyecto y **art. 6.6** pasa de obligar al `DB::table()->insert()` a admitir **los dos** caminos (declarando que este proyecto usa `factory()->count(N)->create()`). Revísalas y déjalas solo si estás de acuerdo.
> **Enmienda del mismo día, parte 3 (pedida por el estudiante):** el estudiante confirmó que el `UNIQUE(artist_id, song_id)` **no lo pidió el profesor**, así que se eliminó con la migración **nueva** `2026_10_02_220639_drop_unique_from_songs_artists_table`. Con eso: **6.2** declara que este proyecto usa el fragmento literal del profesor, **6.3** deja de citar un `UNIQUE` que ya no existe, **6.4** sustituye su ejemplo de unicidad (el seeder ahora **sí** repite pares) y **6.6** deja de hablar de unicidad en la factory. Aparte, comprobado contra `laravel/framework`: `#[Fillable]` **da 404 en la rama `12.x` y existe en `13.x`** → es nuevo de **Laravel 13**, por eso **2.6** y **5.7** admiten el atributo como equivalente a la propiedad `$fillable`. **Revísalas todas y déjalas solo si estás de acuerdo.**

---

## Artículo 1. Propósito

Este es un proyecto **académico de aprendizaje** con **Laravel 13** (PHP 8.3 + MySQL + Eloquent + Blade).
El objetivo no es solo que el código funcione, sino que el estudiante **entienda** lo que se construye. Un agente que entrega código que el estudiante no puede explicar ha fallado, aunque el código corra.

## Artículo 2. Seguridad y secretos

1. **Nunca** leer en voz alta, copiar, imprimir, registrar ni versionar valores reales de `.env` (contraseñas de base de datos, `APP_KEY`, `MAIL_PASSWORD`, claves AWS, etc.).
2. **Nunca** escribir credenciales reales en código, comentarios, ejemplos, `MEMORY.md` ni mensajes de commit. En ejemplos usar marcadores: `tu_correo@example.com`, `contraseña_de_aplicación`.
3. `.env` debe estar en `.gitignore`. Si no lo está, avisar antes de cualquier `git add`.
4. `APP_DEBUG=true` solo en entorno `local`. En producción debe ser `false`.
5. La contraseña de `MAIL_PASSWORD` es una **contraseña de aplicación de Google** (requiere verificación en dos pasos), nunca la contraseña personal de la cuenta.
6. Usar siempre `$fillable` en los modelos (protección contra asignación masiva) — **en Laravel 13 se puede usar el atributo equivalente `#[Fillable([...])]`**, que el framework fusiona con la propiedad (`GuardsAttributes::mergeFillable()`). El material de clase va en **Laravel 12**, donde ese atributo **no existe** (el archivo `Attributes/Fillable.php` da 404 en la rama `12.x` de `laravel/framework`), por eso sus ejemplos usan la propiedad. Está prohibido `$guarded = []` 🔧.

## Artículo 3. Operaciones destructivas

Requieren **confirmación explícita del estudiante, en ese mismo turno**, antes de ejecutarse:

- `php artisan migrate:fresh` (con o sin `--seed`), `migrate:reset`, `migrate:refresh`, `db:wipe`
- `php artisan migrate:rollback` (en cualquiera de sus variantes)
- `php artisan migrate --force`
- Borrar o reescribir migraciones **ya ejecutadas** (usar una migración nueva con `Schema::table()` en su lugar)
- `DROP`, `TRUNCATE` o `DELETE` sin `WHERE` directamente en MySQL
- `git reset --hard`, `git push --force`, borrar ramas
- Borrar archivos o carpetas fuera de lo que el agente mismo creó en la tarea actual

Los comandos destructivos de base de datos **nunca** se ejecutan contra una base de datos de producción.

## Artículo 4. Fidelidad a lo visto en clase

1. Priorizar las técnicas, comandos y convenciones de `MEMORY.md` (lo que el curso ya enseñó).
2. No introducir paquetes ni arquitecturas que no se han visto (Livewire, Filament, Inertia, Sanctum/Passport, repositorios, servicios/DDD, etc.) sin proponerlo primero y obtener un "sí".
3. Si hay dos formas válidas (por ejemplo `foreignId()->constrained()` vs `unsignedBigInteger()` + `foreign()`), usar la que el curso marca como actual y **mencionar** la otra en una línea.
4. Si el material de clase contiene un error conocido (ver sección de inconsistencias en `MEMORY.md`), **no replicarlo**: corregirlo y decir en una frase qué se corrigió y por qué.

## Artículo 5. Convenciones de base de datos y Eloquent

1. **Nunca** modificar una migración ya ejecutada para cambiar una tabla; crear una migración nueva (`make:migration add_x_to_y_table`) y usar `Schema::table()`.
2. Toda migración debe tener `up()` **y** `down()` funcionales y simétricos.
3. Respetar el **orden de dependencias** al crear tablas: primero las tablas "padre", después las que llevan llaves foráneas. **En este proyecto:** `artists` y `songs` → `songs_artists`. (Caso de clase: `clientes`, `productos`, `metodopagos` → `facturas` → `detallefacturas` y `pagos`.)
4. Dinero siempre con `decimal(precisión, escala)`; **nunca** `float`/`double` para valores monetarios.
5. Las llaves foráneas deben declararse con `foreign()`/`constrained()` y definir explícitamente su `onDelete` cuando el negocio lo requiera (`cascade` en detalles/pagos de una factura, `restrict` para catálogos como método de pago).
6. Cada tabla de negocio lleva columnas de auditoría más `timestamps`. **Corregido respecto a los apuntes (art. 4.4):** el material de clase las llama `estado` y `registradopor`, pero **este proyecto usa `status` (boolean, con default) y `registered_by` (FK `users`, nullable)**, como dicen sus migraciones. Manda la migración (art. 5.8): no se agregan ni renombran esas columnas sin una migración nueva. (En el caso de clase, los detalles de factura solo llevan `registradopor`.)
7. Modelos: nombre **singular** en PascalCase dentro de `app/Models`, con `use HasFactory`, `$table`, `$primaryKey` y la lista blanca de atributos explícita (`$fillable`, o `#[Fillable]` en Laravel 13 — ver art. 2.6), y las relaciones tipadas con el método Eloquent correcto (`hasMany`, `belongsTo`, `belongsToMany`, `hasOne`, `hasManyThrough`).
8. **Antes** de escribir en un modelo, factory o seeder el nombre de una columna, verificarlo contra la migración real. El nombre en la migración manda.
9. Una sola grafía por clase: no mezclar mayúsculas entre archivo, `namespace`, `use` y factory. **En este proyecto:** `SongArtist` → `SongArtistFactory` → tabla `songs_artists`. (Caso de clase: `Detallefactura`/`DetalleFactura`, `MetodoPago`/`Metodopago`.) La mezcla funciona en Windows y se rompe en Linux/macOS 🔧.

## Artículo 6. Factories y seeders

1. Las factories usan `$this->faker` dentro de la clase (recomendado en clase); `fake()` queda para seeders o código fuera de una clase Factory.
2. Las llaves foráneas en una factory **nunca** se resuelven con ids inventados. Hay dos formas válidas, y las dos las enseñó el profesor; hay que elegir según el caso:
   - **Reutilizar registros que ya existen en la BD** (fragmento del profesor): `'product_id' => Product::inRandomOrder()->first()->id`. **Es el que usa este proyecto**, con los nombres del dominio: `'song_id' => Song::inRandomOrder()->first()->id` y `'artist_id' => Artist::inRandomOrder()->first()->id`, dentro de `SongArtistFactory`, para que corra `SongArtist::factory(200)->create();`. ⚠️ Este fragmento **solo es compatible con tablas sin restricción de unicidad**: por eso el `UNIQUE(artist_id, song_id)` de `songs_artists` se eliminó el 2026-10-02 con la migración `2026_10_02_220639_drop_unique_from_songs_artists_table` (el estudiante confirmó que no lo pidió el profesor).
   - **Crear el registro si hace falta**: `'cliente_id' => Cliente::factory()`; aquí, `'song_id' => Song::factory()`.

   ⚠️ Elegir al azar uno a uno **no garantiza unicidad**: muestrea con repetición. **Medido en este proyecto:** 200 muestras sobre los 400 pares posibles dieron **152–162 distintos → 38–48 colisiones** en distintas corridas. Si la tabla tiene una restricción de unicidad, la inserción falla con `UniqueConstraintViolationException` — con la tabla vacía revienta **entre el registro 5 y el 49** (promedio 23 de 200). **En este proyecto esa restricción se eliminó**, así que los pares se repiten a propósito: 400 filas → 286 pares distintos (114 repetidas). Si alguna vez hace falta unicidad, hay que usar una lista de pares libres dentro de la factory, **no** repetir este fragmento tal cual.
3. Los datos generados deben **respetar las restricciones reales** de la tabla: las columnas `NOT NULL` sin valor por defecto siempre se llenan (aquí: `artists.name`, `songs.title`, `songs_artists.song_id` y `artist_id`), y las únicas también **si las hay**. **Estado actual:** `songs_artists` **ya no tiene** `UNIQUE(artist_id, song_id)` (se eliminó el 2026-10-02), así que repetir un par **no** viola ninguna restricción. Antes de asumir una restricción, mirar la migración real. El nombre de columna lo manda la migración (art. 5.8).
4. Los datos de un seeder deben ser **coherentes con el negocio**, no relleno aleatorio. Ejemplos: en el caso de clase, el total de una factura es la suma de sus subtotales y los pagos no lo superan; **en este proyecto**, que las canciones y los artistas referenciados existan de verdad (el fragmento toma ids reales, nunca inventados).
   > **Nota del 2026-10-02:** el ejemplo original decía *"en este proyecto, un artista no puede quedar asociado dos veces a la misma canción"*. Se retiró porque la forma que exigió el profesor —fragmento aleatorio sin `UNIQUE`— **sí** repite pares (114 de 400 filas). El principio de este artículo sigue en pie; si el profesor vuelve a pedir unicidad de pares, habrá que replantearlo con él.
5. Todo seeder debe poder ejecutarse más de una vez en una base recién migrada (`migrate:fresh --seed`) sin errores.
6. Para **insertar muchos registros de una vez** hay dos caminos válidos, ambos de clase. Elegir según el caso:
   - **`Model::factory()->count(N)->create();`** — es el que usa **este proyecto** desde el 2026-10-02: simple, pasa por Eloquent y rellena los `timestamps` solo. Cualquier regla de negocio **se resuelve dentro de la factory**, nunca en el seeder. (Ya no hay regla de unicidad que resolver aquí: ver art. 6.3.)
   - **`DB::table('tabla')->insert($data)`** (patrón del profesor: `pluck` de los ids → `$data` dentro de un `for` → una sola consulta) — más rápido, pero **no** rellena `created_at`/`updated_at` (ponerlos a mano si la tabla los tiene) y **no** pasa por Eloquent. Si se usa, recoger **solo los ids creados en esta pasada** (`Model::factory()->count(20)->create()->pluck('id')`), nunca `Model::pluck('id')` a secas: lo contrario mezcla los datos de corridas anteriores y las claves únicas chocan (falló aquí el 2026-10-02). El `->random()` del ejemplo original **tampoco** sirve en una tabla con `UNIQUE` (ver art. 6.2).

## Artículo 7. Requerimientos y supuestos

1. Antes de diseñar o cambiar tablas, distinguir si el requisito es **funcional**, **no funcional** o **de dominio/negocio**.
2. Cuando el requisito es vago o incompleto, el agente **no decide en silencio**: formula un **supuesto** explícito (qué se asume, por qué y qué tablas/campos implica) y lo registra en `MEMORY.md`.
3. Un supuesto no registrado no existe.

## Artículo 8. Calidad del código

1. Seguir PSR-12 y las convenciones de Laravel; indentación de 4 espacios 🔧.
2. Código y nombres técnicos tal como en clase (tablas y campos en español, como `productos`, `precio_venta`). Comentarios y mensajes al estudiante en **español**.
3. Lógica de negocio en el controlador/modelo, nunca en la vista. Las vistas Blade solo presentan datos (bucles y condicionales de presentación).
4. Validar datos de entrada antes de tocar el modelo.
5. No dejar código muerto, `dd()`, `dump()` ni `var_dump()` en lo que se entrega 🔧.
6. Tras cambios de configuración, rutas, vistas o `.env`, limpiar caché (`php artisan optimize:clear`) antes de concluir que algo "no funciona".

## Artículo 9. Cómo debe comportarse el agente

1. **Explicar el porqué** en pocas líneas: qué hace cada pieza nueva y en qué parte del flujo MVC encaja.
2. **Cambios pequeños y verificables**: una migración, un modelo o una factory por paso, no un volcado masivo.
3. Si algo es ambiguo, hacer **una** pregunta concreta; si es razonable avanzar, avanzar y declarar el supuesto.
4. **Decir la verdad sobre el estado real**: no afirmar que algo funciona si no se ejecutó. Indicar qué comando se corrió y qué resultado dio (`migrate:status`, `php artisan test`, etc.).
5. Si el agente se equivoca, lo dice, lo corrige y sigue.
6. No hacer el trabajo de evaluación por el estudiante: en **ejercicios propuestos en clase** (por ejemplo, las preguntas de la sección de migraciones) guiar con pistas y comandos para comprobar, y dar la respuesta completa solo si se pide.

## Artículo 10. Gobierno de este documento

- Esta constitución solo la modifica el estudiante.
- El agente puede **proponer** cambios, pero no editarlos por su cuenta.
- Si dos reglas chocan, gana la de número de artículo menor (Seguridad > Operaciones destructivas > Fidelidad a clase > …).
