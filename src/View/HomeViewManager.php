<?php

declare(strict_types=1);

namespace App\View;

use App\Model\View\HomeView;
use App\Services\InstagramService;

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
        22 => [
            'userName' => 'Alba Celda',
            'userImg' => '',
            'post' => 'Estamos encantados con Marta, siempre deja a Roco estupendo. Lo trata con mucho cariño y Roco siempre sale contento.',
            'review' => 5,
        ],
        23 => [
            'userName' => 'Marisol Delvalle',
            'userImg' => '',
            'post' => 'Hacia tiempo que buscábamos una peluquería que le supiera cortar el pelo a un yorkshire, x fin la hemos encontrado. Marta es un amor, mi bebé está feliz y súper guapo. Gracias Mqrta x tu profesionalidad y por tratarlo tan bien',
            'review' => 5,
        ],
        24 => [
            'userName' => 'majosé garcia',
            'userImg' => '',
            'post' => 'Lo recomiendo al 200%...Galia tiene alergia alimentaria aparte de que la piel la tenía fatal,y la llevo a ella cada 15 días a darle sus baños y a mejorado un montón...Marta es un amor con los peludos y con las personas...',
            'review' => 5,
        ],
        25 => [
            'userName' => 'Rosario Martinez',
            'userImg' => '',
            'post' => 'Lo trata con mucho cariño. El perro acude con Marta muy agusto, se siente como en casa.El tratamiento es de primera. Estamos encantados. 🤗',
            'review' => 5,
        ],
        26 => [
            'userName' => 'Jessica Monauni',
            'userImg' => '',
            'post' => 'Un servicio muy individual y adaptado al pero 100% ❣️',
            'review' => 5,
        ],
        27 => [
            'userName' => 'Tere Garpi',
            'userImg' => '',
            'post' => 'La mejor estilista canina que he conocido en mi vida, Marta es tan atenta y cariñosa con los perritos, como si fueran suyos. Usa los mejores productos, tiene la mejor formación y conocimientos para un resultado excelente. Es una gran suerte tenerte cerca, es una profesional maravillosa y mejor persona, además sus instalaciones son preciosas! Gracias Marta, tienes una clienta fiel para siempre. 😘',
            'review' => 5,
        ],
        28 => [
            'userName' => 'Encarna Salinas',
            'userImg' => '',
            'post' => 'Es la primera vez que llevamos a nuestro perro y tanto él cómo nosotros tuvimos un trato excelente y muy satisfactorio seguiremos yendo sin duda alguna',
            'review' => 5,
        ],
        29 => [
            'userName' => 'Valentina Vitale',
            'userImg' => '',
            'post' => 'Marta un encanto de persona, se nota su amor por su profesión....mi Kira y yo estamos contenta con ella',
            'review' => 5,
        ],
        30 => [
            'userName' => 'Juan Ra Lluch',
            'userImg' => '',
            'post' => 'Recomendable 100% El trato que les da Marta a los perritos es una pasada.',
            'review' => 5,
        ],
        31 => [
            'userName' => 'miguel sobrino',
            'userImg' => '',
            'post' => 'Excelente trabajo!!! me ha encantado como ha dejado a mi perro, es la primera vez que va y seguiremos repitiendo ☺️.',
            'review' => 5,
        ],
        32 => [
            'userName' => 'Diana Agudelo',
            'userImg' => '',
            'post' => 'Es muy amorosa con los perritos y sobre todo demasiado  delicada , mi perritos  sale súper feliz y sobre todo espectacular  su pelo súper hidratado ... los recomiendo un montón 😍😍😍',
            'review' => 5,
        ],
        33 => [
            'userName' => 'Enriqueta Alpuente',
            'userImg' => '',
            'post' => 'Hoy he llevado a mi mascota a la peluquería de Marta Vela en Puzol y me ha llamado la atención    el trato tan familiar y profesional que nos ha ofrecido .London ha salido guapisimo , con una coleta en el pelo.Ha sido una una experiencia muy agradable.Gracias por tu atención tan especial.Hasta la próxima cita,Marta.',
            'review' => 5,
        ],
        34 => [
            'userName' => 'Yolanda PH',
            'userImg' => '',
            'post' => 'Marta es una excelente estilista canina y ama a los peludos, Talko además de salir de allí precioso sale Feeeliiiiizzzz. Recomendado 100%',
            'review' => 5,
        ],
        35 => [
            'userName' => 'Tanya Coves Martorell',
            'userImg' => '',
            'post' => 'Encantada con el trato y con el servicio...volveremos a repetir sin duda!!!',
            'review' => 5,
        ],
        36 => [
            'userName' => 'Marisa Torres Gomez',
            'userImg' => '',
            'post' => 'Me ha encantado,numca habia visto a mi perrita ta guapa como hoy y me han explicado cosas que no sabia sobre el stripping. ..lo de las fotos complicado',
            'review' => 5,
        ],
        37 => [
            'userName' => 'Mercedes Iborra',
            'userImg' => '',
            'post' => 'Nuestra caniche esta encantada con Marta y nosotros con el servicio, plan de mantenimiento super recomendable!',
            'review' => 5,
        ],
        38 => [
            'userName' => 'mercedes alvaro',
            'userImg' => '',
            'post' => 'Todo lo que dicen de ella es verdad, adorable y muy buena y paciente. Café es un poco complicado, hoy hemos ido por primera vez y ella ha hecho que todo haya ido perfecto. Estamos muy contentos. Muchas gracias por tu trabajo y dedicación.',
            'review' => 5,
        ],
        39 => [
            'userName' => 'Jose Devis',
            'userImg' => '',
            'post' => 'Muy buena atención y muy buen trabajo. Calidad precio un 10. Volveremos a repetir.',
            'review' => 5,
        ],
        40 => [
            'userName' => 'Jose Amar benet',
            'userImg' => '',
            'post' => 'Trato excelente y profesionalidad',
            'review' => 5,
        ],
        41 => [
            'userName' => 'Angeles Gomez',
            'userImg' => '',
            'post' => 'Excelente, Marta es encantadora. Mil gracias por tratar con tanto amor a Eden.',
            'review' => 5,
        ],
        42 => [
            'userName' => 'Diego Jose Velazco Gutierrez',
            'userImg' => '',
            'post' => 'Excelente trabajo y muy profesional bombón siempre sale como nuevo gracias .',
            'review' => 5,
        ],
        43 => [
            'userName' => 'M. José Esteve',
            'userImg' => '',
            'post' => 'Marta es muy profesional y se nota que le gusta su trabajo y que le encantan los animales',
            'review' => 5,
        ],
        44 => [
            'userName' => 'mercedes molinero claramunt',
            'userImg' => '',
            'post' => 'Nos encanta como trabaja y como cuida Marta a coco mi pomeranian y a mi recomendadisima 100% ☺️❤️',
            'review' => 5,
        ],
        45 => [
            'userName' => 'pau romerollopis',
            'userImg' => '',
            'post' => 'Genial !!!!!',
            'review' => 5,
        ],
        46 => [
            'userName' => 'Elena Miguel Mora',
            'userImg' => '',
            'post' => 'Que suerte hemos tenido encontrando a Marta! No solo es una gran profesional, que por supuesto lo es, puedes notar la formación que tiene desde la primera visita, con una gran variedad de servicios… pero es que además ama lo que hace y se nota en su trato exquisito, en lo bonita que tiene la pelu, pero sobretodo en el amor con el que nos trata siempre… Vanilla y Mía salen encantadas y nosotros más! Gracias Marta, no nos cansaremos de recomendarte 😘❤️🤗',
            'review' => 5,
        ],
        47 => [
            'userName' => 'serranocar',
            'userImg' => '',
            'post' => 'Muy satisfecho, una gran profesional.',
            'review' => 5,
        ],
        48 => [
            'userName' => 'Lola Barranco',
            'userImg' => '',
            'post' => 'Marta es increíble con los perretes, pierden el miedo en cuanto cruzan la vallita y salen la mar de bonitos y relajados. Es una gran profesional y muy buena persona, mi Cica tuvo un accidente y estuvo llamando pendiente de su evolución. Absolutamente recomendable!!',
            'review' => 5,
        ],
        49 => [
            'userName' => 'Mireia Siles',
            'userImg' => '',
            'post' => 'Pelu totalmente recomendable: experiencia, pasión y entiende las necesidades de cada animal/dueño. Facilidades en horarios, muy limpio. Situada en lugar con fácil aparcamiento, con parque y cafetería cerca. Definitivamente, repetiremos,Gracias Marta !',
            'review' => 5,
        ],
        50 => [
            'userName' => 'Susana',
            'userImg' => '',
            'post' => 'Super recomendable!! Estamos encantados con su trabajo!!',
            'review' => 5,
        ],
        51 => [
            'userName' => 'Aida Diaz-Agero',
            'userImg' => '',
            'post' => 'Estoy encantada con el trato que mi Duna ha recibido durante el baño. Marta es puro amor y paciencia y Duna necesita esos mimos. Mi pastor alemán está ya mayor sufre de artritis, piel atípica y problemas digestivos, y no es fácil bañarla y cepillarla tumbada todo el rato. Un trato exquisito. Será la pelu de Duna de confianza a partir de ahora.',
            'review' => 5,
        ],
        52 => [
            'userName' => 'Aldarah alonso',
            'userImg' => '',
            'post' => 'Como siempre, Marta es una persona increíblemente cariñosa y profesional con nuestro Tico. Cada vez que lo traigo Tico se vuelve loco y se la come a besos, y eso no es fácil. La última vez tuvo una sesión de spa de lo más relajante... totalmente recomendable. Es una artista de 5 estrellas.',
            'review' => 5,
        ],
        53 => [
            'userName' => 'Aitor Ibáñez Villanueva',
            'userImg' => '',
            'post' => 'Muy contentos con el servicio de Higiene Básica y cosmética, el perrito tenía una pequeña herida y lo rasuro un poquito y para finalizar el servicio de ozono terapia. Volveremos un trato de 10🐶🐾🐕🐩  .',
            'review' => 5,
        ],
        54 => [
            'userName' => 'Rubén Cortés',
            'userImg' => '',
            'post' => 'Una vez al mes… Marta da un repaso a nuestra “Verita” y la deja como lo que es: hecha un bombón. No nos pilla cerca pero merece la pena, recomendable al 100x100!!!',
            'review' => 5,
        ],
        55 => [
            'userName' => 'Sara Villalba Blay',
            'userImg' => '',
            'post' => 'Cada mes mi pequeña Nora no falta a su cita con su estilista preferida. La seguimos allí donde está..ahora en Puzol que además nos viene muy bien y con un acceso y aparcamiento muy fácil. Aparte de dejarle siempre preciosa y super suave ,Nora siemprr se queda feliz y tranquila con Marta porque le trata con mucho amor y cariño. 100% recomendable!',
            'review' => 5,
        ],
        56 => [
            'userName' => 'Enrique Mortes Parras',
            'userImg' => '',
            'post' => 'Marta es súper atenta y cariñosa con los animales, los trata como si fueran suyos. Mía sale contenta y preciosa, me paran por la calle para saludar a la perrita de lo guapa que está. Estoy encantado',
            'review' => 5,
        ],
        57 => [
            'userName' => 'Felipe Garcia',
            'userImg' => '',
            'post' => 'Marta es una persona muy cercana y cariñosa con las mascotas. Fosc está encantado cada vez que lo llevamos a ella.',
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

        $view->googleReviews = $this->getReviewsWithRandomOrder(self::DUMMY_REVIEWS);

        return $view;
    }

    private function getReviewsWithRandomOrder(array $data): array
    {
        $arrayKeys = array_keys($data);
        \shuffle($arrayKeys);

        $randomOrderData = [];

        foreach($arrayKeys as $arrayKey) {
            $randomOrderData[$arrayKey] = self::DUMMY_REVIEWS[$arrayKey];
        }

        return $randomOrderData;
    }
}
