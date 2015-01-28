 
# Imagen ULL

Tema hijo de [Shoestrap 3] adaptado a la imagen corporativa de la Universidad de La Laguna.


## Descripción

[Shoestrap 3] es un tema de Wordpress basado en Bootstrap que realmente está a caballo entre un tema de Wordpress y un framework de Bootstrap. Esto es así porque al tiempo que ofrece una amplia variedad de opciones para personalizar el tema desde la interfaz administrativa, también ofrece infinidad de *hooks* con los que personalizar con un tema hijo cualquier aspecto del tema, desde el valor de las opciones por defecto a las clases CSS utilizadas y el marcado HTML.

Imagen ULL es un tema hijo de [Shoestrap 3] que personaliza lo necesario para ajustarse a la [Imagen corporativa de aplicaciones telemáticas ULL](http://static.ull.es/v3/docs/). En la actualidad no hay garantías de que este tema adapte todos los elementos posibles, sino sólo aquellos utilizados en la web de la [Oficina de Software Libre](http://osl.ull.es) (OSL) ya que son los únicos que se han probado. Sin embargo, para facilitar su reutilización en otros sitios web de la ULL, este tema no incorpora ninguna configuración que sea exclusiva de la web de la OSL.

## Dependencias y plugins adicionales

A parte de la instalación de este tema y de su tema padre, se recomienda la instalación de una serie de plugins adicionales de los que depende parte de la funcionalidad ofrecida:

 * [Shoestrap 3], como tema padre. Imagen ULL ha sido probado con éxito con versión 3.3.0 de [Shoestrap 3].
 * Wordpress SEO by Yoast, para las migas de pan
 * [Shoestrap Extra Pack], para poder ocultar el título, el autor, la categoría y las etiqueta de páginas y artículos. La última versión probada con éxito fue la del commit 5b9765399802a0c49164b7f0bd5bbb7d48cace80.
 * Widget CSS Classes, para asignar iconos y propiedades a widgets y menús.
 * Jetpack por WordPress.com, para poder incorporar comentarios con autenticación mediante redes sociales.
 * Bootstrap 3 Shortcodes, para poder incorporar elementos de Bootstrap desde el editor en artículos y páginas.
 * Font Awesome Shortcodes, para poder utilizar fácilmente iconos Font Awesome en artículos y páginas.


### Migas de pan

Para utilizar las migas de pan con este tema es necesario tener instalado el plugin Wordpress SEO by Yoast, activarlas y configurar como separador el caracter <code>'|'</code>. 

### Clases CSS en widgets y menús

La [Imagen corporativa de aplicaciones telemáticas ULL] contempla la posibilidad de incorporar iconos en los menús, así como distintos colores e iconos en las cabeceras de los paneles de las barras laterales. Al trasladar estos elementos a Wordpress obviamente los menús siguen siendo menús, pero los paneles son widgets. Y la forma escogida de ajustar sus características es asignándoles clases CSS.

Por tanto, se recomienda instalar el plugin Widget CSS Classes con el objeto de poder asignar alguna de las siguientes clases CSS, según el efecto que se persiga:

 * **fa fa-icono**, asigna el icono Font Awesome <code>fa-icono</code> a la cabecera del widget o al elemento de menú donde se asigna.
 * **color-7A3B7A o color-336699**, asigna los colores indicados al fondo de la cabecera de un widget.
 * **dropdown-text**, crea un elemento de menú no enlazado cuyo contenido en HTML viene del campo descripción.
 * **dropdown-social**, crea un elemento de menú con una lista de iconos con enlaces a las redes sociales.

Además los menús con etiqueta de navegación **divider** se convierten en separadores.

### Comentarios con Jetpack

Si se instala el plugin Jetpack y se activa el módulo *comments*, el tema hace posible el cambio del formulario de comentarios tal y como lo trae [Shoestrap 3] por el de Jetpack.

## Iconos

Bootstrap viene acompañado de la familia de iconos Glyphicon, mientras que el tema [Shoestrap 3] utiliza Elusive Icons. Para respetar la [Imagen corporativa de aplicaciones telemáticas ULL], este tema mapea todos los iconos usados (pero no todos los de dichas familias) a sus equivalentes de Font Awesome. Estos mapeos se definen en los archivos <code>assets/less/elusive.less</code> y <code>assets/less/glyphicon.less</code>, para Elusive Icons y Glyphicon respectivamente. Por tanto, si se quieren mapear otros iconos, es en esos archivos donde se deben incorporar dichos mapeos.

## Contribuidores

Jesús Torres <[jmtorres@ull.es](jmtorres@ull.es)>

[Shoestrap 3]: http://press.codes/downloads/shoestrap-3/ "Shoestrap 3"
[Shoestrap Extra Pack]: http://press.codes/downloads/shoestrap-extras-pack/ "Shoestrap Extra Pack"
[Imagen corporativa de aplicaciones telemáticas ULL]: http://static.ull.es/v3/docs/ "Imagen corporativa de aplicaciones telemáticas ULL versión 3.0"
