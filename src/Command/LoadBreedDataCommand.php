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
                    'id' => 1001,
                    'name' => 'Bichón Boloñés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1002,
                    'name' => 'Bichón Maltés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1003,
                    'name' => 'Chihuahua',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1004,
                    'name' => 'Crestado Chino',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1005,
                    'name' => 'Pequeño Perro Ruso',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1006,
                    'name' => 'Petit Brabançon',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1007,
                    'name' => 'Pomerania',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1008,
                    'name' => 'Silky Terrier Australiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1009,
                    'name' => 'Spaniel Continental Enano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1010,
                    'name' => 'Spaniel Japonés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1011,
                    'name' => 'Terrier Inglés Miniatura',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 1012,
                    'name' => 'Yorkshire Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
            ],
        2 => [
                [
                    'id' => 2001,
                    'name' => 'Affenpinscher',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2002,
                    'name' => 'Basset leonado de Bretaña',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2003,
                    'name' => 'Bedlington Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2004,
                    'name' => 'Bichón Frisé',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2005,
                    'name' => 'Bichón Habanero',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2006,
                    'name' => 'Border Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2007,
                    'name' => 'Boston Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2008,
                    'name' => 'Braco de Auvernia',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2009,
                    'name' => 'Bull Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2010,
                    'name' => 'Cairn Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2011,
                    'name' => 'Carlino',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2012,
                    'name' => 'Cavalier King Charles',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2013,
                    'name' => 'Coton de Tuléar',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2014,
                    'name' => 'Dandie Dinmont Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2015,
                    'name' => 'Fox Terrier de pelo duro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2016,
                    'name' => 'Fox Terrier de pelo liso',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2017,
                    'name' => 'Grifón Belga',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2018,
                    'name' => 'Grifón de Bruselas',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2019,
                    'name' => 'Jack Rusell Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2020,
                    'name' => 'Jagd Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2021,
                    'name' => 'King Charles Spaniel',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2022,
                    'name' => 'Lakeland Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2023,
                    'name' => 'Lhasa Apso',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2024,
                    'name' => 'Lundehund Noruego',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2025,
                    'name' => 'Mudi',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2026,
                    'name' => 'Parson Rusell Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2027,
                    'name' => 'Pastor de los Pirineos',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2028,
                    'name' => 'Pastor de los Pirineos de cara rasa',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2029,
                    'name' => 'Pastor de Shetland',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2030,
                    'name' => 'Pekinés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2031,
                    'name' => 'Pequeño Lebrel Italiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2032,
                    'name' => 'Pequeño Perro León',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2033,
                    'name' => 'Perro de granja Danés y Sueco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2034,
                    'name' => 'Pinscher miniatura',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2035,
                    'name' => 'Podenco Portugués',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2036,
                    'name' => 'Pumi',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2037,
                    'name' => 'Ratonero Holandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2038,
                    'name' => 'Schipperke',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2039,
                    'name' => 'Schnauzer miniatura',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2040,
                    'name' => 'Shiba Inu',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2041,
                    'name' => 'Shih Tzu',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2042,
                    'name' => 'Skye Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2043,
                    'name' => 'Spaniel Tibetano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2044,
                    'name' => 'Spitz Japonés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2045,
                    'name' => 'Teckel',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2046,
                    'name' => 'Terrier Australiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2047,
                    'name' => 'Terrier Brasileño',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2048,
                    'name' => 'Terrier Checo',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2049,
                    'name' => 'Terrier de Manchester',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2050,
                    'name' => 'Terrier de Norfolk',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2051,
                    'name' => 'Terrier de Norwich',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2052,
                    'name' => 'Terrier de Sealyham',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2053,
                    'name' => 'Terrier Escocés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2054,
                    'name' => 'Terrier Japonés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2055,
                    'name' => 'Vallhund Sueco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2056,
                    'name' => 'Volpino Italiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2057,
                    'name' => 'Welsh Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2058,
                    'name' => 'West Highland White Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 2059,
                    'name' => 'Whippet',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
            ],
        3 => [
                [
                    'id' => 3001,
                    'name' => 'Airedale terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3002,
                    'name' => 'Alaskan Malamute',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3003,
                    'name' => 'American Staffordshire Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3004,
                    'name' => 'Ariegeois',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3005,
                    'name' => 'Barbet',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3006,
                    'name' => 'Basenji',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3007,
                    'name' => 'Basset artesiano de Normandía',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3008,
                    'name' => 'Basset azul de Gascuña',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3009,
                    'name' => 'Beagle',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3010,
                    'name' => 'Beagle-Harrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3011,
                    'name' => 'Bearded Collie',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3012,
                    'name' => 'Border Collie',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3013,
                    'name' => 'Boyero de Appenzell',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3014,
                    'name' => 'Boyero de Entlebuch',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3015,
                    'name' => 'Boyero de las Ardenas',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3016,
                    'name' => 'Braco de Ariège',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3017,
                    'name' => 'Braco de Saint Germain',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3018,
                    'name' => 'Braco del Borbonesado',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3019,
                    'name' => 'Braco Francés, Tipo Pirineos',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3020,
                    'name' => 'Braco húngaro de pelo corto',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3021,
                    'name' => 'Briquet Griffon Vendeano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3022,
                    'name' => 'Buhund noruego',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3023,
                    'name' => 'Bulldog francés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3024,
                    'name' => 'Bulldog Inglés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3025,
                    'name' => 'Caniche',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3026,
                    'name' => 'Cazador de Alces Noruego',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3027,
                    'name' => 'Chow Chow',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3028,
                    'name' => 'Cirneco del Etna',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3029,
                    'name' => 'Cocker inglés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3030,
                    'name' => 'Cocker spaniel americano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3031,
                    'name' => 'Collie de Pelo Corto',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3032,
                    'name' => 'Collie de pelo largo',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3033,
                    'name' => 'Dachsbracke de los Alpes',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3034,
                    'name' => 'Dóberman',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3035,
                    'name' => 'Drever',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3036,
                    'name' => 'Eurasier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3037,
                    'name' => 'Field spaniel',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3038,
                    'name' => 'Foxhound Americano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3039,
                    'name' => 'Gascón Saintongeois',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3040,
                    'name' => 'Gran Basset Grifón Vendeano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3041,
                    'name' => 'Grifón azul de Gascuña',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3042,
                    'name' => 'Grifón de muestra de pelo duro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3043,
                    'name' => 'Grifón de muestra eslovaco de pelo duro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3044,
                    'name' => 'Grifón leonado de Bretaña',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3045,
                    'name' => 'Grifón nivernais',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3046,
                    'name' => 'Harrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3047,
                    'name' => 'Hokkaido',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3048,
                    'name' => 'Husky siberiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3049,
                    'name' => 'Jindo Coreano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3050,
                    'name' => 'Kai',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3051,
                    'name' => 'Kelpie Australiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3052,
                    'name' => 'Kerry Blue Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3053,
                    'name' => 'Kishu',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3054,
                    'name' => 'Kooikerhondje',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3055,
                    'name' => 'Kromfohrländer',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3056,
                    'name' => 'Lagotto romagnolo',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3057,
                    'name' => 'Laika del este siberiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3058,
                    'name' => 'Laika del Oeste Siberiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3059,
                    'name' => 'Laika ruso-europeo',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3060,
                    'name' => 'Nova Scotia Duck Tolling Retriever',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3061,
                    'name' => 'Pastor australiano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3062,
                    'name' => 'Pastor Australiano Stumpy Tail',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3063,
                    'name' => 'Pastor Belga',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3064,
                    'name' => 'Pastor Bergamasco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3065,
                    'name' => 'Pastor catalán',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3066,
                    'name' => 'Pastor Croata',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3067,
                    'name' => 'Pastor de Karst',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3068,
                    'name' => 'Pastor de Picardía',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3069,
                    'name' => 'Pastor Islandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3070,
                    'name' => 'Pastor Lapón',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3071,
                    'name' => 'Pastor polaco de las llanuras',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3072,
                    'name' => 'Pastor Portugués',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3073,
                    'name' => 'Pequeño Basset Grifón Vendeano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3074,
                    'name' => 'Pequeño münsterländer',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3075,
                    'name' => 'Pequeño Sabueso Azul de Gascuña',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3076,
                    'name' => 'Perdiguero alemán',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3077,
                    'name' => 'Perdiguero frisón',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3078,
                    'name' => 'Perdiguero portugués',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3079,
                    'name' => 'Perro de agua americano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3080,
                    'name' => 'Perro de agua español',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3081,
                    'name' => 'Perro de agua irlandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3082,
                    'name' => 'Perro de Agua Portugués',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3083,
                    'name' => 'Perro de Canaán',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3084,
                    'name' => 'Perro de Caza Polaco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3085,
                    'name' => 'Perro de Osos de Carelia',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3086,
                    'name' => 'Perro de Taiwán',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3087,
                    'name' => 'Perro Finlandés de Laponia',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3088,
                    'name' => 'Perro sin Pelo Mexicano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3089,
                    'name' => 'Perro Sueco de Laponia',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3090,
                    'name' => 'Perro Tailandés con Cresta',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3091,
                    'name' => 'Pinscher Alemán',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3092,
                    'name' => 'Pinscher austríaco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3093,
                    'name' => 'Podenco Ibicenco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3094,
                    'name' => 'Porcelaine',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3095,
                    'name' => 'Puli',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3096,
                    'name' => 'Sabueso anglofrancés mediano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3097,
                    'name' => 'Sabueso Austríaco Negro y Fuego',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3098,
                    'name' => 'Sabueso Bávaro de Montaña',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3099,
                    'name' => 'Sabueso bosnio de pelo duro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3100,
                    'name' => 'Sabueso de Halden',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3101,
                    'name' => 'Sabueso de Hannover',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3102,
                    'name' => 'Sabueso de Hygen',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3103,
                    'name' => 'Sabueso de Istria de pelo corto',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3104,
                    'name' => 'Sabueso de Istria de Pelo Duro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3105,
                    'name' => 'Sabueso de Montaña de Montenegro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3106,
                    'name' => 'Sabueso de Posavatz',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3107,
                    'name' => 'Sabueso de Sangre de Baviera',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3108,
                    'name' => 'Sabueso de Schiller',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3109,
                    'name' => 'Sabueso de Småland',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3110,
                    'name' => 'Sabueso de Westfalia',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3111,
                    'name' => 'Sabueso del Tirol',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3112,
                    'name' => 'Sabueso eslovaco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3113,
                    'name' => 'Sabueso Español',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3114,
                    'name' => 'Sabueso estirio de pelo duro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3115,
                    'name' => 'Sabueso finlandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3116,
                    'name' => 'Sabueso griego',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3117,
                    'name' => 'Sabueso italiano de pelo corto',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3118,
                    'name' => 'Sabueso italiano de pelo duro',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3119,
                    'name' => 'Sabueso Noruego',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3120,
                    'name' => 'Sabueso Serbio',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3121,
                    'name' => 'Sabueso Suizo',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3122,
                    'name' => 'Sabueso Tricolor Serbio',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3123,
                    'name' => 'Saluki',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3124,
                    'name' => 'Samoyedo',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3125,
                    'name' => 'Schapendoes neerlandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3126,
                    'name' => 'Schnauzer',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3127,
                    'name' => 'Setter Inglés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3128,
                    'name' => 'Setter Irlandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3129,
                    'name' => 'Setter irlandés rojo y blanco',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3130,
                    'name' => 'Shar Pei',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3131,
                    'name' => 'Shikoku',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3132,
                    'name' => 'Sloughi',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3133,
                    'name' => 'Spaniel azul de Picardía',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3134,
                    'name' => 'Spaniel bretón',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3135,
                    'name' => 'Spaniel de Pont-Audemer',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3136,
                    'name' => 'Spaniel Francés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3137,
                    'name' => 'Spitz Alemán',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3138,
                    'name' => 'Spitz de Norrbotten',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3139,
                    'name' => 'Spitz Finlandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3140,
                    'name' => 'Springer spaniel galés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3141,
                    'name' => 'Springer spaniel inglés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3142,
                    'name' => 'Staffordshire Bull Terrier',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3143,
                    'name' => 'Sussex spaniel',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3144,
                    'name' => 'Terrier Glen de Imaal Irlandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3145,
                    'name' => 'Terrier irlandés',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3146,
                    'name' => 'Terrier irlandés de pelo suave',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3147,
                    'name' => 'Terrier Tibetano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3148,
                    'name' => 'Viringo peruano',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3149,
                    'name' => 'Welsh corgi Cardigan',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
                [
                    'id' => 3150,
                    'name' => 'Welsh Corgi Pembroke',
                    'hairTypeId' => null,
                    'hairSize' => null,
                    'img' => null,
                ],
            ],
        4 => [
            [
                'id' => 4001,
                'name' => 'Aïdi',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4002,
                'name' => 'Akita Americano',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4003,
                'name' => 'Akita inu',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4004,
                'name' => 'Antiguo Perro de Muestra Danés',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4005,
                'name' => 'Antiguo perro de Pastor inglés',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4006,
                'name' => 'Basset hound',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4007,
                'name' => 'Billy',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4008,
                'name' => 'Borzoi',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4009,
                'name' => 'Bóxer',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4010,
                'name' => 'Boyero de Flandes',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4011,
                'name' => 'Braco italiano',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4012,
                'name' => 'Braco Alemán de Pelo Corto',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4013,
                'name' => 'Braco Alemán de Pelo Duro',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4014,
                'name' => 'Braco de Weimar',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4015,
                'name' => 'Braco francés (tipo Gascuña)',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4016,
                'name' => 'Cane Corso',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4017,
                'name' => 'Cazador de Alces Sueco',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4018,
                'name' => 'Cesky fousek',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4019,
                'name' => 'Cimarrón uruguayo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4020,
                'name' => 'Clumber spaniel',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4021,
                'name' => 'Coonhound Negro y Fuego',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4022,
                'name' => 'Cuvac Eslovaco',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4023,
                'name' => 'Dálmata',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4024,
                'name' => 'Dogo Argentino',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4025,
                'name' => 'Dogo de Mallorca',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4026,
                'name' => 'Espinone',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4027,
                'name' => 'Fila de San Miguel',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4028,
                'name' => 'Galgo Español',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4029,
                'name' => 'Golden retriever',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4030,
                'name' => 'Gran boyero suizo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4031,
                'name' => 'Gran Grifón Vendeano',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4032,
                'name' => 'Gran münsterländer',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4033,
                'name' => 'Gran sabueso anglofrancés blanco y naranja',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4034,
                'name' => 'Gran Sabueso Anglo-Francés Blanco y Naranja',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4035,
                'name' => 'Gran Sabueso Anglo-Francés Blanco y Negro',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4036,
                'name' => 'Gran sabueso anglofrancés tricolor',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4037,
                'name' => 'Gran Sabueso Azul de Gascuña',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4038,
                'name' => 'Greyhound',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4039,
                'name' => 'Grifón de Muestra de Pelo Duro',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4040,
                'name' => 'Hovawart ',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4041,
                'name' => 'Komondor',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4042,
                'name' => 'Kuvasz',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4043,
                'name' => 'Labrador Retriever',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4044,
                'name' => 'Lebrel Afgano',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4045,
                'name' => 'Lebrel Escocés',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4046,
                'name' => 'Lebrel Húngaro',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4047,
                'name' => 'Mastín del Alentejo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4048,
                'name' => 'Otterhound',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4049,
                'name' => 'Pastor Alemán',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4050,
                'name' => 'Pastor Blanco Suizo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4051,
                'name' => 'Pastor de Beauce',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4052,
                'name' => 'Pastor de Brie',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4053,
                'name' => 'Pastor de la Maremma y de los Abruzos',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4054,
                'name' => 'Pastor Holandés',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4055,
                'name' => 'Pastor Polaco de Podhale',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4056,
                'name' => 'Pastor rumano de los Cárpatos',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4057,
                'name' => 'Pastor rumano de Mioritza',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4058,
                'name' => 'Perdiguero de Burgos',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4059,
                'name' => 'Perdiguero de Drente',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4060,
                'name' => 'Perro Crestado Rodesiano',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4061,
                'name' => 'Perro de Agua Frisón',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4062,
                'name' => 'Perro de Castro Laboreiro',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4063,
                'name' => 'Perro de Groenlandia',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4064,
                'name' => 'Perro de Muestra Alemán de Pelo Largo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4065,
                'name' => 'Perro de Pastor Mallorquín',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4066,
                'name' => 'Perro de San Huberto',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4067,
                'name' => 'Perro del Faraón',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4068,
                'name' => 'Perro Lobo Checoslovaco',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4069,
                'name' => 'Perro Lobo de Saarloos',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4070,
                'name' => 'Podenco canario',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4071,
                'name' => 'Pointer Inglés',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4072,
                'name' => 'Poitevino',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4073,
                'name' => 'Presa canario',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4074,
                'name' => 'Pudelpointer',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4075,
                'name' => 'Retriever de la bahía de Chesapeake',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4076,
                'name' => 'Retriever de Pelo Liso',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4077,
                'name' => 'Retriever de pelo rizado',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4078,
                'name' => 'Sabueso artesiano',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4079,
                'name' => 'Sabueso de Hamilton',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4080,
                'name' => 'Sabueso francés blanco y negro',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4081,
                'name' => 'Sabueso Francés Tricolor',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4082,
                'name' => 'Sabueso Polaco',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4083,
                'name' => 'Salud del Foxhound inglés ',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4084,
                'name' => 'Schnauzer Gigante',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4085,
                'name' => 'Setter gordon',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4086,
                'name' => 'Spaniel Picardo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4087,
                'name' => 'Terrier negro de Rusia',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 4088,
                'name' => 'Vizsla de Pelo Duro',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
        ],
        5 => [
            [
                'id' => 5001,
                'name' => 'Boyero de Berna',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5002,
                'name' => 'Broholmer',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5003,
                'name' => 'Bullmastiff',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5004,
                'name' => 'Dogo de Burdeos',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5005,
                'name' => 'Dogo del Tíbet',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5006,
                'name' => 'Gran Danés',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5007,
                'name' => 'Landseer',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5008,
                'name' => 'Lebrel Irlandés',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5009,
                'name' => 'Leonberger',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5010,
                'name' => 'Mastiff',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5011,
                'name' => 'Mastín del Pirineo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5012,
                'name' => 'Mastín Español',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5013,
                'name' => 'Mastín napolitano',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5014,
                'name' => 'Perro de la Sierra de la Estrela',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5015,
                'name' => 'Perro de montaña de los Pirineos',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5016,
                'name' => 'Perro de pastor Kangal',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5017,
                'name' => 'Rottweiler',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5018,
                'name' => 'San Bernardo',
                'hairTypeId' => null,
                'hairSize' => null,
                'img' => null,
            ],
            [
                'id' => 5019,
                'name' => 'Terranova',
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
    private DogSizeManager $dogSizeManager;
    private HairTypeManager $hairTypeManager;

    public function __construct(
        BreedManager $breedManager,
        DogSizeManager $dogSizeManager,
        Slugify $slugger,
        HairTypeManager $hairTypeManager
    ) {
        $this->slugger = $slugger;
        $this->breedManager = $breedManager;
        $this->dogSizeManager = $dogSizeManager;
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
                        $breedRows[] = [$totalResults, $dogSizeBreed['id'], $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_UPDATE, self::STATUS_ERROR];

                        continue;
                    }

                    $totalUpdateResults++;
                    $totalResults++;
                    $breedRows[] = [$totalResults, $dogSizeBreed['id'], $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_UPDATE, self::STATUS_OK];

                    continue;
                }

                try {
                    $breed = $this->breedManager->create();
                    $this->saveBreedData($breed, $dogSizeBreed, $dogSizeId, self::OPERATION_INSERT);
                } catch (\Throwable $exception) {
                    $io->error($exception->getMessage());
                    $totalErrorResults++;
                    $totalResults++;
                    $breedRows[] = [$totalResults, $dogSizeBreed['id'], $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_INSERT, self::STATUS_ERROR];

                    continue;
                }

                $totalAddResults++;
                $totalResults++;
                $breedRows[] = [$totalResults, $dogSizeBreed['id'], $dogSizeBreed['name'], $this->dogSizesNames[$dogSizeId]['headerTitle'], self::OPERATION_INSERT, self::STATUS_OK];
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

        $dogSize = $this->dogSizeManager->findOneById($dogSizeId);

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
            ['#', 'ID', 'Breed', 'DogSize', 'Operation', 'Status'],
            $breedResults['breedRows']
        );

        $io->note('The images path are auto generated from the slug');

        $io->table(
            ['Breeds', 'Updated', 'Added', 'Errors', 'Skip'],
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