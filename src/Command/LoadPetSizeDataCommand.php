<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\PetSize;
use App\Helper\Slugify;
use App\Manager\PetSizeManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fixture:dog-size:update',
    description: 'Update DogSize data',
)]
class LoadPetSizeDataCommand extends Command
{
    protected const STATUS_OK = 'OK';
    protected const STATUS_ERROR = 'ERROR';
    protected const OPERATION_INSERT = 'INSERT';
    protected const OPERATION_UPDATE = 'UPDATE';

    protected array $petSizes = [
        [
            'id' => 1,
            'name' => 'Very small',
            'minWeight' => null,
            'maxWeight' => 4,
        ],
        [
            'id' => 2,
            'name' => 'Small',
            'minWeight' => 5,
            'maxWeight' => 10,
        ],
        [
            'id' => 3,
            'name' => 'Medium',
            'minWeight' => 11,
            'maxWeight' => 25,
        ],
        [
            'id' => 4,
            'name' => 'Big',
            'minWeight' => 26,
            'maxWeight' => 44,
        ],
        [
            'id' => 5,
            'name' => 'Very big',
            'minWeight' => 45,
            'maxWeight' => null,
        ],
    ];

    private Slugify $slugger;
    private PetSizeManager $dogSizeManager;

    public function __construct(PetSizeManager $dogSizeManager, Slugify $slugger)
    {
        $this->slugger = $slugger;
        $this->dogSizeManager = $dogSizeManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows update breeds table')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $dogSizes = $this->petSizes;

        $output->writeln(\date(\DATE_W3C).' - Start process');
        $io->title('Updating DogSize table');

        $dogSizesResults = $this->handleDogSizes($dogSizes, $io);
        $this->renderResults($dogSizesResults, $io);

        $output->writeln(\date(\DATE_W3C).' - End process');

        return Command::SUCCESS;
    }

    private function handleDogSizes(array $dogSizesData, SymfonyStyle $io): array
    {
        $dogSizeRows = [];
        $totalResults = 0;
        $totalAddResults = 0;
        $totalUpdateResults = 0;
        $totalErrorResults = 0;
        $totalSkipResults = 0;

        foreach ($dogSizesData as $dogSizeData) {
            if (
                empty($dogSizeData)
                || (
                    !\array_key_exists('id', $dogSizeData)
                    || !\array_key_exists('name', $dogSizeData)
                    || !\array_key_exists('minWeight', $dogSizeData)
                    || !\array_key_exists('maxWeight', $dogSizeData)
                    || !$dogSizeData['id']
                    || !$dogSizeData['name']
                )
            ) {
                $totalSkipResults++;
                $totalResults++;

                continue;
            }

            $dogSize = $this->dogSizeManager->findOneById($dogSizeData['id']);

            if ($dogSize) {
                try {
                    $this->saveDogSizeData($dogSize, $dogSizeData, self::OPERATION_UPDATE);
                } catch (\Throwable $exception) {
                    $io->error($exception->getMessage());
                    $totalErrorResults++;
                    $totalResults++;
                    $dogSizeRows[] = [$totalResults, $dogSizeData['id'], $dogSizeData['name'], self::OPERATION_UPDATE, self::STATUS_ERROR];

                    continue;
                }

                $totalUpdateResults++;
                $totalResults++;
                $dogSizeRows[] = [$totalResults, $dogSizeData['id'], $dogSizeData['name'], self::OPERATION_UPDATE, self::STATUS_OK];

                continue;
            }

            try {
                $dogSize = $this->dogSizeManager->create();
                $this->saveDogSizeData($dogSize, $dogSizeData, self::OPERATION_INSERT);
            } catch (\Throwable $exception) {
                $io->error($exception->getMessage());
                $totalErrorResults++;
                $totalResults++;
                $dogSizeRows[] = [$totalResults, $dogSizeData['id'], $dogSizeData['name'], self::OPERATION_INSERT, self::STATUS_ERROR];

                continue;
            }

            $totalAddResults++;
            $totalResults++;
            $dogSizeRows[] = [$totalResults, $dogSizeData['id'], $dogSizeData['name'], self::OPERATION_INSERT, self::STATUS_OK];
        }

        return [
            'dogSizeRows' => $dogSizeRows,
            'totalResults' => $totalResults,
            'totalAddResults' => $totalAddResults,
            'totalUpdateResults' => $totalUpdateResults,
            'totalErrorResults' => $totalErrorResults,
            'totalSkipResults' => $totalSkipResults
        ];
    }

    /**
     * @param PetSize $dogSize
     * @param array $dogSizeData
     * @return void
     */
    private function saveDogSizeData(PetSize $dogSize, array $dogSizeData, string $operation): void
    {
        $dogSize->setId($dogSizeData['id']);
        $dogSize->setName($dogSizeData['name']);
        $dogSize->setMinWeight($dogSizeData['minWeight']);
        $dogSize->setMaxWeight($dogSizeData['maxWeight']);
        $slug = $this->slugger->slugify($dogSizeData['name']);
        $dogSize->setSlug($slug);

        if ($operation === self::OPERATION_INSERT) {
            $dogSize->setDateAdd(new \DateTime());
        }

        if ($operation === self::OPERATION_UPDATE) {
            $dogSize->setDateUpd(new \DateTime());
        }

        $this->dogSizeManager->save($dogSize);
    }

    private function renderResults(array $dogSizeResults, SymfonyStyle $io): void
    {
        $io->table(
            ['#', 'ID', 'Name', 'Operation', 'Status'],
            $dogSizeResults['dogSizeRows']
        );

        $io->table(
            ['DogSizes', 'Updated', 'Added', 'Errors', 'Skip'],
            [
                [
                    $dogSizeResults['totalResults'],
                    $dogSizeResults['totalUpdateResults'],
                    $dogSizeResults['totalAddResults'],
                    $dogSizeResults['totalErrorResults'],
                    $dogSizeResults['totalSkipResults'],
                ],
            ]
        );

        $io->note('Incomplete data is totalized as skip');
    }
}
