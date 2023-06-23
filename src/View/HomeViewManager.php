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
                'userName' => 'Enrique Mortes Parras',
                'userImg' => 'https://lh3.googleusercontent.com/a-/ACB-R5QXp1GJh0InUnpk6UQRcoln4X6brtwwhPJPMwrHfg=w36-h36-p-c0x00000000-rp-mo-br100',
                'post' => 'Marta es súper atenta y cariñosa con los animales, los trata como si fueran suyos. Mía sale contenta y preciosa, me paran por la calle para saludar a la perrita de lo guapa que está. Estoy encantado.',
                'review' => 5,
            ],
            1 => [
                'userName' => 'Aida Diaz-Agero',
                'userImg' => 'https://lh3.googleusercontent.com/a/AGNmyxYjhpM36MSt0C-EAXTlNyW7VZVlwb3uCt5f6Iq6=w36-h36-p-c0x00000000-rp-mo-br100',
                'post' => 'Estoy encantada con el trato que mi Duna ha recibido durante el baño. Marta es puro amor y paciencia y Duna necesita esos mimos. Mi pastor alemán está ya mayor sufre de artritis, piel atípica y problemas digestivos, y no es fácil bañarla y cepillarla tumbada todo el rato. Un trato exquisito. Será la pelu de Duna de confianza a partir de ahora.',
                'review' => 5,
            ],
            2 => [
                'userName' => 'Aldarah Alonso',
                'userImg' => 'https://lh3.googleusercontent.com/a/AGNmyxbF2no4FEhGrMQwJrLSbjr6tPsfiDs4fUleio5i=w36-h36-p-c0x00000000-rp-mo-br100',
                'post' => 'Como siempre, Marta es una persona increíblemente cariñosa y profesional con nuestro Tico. Cada vez que lo traigo Tico se vuelve loco y se la come a besos, y eso no es fácil. La última vez tuvo una sesión de spa de lo más relajante... totalmente recomendable. Es una artista de 5 estrellas.',
                'review' => 5,
            ],
            3 => [
                'userName' => '',
                'userImg' => '',
                'post' => '',
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
