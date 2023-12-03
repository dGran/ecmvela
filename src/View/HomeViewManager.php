<?php

declare(strict_types=1);

namespace App\View;

use App\Client\Instagram\Media\Exception\InvalidCredentialsException;
use App\Model\View\HomeView;
use App\Services\InstagramService;
use GuzzleHttp\Exception\GuzzleException;

class HomeViewManager
{
    private const DUMMY_REVIEWS = [
        0 => [
            'userName' => 'Drlaos',
            'userImg' => '',
            'post' => 'Excelente trato a mis niños',
            'review' => 5,
        ],
        1 => [
            'userName' => 'Jose Maria Well',
            'userImg' => '',
            'post' => 'Espectacular trato, tanto a los animales como a sus dueños aconsejándoles en cada momento. Un lugar recomendable 100%. Es la única peluquera que ha conseguido bañar y adecentar a Luna con esto se dice todo sobre su paciencia y profesionalidad',
            'review' => 5,
        ],
        2 => [
            'userName' => 'Amparo Carrión Mestre',
            'userImg' => '',
            'post' => 'Marta es una profesional y, además, muy cariñosa con los perros.',
            'review' => 5,
        ],
        3 => [
            'userName' => 'Estrella Aguayo',
            'userImg' => '',
            'post' => 'Maravillosa, trata a nuestras mascotas con mucho cariño, muy profesional. Trabajo bien hecho mascotas felices!!! 🐶',
            'review' => 5,
        ],
        4 => [
            'userName' => 'Maje Epila',
            'userImg' => '',
            'post' => 'Tanto su trabajo como su atención es espectacular. Muy recomendable',
            'review' => 5,
        ],
        5 => [
            'userName' => 'Antonio Y Bea ...',
            'userImg' => '',
            'post' => 'Marta ha tratado súper bien a nuestro peludo, ha salido encantado y lo ha dejado muy muy guapo, ella es un encanto, tanto con nosotros como con nuestro peludo, es muy profesional, volveremos',
            'review' => 5,
        ],
        6 => [
            'userName' => 'Alexandra Vega',
            'userImg' => '',
            'post' => 'Mil Gracias Martha por tratar tan bonito a mi Westy 😘 ha quedado muy linda y se sintió consentida en su sesión de belleza. 🤗',
            'review' => 5,
        ],
        7 => [
            'userName' => 'Ainara Pérez',
            'userImg' => '',
            'post' => 'Marta es una excelente profesional. Es la segunda vez qué llevo a mis perrinchis, Thor y Locki. Thor es muy miedoso aún qué Locki es más cariñoso. Marta les da atención, cariño y confianza. Thor es un mezcla de yorshire y Locki es un bulldog francés. Es la primera vez qué veo en una estilista canina qué mis perritos se van felices y entran sin miedo. Ella se arrodilla para jugar con ellos, les da confianza y muchos besitos y los míos se los devuelven encantados. Locki es muy nervioso y lo trata con mucho respeto, e incluso el le ha dado besitos y en razas delicadas es muy importante que se sientan así. Para finalizar se van con un premio y ellos más que felices! Es un placer encontrar sitios así ya que ese ratito queremos que estén en buenas manos! ¡Es un acierto 100% y por supuesto seguiremos volviendo!',
            'review' => 5,
        ],
        8 => [
            'userName' => 'María Luisa Orozco Gómez',
            'userImg' => '',
            'post' => 'Conocí esta peluquería por recomendación y yo también recomiendo a Marta al 100% . Es una gran profesional y amante de los animales. Le gusta su trabajo y eso, se nota. Mi perrita Wifi (perro de aguas) está guapísima, limpia y va contenta.',
            'review' => 5,
        ],
        9 => [
            'userName' => 'pilar fabra esteve',
            'userImg' => '',
            'post' => 'Amabilidad y supercariñosa con los peques. Ambiente supertranquilo y relajado. La dejó guapisima. El corte como yo le pedí, y parecia un algodoncito. Muchas gracias!!!!',
            'review' => 5,
        ],
        10 => [
            'userName' => 'Jesús M.A',
            'userImg' => '',
            'post' => 'Su primera vez. Todo genial.',
            'review' => 5,
        ],
        11 => [
            'userName' => 'Luis Carlos Serrano Cortes',
            'userImg' => '',
            'post' => 'Genial. El trato y la cercanía con melenas, como nos oriento y nos dio super consejos. Además de lo limpio y bonito que lo dejo. Muy contentos y volveremos',
            'review' => 5,
        ],
        12 => [
            'userName' => 'Gema Fernández Llobat',
            'userImg' => '',
            'post' => 'Excelente trato, mi pastor alemán quedó genial, volveré.',
            'review' => 5,
        ],
        13 => [
            'userName' => 'VnV',
            'userImg' => '',
            'post' => 'Siempre me quedo súper tranquila cuando dejo a mis peluditas en la pelu porque sé que están en las mejores manos. Las trata con muchísimo cariño, respeta sus tiempos sin prisas y sin agobios porque son muy miedosas y por supuesto salen preciosas, con el pelo súper suave y brillante. La recomiendo al 200%',
            'review' => 5,
        ],
        14 => [
            'userName' => 'Celeste Heredia Sanchez',
            'userImg' => '',
            'post' => 'Excelente resultado, el stripping de cala fenomenal! Sin duda, hagamos lo que le hagamos a cala, llamaremos a Marta!',
            'review' => 5,
        ],
        15 => [
            'userName' => 'Sonia Bayo',
            'userImg' => '',
            'post' => 'Llevamos a Lluna y a Chiqui y Marta las dejo listas para la alfombra roja. Además de tratarlas con todo el amor del mundo. Marta es una excelente persona y profesional ❤️',
            'review' => 5,
        ],
        16 => [
            'userName' => 'Julio César Bermúdez',
            'userImg' => '',
            'post' => 'Muy profesional y mi mascota súper contenta.',
            'review' => 5,
        ],
        17 => [
            'userName' => 'it\'s natalia',
            'userImg' => '',
            'post' => 'Muy contenta con Marta, gran profesional, muy cariñosa con los peluditos....todo un acierto que mi muñeca esté en tus manos. Mil gracias!!😘❤',
            'review' => 5,
        ],
        18 => [
            'userName' => 'Robert Bayarri',
            'userImg' => '',
            'post' => 'Trato excelente con los humanos y con los animales. Muy contento con el.trabajo realizado y Blacky más contento. Muchas gracias. Muy recomendable',
            'review' => 5,
        ],
        19 => [
            'userName' => 'EVA MARIA RIOS SIMO',
            'userImg' => '',
            'post' => 'Llevamos a Lluna a la pelu ya varias veces y estamos encantados. Marta es un amor de persona, encantadora y maravillosa con nuestra pequeña. Mil gracias por el trato que le das siempre!',
            'review' => 5,
        ],
        20 => [
            'userName' => 'Eva Marti',
            'userImg' => '',
            'post' => 'Marta es genial. Me pasó vídeos de la primera vez que duchaba a mi 🐶 y lo trató con un mimo que sin duda, hemos vuelto! Y volveremos. Mi perrete suele tener reacciones en la piel y... Nada de nada. Todo perfecto!',
            'review' => 5,
        ],
        21 => [
            'userName' => 'Sam McClane',
            'userImg' => '',
            'post' => 'Muy contentos! Marta es super cariñosa con Mylo y muy profesional. Lo deja super guapo y lo trata super bien. Ya no vamos a otro sitio!❤️',
            'review' => 5,
        ],
    ];

    private InstagramService $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    /**
     * @return HomeView
     */
    public function build(): HomeView
    {
        $view = new HomeView();

        $publications = $this->instagramService->getPublications();

        $view->instagramPublicationImages = $publications->publicationImages;
        $view->instagramPublicationVideos = $publications->publicationVideos;
        $view->googleReviews = self::DUMMY_REVIEWS;

        return $view;
    }
}
