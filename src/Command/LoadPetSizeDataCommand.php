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
    name: 'app:fixture:pet-size:update',
    description: 'Update PetSize data',
)]
class LoadPetSizeDataCommand extends Command
{
    protected const STATUS_OK = 'OK';
    protected const STATUS_ERROR = 'ERROR';
    protected const OPERATION_INSERT = 'INSERT';
    protected const OPERATION_UPDATE = 'UPDATE';

    //TODO: Pasar lo array de los comandos a .json file o excel

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
    private PetSizeManager $petSizeManager;

    public function __construct(PetSizeManager $petSizeManager, Slugify $slugger)
    {
        $this->slugger = $slugger;
        $this->petSizeManager = $petSizeManager;

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
        $petSizes = $this->petSizes;

        $output->writeln(\date(\DATE_W3C).' - Start process');
        $io->title('Updating PetSize table');

        $petSizesResults = $this->handlePetSizes($petSizes, $io);
        $this->renderResults($petSizesResults, $io);

        $output->writeln(\date(\DATE_W3C).' - End process');

        return Command::SUCCESS;
    }

    private function handlePetSizes(array $petSizesData, SymfonyStyle $io): array
    {
        $petSizeRows = [];
        $totalResults = 0;
        $totalAddResults = 0;
        $totalUpdateResults = 0;
        $totalErrorResults = 0;
        $totalSkipResults = 0;

        foreach ($petSizesData as $petSizeData) {
            if (
                empty($petSizeData)
                || (
                    !\array_key_exists('id', $petSizeData)
                    || !\array_key_exists('name', $petSizeData)
                    || !\array_key_exists('minWeight', $petSizeData)
                    || !\array_key_exists('maxWeight', $petSizeData)
                    || !$petSizeData['id']
                    || !$petSizeData['name']
                )
            ) {
                $totalSkipResults++;
                $totalResults++;

                continue;
            }

            $petSize = $this->petSizeManager->findOneById($petSizeData['id']);

            if ($petSize) {
                try {
                    $this->savePetSizeData($petSize, $petSizeData, self::OPERATION_UPDATE);
                } catch (\Throwable $exception) {
                    $io->error($exception->getMessage());
                    $totalErrorResults++;
                    $totalResults++;
                    $petSizeRows[] = [$totalResults, $petSizeData['id'], $petSizeData['name'], self::OPERATION_UPDATE, self::STATUS_ERROR];

                    continue;
                }

                $totalUpdateResults++;
                $totalResults++;
                $petSizeRows[] = [$totalResults, $petSizeData['id'], $petSizeData['name'], self::OPERATION_UPDATE, self::STATUS_OK];

                continue;
            }

            try {
                $petSize = $this->petSizeManager->create();
                $this->savePetSizeData($petSize, $petSizeData, self::OPERATION_INSERT);
            } catch (\Throwable $exception) {
                $io->error($exception->getMessage());
                $totalErrorResults++;
                $totalResults++;
                $petSizeRows[] = [$totalResults, $petSizeData['id'], $petSizeData['name'], self::OPERATION_INSERT, self::STATUS_ERROR];

                continue;
            }

            $totalAddResults++;
            $totalResults++;
            $petSizeRows[] = [$totalResults, $petSizeData['id'], $petSizeData['name'], self::OPERATION_INSERT, self::STATUS_OK];
        }

        return [
            'petSizeRows' => $petSizeRows,
            'totalResults' => $totalResults,
            'totalAddResults' => $totalAddResults,
            'totalUpdateResults' => $totalUpdateResults,
            'totalErrorResults' => $totalErrorResults,
            'totalSkipResults' => $totalSkipResults
        ];
    }

    /**
     * @param PetSize $petSize
     * @param array $petSizeData
     * @return void
     */
    private function savePetSizeData(PetSize $petSize, array $petSizeData, string $operation): void
    {
        $petSize->setId($petSizeData['id']);
        $petSize->setName($petSizeData['name']);
        $petSize->setMinWeight($petSizeData['minWeight']);
        $petSize->setMaxWeight($petSizeData['maxWeight']);
        $slug = $this->slugger->slugify($petSizeData['name']);
        $petSize->setSlug($slug);

        if ($operation === self::OPERATION_INSERT) {
            $petSize->setDateAdd(new \DateTime());
        }

        if ($operation === self::OPERATION_UPDATE) {
            $petSize->setDateUpd(new \DateTime());
        }

        $this->petSizeManager->save($petSize);
    }

    private function renderResults(array $petSizeResults, SymfonyStyle $io): void
    {
        $io->table(
            ['#', 'ID', 'Name', 'Operation', 'Status'],
            $petSizeResults['petSizeRows']
        );

        $io->table(
            ['PetSizes', 'Updated', 'Added', 'Errors', 'Skip'],
            [
                [
                    $petSizeResults['totalResults'],
                    $petSizeResults['totalUpdateResults'],
                    $petSizeResults['totalAddResults'],
                    $petSizeResults['totalErrorResults'],
                    $petSizeResults['totalSkipResults'],
                ],
            ]
        );

        $io->note('Incomplete data is totalized as skip');
    }
}
