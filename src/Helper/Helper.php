<?php

declare(strict_types=1);

namespace App\Helper;

class Helper
{
    public const BROKEN_IMAGE_PATH = 'img/broken_image.png';

    public function getDifferenceBetweenDates(\DateTime $dateFrom, \DateTime $dateTo): string
    {
        $differenceText = '';
        $difference = $dateTo->diff($dateFrom);

        if ($difference->y) {
            $differenceText .= $difference->format(" %y");
            $differenceText .= $difference->y === 1 ? ' año' : ' años';
        }

        if ($difference->m) {
            if ($differenceText) {
                $differenceText .= $difference->d ? ',' : ' y';
            }

            $differenceText .= $difference->format(" %m");
            $differenceText .= $difference->m === 1 ? ' mes' : ' meses';
        }

        if ($difference->d) {
            $differenceText .= $differenceText ? ' y' : '';
            $differenceText .= $difference->format(" %d");
            $differenceText .= $difference->d === 1 ? ' día' : ' días';
        }

        return $differenceText;
    }
}
