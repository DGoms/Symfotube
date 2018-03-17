<?php

namespace AppBundle\Utils;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Naming\Polyfill;

/**
 * UniqidNamer.
 *
 * @author Emmanuel Vella <vella.emmanuel@gmail.com>
 */
class UniqidNamer implements NamerInterface
{
    use Polyfill\FileExtensionTrait;

    /**
     * {@inheritdoc}
     */
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $name = str_replace('.', '', uniqid('', true));

        if ($extension = $this->getExtension($file)) {
            $name = sprintf('%s.%s', $name, $extension);
        }

        return $name;
    }
}
