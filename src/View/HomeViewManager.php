<?php

declare(strict_types=1);

namespace App\View;

use App\Model\View\HomeView;
use App\Services\InstagramService;
use GuzzleHttp\Exception\GuzzleException;

class HomeViewManager
{
    private const DUMMY_REVIEWS = [
        0 => [
            'userName' => 'Tere Garpi',
            'userImg' => 'https://lh3.googleusercontent.com/a-/AD_cMMTviV9kw5Uv8x1v9pUE6Y4BntCFMzM95ddjWSVyHH-8Y2BH=s40-c-rp-mo-br100',
            'post' => 'La mejor estilista canina que he conocido en mi vida, Marta es tan atenta y cariñosa con los perritos, como si fueran suyos. Usa los mejores productos, tiene la mejor formación y conocimientos para un resultado excelente. Es una gran suerte tenerte cerca, es una profesional maravillosa y mejor persona, además sus instalaciones son preciosas! Gracias Marta, tienes una clienta fiel para siempre. 😘',
            'review' => 5,
        ],
        1 => [
            'userName' => 'Jessica Monauni',
            'userImg' => 'https://lh3.googleusercontent.com/a/AAcHTtcmfch-nwleZe9hwlQM19IyMIvAtjGdRZzGzZ8DHE0s=s40-c-rp-mo-br100',
            'post' => 'Un servicio muy individual y adaptado al pero 100% ❣️',
            'review' => 5,
        ],
        2 => [
            'userName' => 'Encarna Salinas',
            'userImg' => 'https://lh3.googleusercontent.com/a/AAcHTtdQAI95LINZ5UlvEJhjSkEbLeSmQmQDYkHzayYF3U5t=s40-c-rp-mo-br100',
            'post' => 'Es la primera vez que llevamos a nuestro perro y tanto él cómo nosotros tuvimos un trato excelente y muy satisfactorio seguiremos yendo sin duda alguna',
            'review' => 5,
        ],
        3 => [
            'userName' => 'Diana Agudelo',
            'userImg' => 'https://lh3.googleusercontent.com/a/AAcHTtdkHIZBf-S6oN4ZQSpY0U2x6GB6OhC4YGm8jKhXaOLc=s40-c-rp-mo-br100',
            'post' => 'Es muy amorosa con los perritos y sobre todo demasiado  delicada , mi perritos  sale súper feliz y sobre todo espectacular  su pelo súper hidratado ... los recomiendo un montón 😍😍😍',
            'review' => 5,
        ],
        4 => [
            'userName' => 'Enriqueta Alpuente',
            'userImg' => '',
            'post' => 'Hoy he llevado a mi mascota a la peluquería de Marta Vela en Puzol y me ha llamado la atención    el trato tan familiar y profesional que nos ha ofrecido .London ha salido guapisimo , con una coleta en el pelo.Ha sido una una experiencia muy agradable.Gracias por tu atención tan especial.Hasta la próxima cita,Marta.',
            'review' => 5,
        ],
        5 => [
            'userName' => 'Enrique Mortes Parras',
            'userImg' => 'https://lh3.googleusercontent.com/a-/ACB-R5QXp1GJh0InUnpk6UQRcoln4X6brtwwhPJPMwrHfg=w36-h36-p-c0x00000000-rp-mo-br100',
            'post' => 'Marta es súper atenta y cariñosa con los animales, los trata como si fueran suyos. Mía sale contenta y preciosa, me paran por la calle para saludar a la perrita de lo guapa que está. Estoy encantado.',
            'review' => 5,
        ],
        6 => [
            'userName' => 'Aida Diaz-Agero',
            'userImg' => 'https://lh3.googleusercontent.com/a/AGNmyxYjhpM36MSt0C-EAXTlNyW7VZVlwb3uCt5f6Iq6=w36-h36-p-c0x00000000-rp-mo-br100',
            'post' => 'Estoy encantada con el trato que mi Duna ha recibido durante el baño. Marta es puro amor y paciencia y Duna necesita esos mimos. Mi pastor alemán está ya mayor sufre de artritis, piel atípica y problemas digestivos, y no es fácil bañarla y cepillarla tumbada todo el rato. Un trato exquisito. Será la pelu de Duna de confianza a partir de ahora.',
            'review' => 5,
        ],
        7 => [
            'userName' => 'Aldarah Alonso',
            'userImg' => 'https://lh3.googleusercontent.com/a/AGNmyxbF2no4FEhGrMQwJrLSbjr6tPsfiDs4fUleio5i=w36-h36-p-c0x00000000-rp-mo-br100',
            'post' => 'Como siempre, Marta es una persona increíblemente cariñosa y profesional con nuestro Tico. Cada vez que lo traigo Tico se vuelve loco y se la come a besos, y eso no es fácil. La última vez tuvo una sesión de spa de lo más relajante... totalmente recomendable. Es una artista de 5 estrellas.',
            'review' => 5,
        ],
    ];

    private InstagramService $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    /**
     * @throws GuzzleException
     */
    public function build(): HomeView
    {
        $view = new HomeView();

        $instagramPublications = $this->instagramService->getMedia();

        $view->instagramPublicationImages = $instagramPublications['publication_images'];
        $view->instagramPublicationVideos = $instagramPublications['publication_videos'];
        $view->googleReviews = self::DUMMY_REVIEWS;

        return $view;
    }
}
