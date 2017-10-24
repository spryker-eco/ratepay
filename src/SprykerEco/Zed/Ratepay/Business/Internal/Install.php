<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Ratepay\Business\Internal;

use Generated\Shared\Transfer\LocaleTransfer;
use SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToGlossaryInterface;
use SprykerEco\Zed\Ratepay\RatepayConfig;
use Symfony\Component\Yaml\Yaml;

class Install implements InstallInterface
{
    const CREATED = 'created';
    const TRANSLATIONS = 'translations';
    const TRANSLATION = 'translation';
    const UPDATED = 'updated';
    const TEXT = 'text';
    /**
     * @var \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToGlossaryInterface
     */
    protected $glossary;

    /**
     * @var \SprykerEco\Zed\Ratepay\RatepayConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\Ratepay\Dependency\Facade\RatepayToGlossaryInterface $glossary
     * @param \SprykerEco\Zed\Ratepay\RatepayConfig $config
     */
    public function __construct(RatepayToGlossaryInterface $glossary, RatepayConfig $config)
    {
        $this->glossary = $glossary;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function install()
    {
        $fileName = $this->config->getTranslationFilePath();
        $translations = $this->parseYamlFile($fileName);

        return $this->installKeysAndTranslations($translations);
    }

    /**
     * @param string $filePath
     *
     * @return array
     */
    protected function parseYamlFile($filePath)
    {
        return Yaml::parse(file_get_contents($filePath));
    }

    /**
     * @param array $translations
     *
     * @return array
     */
    protected function installKeysAndTranslations(array $translations)
    {
        $results = [];
        foreach ($translations as $keyName => $data) {
            $results[$keyName][self::CREATED] = false;
            if (!$this->glossary->hasKey($keyName)) {
                $this->glossary->createKey($keyName);
                $results[$keyName][self::CREATED] = true;
            }

            foreach ($data[self::TRANSLATIONS] as $localeName => $text) {
                $results[$keyName][self::TRANSLATION][$localeName] = $this->addTranslation($localeName, $keyName, $text);
            }
        }

        return $results;
    }

    /**
     * @param string $localeName
     * @param string $keyName
     * @param string $text
     *
     * @return array
     */
    protected function addTranslation($localeName, $keyName, $text)
    {
        $locale = new LocaleTransfer();
        $locale->setLocaleName($localeName);
        $translation = [];

        $translation[self::TEXT] = $text;
        $translation[self::CREATED] = false;
        $translation[self::UPDATED] = false;

        if (!$this->glossary->hasTranslation($keyName, $locale)) {
            $this->glossary->createAndTouchTranslation($keyName, $locale, $text, true);
            $translation[self::CREATED] = true;

            return $translation;
        }

        $this->glossary->updateAndTouchTranslation($keyName, $locale, $text, true);
        $translation[self::UPDATED] = true;

        return $translation;
    }
}
