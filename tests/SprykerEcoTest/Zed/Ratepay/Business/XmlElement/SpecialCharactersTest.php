<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Ratepay\Business\XmlElement;

use SprykerEco\Zed\Ratepay\Business\Api\SimpleXMLElement;

class SpecialCharactersTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var array
     */
    protected $characters = [
        "–" => "-",
        "´" => "'",
        "‹" => "<",
        "›" => ">",
        "‘" => "'",
        "’" => "'",
        "‚" => ",",
        "“" => '"',
        "”" => '"',
        "„" => '"',
        "‟" => '"',
        "•" => "-",
        "‒" => "-",
        "―" => "-",
        "—" => "-",
        "™" => "TM",
        "¼" => "1/4",
        "½" => "1/2",
        "¾" => "3/4"
    ];

    /**
     * @return void
     */
    public function testSpecialCharacters()
    {
        $simpleXmlElement = new SimpleXMLElement('<root></root>');
        foreach ($this->characters as $character => $expected) {
            $this->assertEquals($expected, (string)$simpleXmlElement->addCDataChild('test', $character));
        }
    }

}
