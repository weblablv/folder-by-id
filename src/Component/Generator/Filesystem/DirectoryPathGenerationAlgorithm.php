<?php

namespace WebLabLv\Component\Generator\Filesystem;

final class DirectoryPathGenerationAlgorithm
{
    const MAXIMUM_ALLOWED_DEPTH                = 3;
    const MAXIMUM_DIRECTORIES_ALLOWED_IN_DEPTH = 500;

    /**
     * @param int $id
     * @return string
     */
    public static function getRelativeDirectoryPathById(int $id): string
    {
        $depth = self::MAXIMUM_ALLOWED_DEPTH;
        $path  = null;

        while(0 !== $depth) {
            $step           = pow(self::MAXIMUM_DIRECTORIES_ALLOWED_IN_DEPTH, $depth);
            $stepPath       = null;
            $currentAttempt = 0;

            while(null === $stepPath) {
                $minStepValue = ( $step * $currentAttempt ) + 1;
                $maxStepValue = $step * ( $currentAttempt + 1 );

                if ($id >= $minStepValue && $id <= $maxStepValue) {
                    $stepPath = sprintf('%s-%s', $minStepValue, $maxStepValue);
                }
                ++$currentAttempt;
            }

            $path    .= DIRECTORY_SEPARATOR . $stepPath;
            $stepPath = null;

            --$depth;
        }

        return $path;
    }
}
