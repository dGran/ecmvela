<?php

namespace App\Controller\Main;

use App\Model\Instagram\Media;
use App\Services\InstagramService;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private const MAX_MEDIA_ITEMS = 8;

    public function __construct(private readonly InstagramService $instagramService)
    {
    }

    /**
     * @throws GuzzleException
     */
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $instagramPublications = $this->instagramService->getLastPublications(100);

        $publicationImages = [];
        $publicationVideos = [];

        foreach ($instagramPublications->getPublications() as $publication) {
            if ($publication->getMediaType() === Media::MEDIA_TYPE_IMAGE && \count($publicationImages) < self::MAX_MEDIA_ITEMS) {
                $publicationImages[] = $publication->getMediaURL();
            }

            if ($publication->getMediaType() === Media::MEDIA_TYPE_VIDEO && \count($publicationVideos) < self::MAX_MEDIA_ITEMS) {
                $publicationVideos[] = $publication->getMediaURL();
            }
        }

        return $this->render('main/index.html.twig', [
            'instagram_publication_images' => $publicationImages,
            'instagram_publication_videos' => $publicationVideos,
        ]);
    }

    #[Route('/reserva-de-citas', name: 'appointments')]
    public function appointments(): Response
    {
        return $this->render('main/appointments/index.html.twig', []);
    }

    #[Route('/contacto', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('main/contact/index.html.twig', []);
    }

    #[Route('/trabajos', name: 'works')]
    public function works(): Response
    {
        return $this->render('main/works/index.html.twig', []);
    }

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('main/blog/index.html.twig', []);
    }

    #[Route('/aviso-legal', name: 'legal_warning')]
    public function legalWarning(): Response
    {
        return $this->render('main/legal/legal-warning.html.twig', []);
    }

    #[Route('/politica-de-privacidad', name: 'privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('main/legal/privacy-policy.html.twig', []);
    }

    #[Route('/politica-de-cookies', name: 'cookies_policy')]
    public function cookiesPolicy(): Response
    {
        return $this->render('main/legal/cookies-policy.html.twig', []);
    }
}
