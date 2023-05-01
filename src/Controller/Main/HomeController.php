<?php

namespace App\Controller\Main;

use App\Client\Instagram\Model\Media;
use App\Client\Instagram\Service\MediaService;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home')]
class HomeController extends AbstractController
{
    private const MAX_MEDIA_VIDEOS = 8;
    private const MAX_MEDIA_IMAGES = 8;
    private const NUMBER_OF_LAST_PUBLICATIONS = 150;
    private const FILTER_VALID_IMAGE = 'peluqueracanina ';

    public function __construct(private readonly MediaService $mediaService)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function __invoke(): Response
    {
        $instagramPublications = $this->mediaService->getLastPublications(self::NUMBER_OF_LAST_PUBLICATIONS);

        $publicationImages = [];
        $publicationVideos = [];

        foreach ($instagramPublications->getPublications() as $publication) {
            if (\stripos($publication->getCaption(), self::FILTER_VALID_IMAGE) !== false) {
                if (($publication->getMediaType() === Media::MEDIA_TYPE_IMAGE || $publication->getMediaType() === Media::MEDIA_TYPE_CAROUSEL_ALBUM)
                    && \count($publicationImages) < self::MAX_MEDIA_IMAGES) {
                    $publicationImages[] = [
                        'media_url' => $publication->getMediaURL(),
                        'permalink' => $publication->getPermalink(),
                        'date' => $publication->getTimestamp(),
                    ];
                }

                if ($publication->getMediaType() === Media::MEDIA_TYPE_VIDEO && \count($publicationVideos) < self::MAX_MEDIA_VIDEOS) {
                    $publicationVideos[] = [
                        'media_url' => $publication->getMediaURL(),
                        'permalink' => $publication->getPermalink(),
                        'date' => $publication->getTimestamp(),
                    ];
                }
            }
        }

        $reviews = [
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

        return $this->render('main/index.html.twig', [
            'instagram_publication_images' => $publicationImages,
            'instagram_publication_videos' => $publicationVideos,
            'reviews' => $reviews,
        ]);
    }
}
