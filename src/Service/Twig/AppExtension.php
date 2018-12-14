<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 14/12/2018
 * Time: 12:05
 */

namespace App\Service\Twig;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppExtension extends AbstractController
{
    public const NB_SUMMARY_CHAR = 70;

    public function getFilters()
    {
        return [
            new \Twig_Filter('summary', function ($text) {
                // suppression des balises html
                $string = strip_tags($text);
                // si le string est supérieur à 170
                if (strlen($string) > self::NB_SUMMARY_CHAR) {
                    $stringCut = substr($string, 0, self::NB_SUMMARY_CHAR);
                    $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
                }
                return $string;
            }, ['is_safe' => ['html']])
        ];
    }

}