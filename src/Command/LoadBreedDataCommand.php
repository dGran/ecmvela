<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Breed;
use App\Helper\Slugify;
use App\Manager\BreedManager;
use App\Manager\DogSizeManager;
use App\Manager\HairTypeManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fixture:breed:update',
    description: 'Update Breed data',
)]
class LoadBreedDataCommand extends Command
{
    protected const STATUS_OK = 'OK';
    protected const STATUS_ERROR = 'ERROR';
    protected const OPERATION_INSERT = 'INSERT';
    protected const OPERATION_UPDATE = 'UPDATE';

    protected array $breedsIndexedByDogSizeId = [
        1 => [
                [
                    'id' => 101,
                    'name' => 'Bichón Boloñés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 102,
                    'name' => 'Bichón Maltés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 103,
                    'name' => 'Chihuahua',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 104,
                    'name' => 'Crestado Chino',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 105,
                    'name' => 'Pequeño Perro Ruso',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 106,
                    'name' => 'Petit Brabançon',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 107,
                    'name' => 'Pomerania',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 108,
                    'name' => 'Silky Terrier Australiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 109,
                    'name' => 'Spaniel Continental Enano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 110,
                    'name' => 'Spaniel Japonés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 111,
                    'name' => 'Terrier Inglés Miniatura',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 112,
                    'name' => 'Yorkshire Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
            ],
        2 => [
                [
                    'id' => 201,
                    'name' => 'Affenpinscher',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 202,
                    'name' => 'Basset leonado de Bretaña',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 203,
                    'name' => null,
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
            ],
        3 => [
                [
                    'id' => 301,
                    'name' => null,
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
            ],
        4 => [
                [
                    'id' => 401,
                    'name' => null,
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
        ],
        5 => [
                [
                    'id' => 501,
                    'name' => null,
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
        ],
    ];
    protected array $dogSizesNames = [
        1 => ['imageFolder' => 'very-small', 'headerTitle' => 'Muy pequeño'],
        2 => ['imageFolder' => 'small', 'headerTitle' => 'Pequeño'],
        3 => ['imageFolder' => 'medium', 'headerTitle' => 'Mediano'],
        4 => ['imageFolder' => 'big', 'headerTitle' => 'Grande'],
        5 => ['imageFolder' => 'very-big', 'headerTitle' => 'Muy grande']
    ];

    private Slugify $slugger;
    private BreedManager $breedManager;
    private DogSizeManager $dogSizerManager;
    private HairTypeManager $hairTypeManager;

    public function __construct(
        BreedManager $breedManager,
        DogSizeManager $dogSizerManager,
        Slugify $slugger,
        HairTypeManager $hairTypeManager
    ) {
        $this->slugger = $slugger;
        $this->breedManager = $breedManager;
        $this->dogSizerManager = $dogSizerManager;
        $this->hairTypeManager = $hairTypeManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('dogSizeId', null, InputOption::VALUE_OPTIONAL, 'Dog size ID')
            ->setHelp('This command allows update breeds table')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $specifiedDogSizeId = (int)$input->getOption('dogSizeId');
        $dogSizeBreedsIndexedByDogSizeId = $this->breedsIndexedByDogSizeId;

        if ($specifiedDogSizeId && !\array_key_exists($specifiedDogSizeId, $dogSizeBreedsIndexedByDogSizeId)) {
            $io->error('dogSizeId not found!. Abort process');

            return Command::FAILURE;
        }

        $output->writeln(\date(\DATE_W3C).' - Start process');
        $io->title('Updating Breed table');

        if ($specifiedDogSizeId) {
            $dogSizeBreedsIndexedByDogSizeId = [$specifiedDogSizeId => $dogSizeBreedsIndexedByDogSizeId[$specifiedDogSizeId]];
        }

        $breedResults = $this->handleBreeds($dogSizeBreedsIndexedByDogSizeId, $io);
        $this->renderResults($breedResults, $io);

        $output->writeln(\date(\DATE_W3C).' - End process');

        return Command::SUCCESS;
    }

    private function handleBreeds(array $dogSizeBreedsIndexedByDogSizeId, SymfonyStyle $io): array
    {
        $breedRows = [];
        $totalResults = 0;
        $totalAddResults = 0;
        $totalUpdateResults = 0;
        $totalErrorResults = 0;
        $totalSkipResults = 0;

        foreach ($dogSizeBreedsIndexedByDogSizeId as $dogSizeId => $dogSizeBreeds) {
            foreach ($dogSizeBreeds as $key => $dogSizeBreed) {
                if (
                    empty($dogSizeBreed)
                    || (
                        !\array_key_exists('id', $dogSizeBreed)
                        || !\array_key_exists('name', $dogSizeBreed)
                        || !\array_key_exists('hairTypeId', $dogSizeBreed)
                        || !\array_key_exists('hairSize', $dogSizeBreed)
                        || !\array_key_exists('img', $dogSizeBreed)
                        || !$dogSizeBreed['id']
                        || !$dogSizeBreed['name']
                    )
                ) {
                    $totalSkipResults++;
                    $totalResults++;

                    continue;
                }

                $breed = $this->breedManager->findOneById($dogSizeBreed['id']);

                if ($breed) {
                    try {
                        $this->saveBreedData($breed, $dogSizeBreed, $dogSizeId, self::OPERATION_UPDATE);
                    } catch (\Throwable $exception) {
                        $io->error($exception->getMessage());
                        $totalErrorResults++;
                        $totalResults++;
                        $breedRows[] = [$totalResults, $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_UPDATE, self::STATUS_ERROR];

                        continue;
                    }

                    $totalUpdateResults++;
                    $totalResults++;
                    $breedRows[] = [$totalResults, $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_UPDATE, self::STATUS_OK];

                    continue;
                }

                try {
                    $breed = $this->breedManager->create();
                    $this->saveBreedData($breed, $dogSizeBreed, $dogSizeId, self::OPERATION_INSERT);
                } catch (\Throwable $exception) {
                    $io->error($exception->getMessage());
                    $totalErrorResults++;
                    $totalResults++;
                    $breedRows[] = [$totalResults, $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_INSERT, self::STATUS_ERROR];

                    continue;
                }

                $totalAddResults++;
                $totalResults++;
                $breedRows[] = [$totalResults, $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_INSERT, self::STATUS_OK];
            }
        }

        return [
            'breedRows' => $breedRows,
            'totalResults' => $totalResults,
            'totalAddResults' => $totalAddResults,
            'totalUpdateResults' => $totalUpdateResults,
            'totalErrorResults' => $totalErrorResults,
            'totalSkipResults' => $totalSkipResults
        ];
    }

    /**
     * @param Breed $breed
     * @param array $dogSizeBreed
     * @param int $dogSizeId
     * @return void
     */
    private function saveBreedData(Breed $breed, array $dogSizeBreed, int $dogSizeId, string $operation): void
    {
        $breed->setId($dogSizeBreed['id']);
        $breed->setName($dogSizeBreed['name']);

        $dogSize = $this->dogSizerManager->findOneById($dogSizeId);

        if (!$dogSize) {
            return;
        }

        $breed->setDogSize($dogSize);

        if (!$dogSizeBreed['hairTypeId']) {
            $breed->setHairType(null);
        }

        if ($dogSizeBreed['hairTypeId']) {
            $hairType = $this->hairTypeManager->findOneById($dogSizeBreed['hairTypeId']);

            if ($hairType) {
                $breed->setHairType($hairType);
            }
        }

        $slug = $this->slugger->slugify($dogSizeBreed['name']);
        $breed->setSlug($slug);
        $image = $dogSizeBreed['img'];

        if (!$dogSizeBreed['img']) {
            $image = 'img/breeds/'.$this->dogSizesNames[$dogSizeId]['imageFolder'].'/'.$slug.'.jpeg';
        }

        $breed->setImg($image);

        if ($operation === self::OPERATION_INSERT) {
            $breed->setDateAdd(new \DateTime());
        }

        if ($operation === self::OPERATION_UPDATE) {
            $breed->setDateUpd(new \DateTime());
        }

        $this->breedManager->save($breed);
    }

    private function renderResults(array $breedResults, SymfonyStyle $io): void
    {
        $io->table(
            ['#', 'Breed', 'DogSize', 'Operation', 'Status'],
            $breedResults['breedRows']
        );

        $io->note('The images path are auto generated from the slug');

        $io->table(
            ['Breeds', 'Updated', 'Added', 'Erros', 'Skip'],
            [
                [
                    $breedResults['totalResults'],
                    $breedResults['totalUpdateResults'],
                    $breedResults['totalAddResults'],
                    $breedResults['totalErrorResults'],
                    $breedResults['totalSkipResults'],
                ],
            ]
        );

        $io->note('Incomplete data is totalized as skip');
    }
}
