<?php
/**
 * Created by PhpStorm.
 * User: silvio
 * Date: 21.12.2016.
 * Time: 19:36
 */

namespace AppBundle\Helper;

/**
 * TODO: RENAME
 *
 * Class JsonHelper
 * @package AppBundle\Helper
 */
final class JsonHelper
{
    const FAILURE      = -1;
    const EMPTY_RESULT = 0;
    const SUCCESS      = 1;

    private $status;

    private $result;

    private function __construct($result, $status)
    {
        $this->status = $status;
        $this->result = $result;
    }

    /**
     * Returns decoded JSON and status.
     * Decodes JSON string and returns corresponding status.
     * <pre>
     * Status list:
     *      -1 - error occurred during decoding
     *       1 - JSON was decoded successfully
     *       2 - JSON was decoded successfully, but result is empty
     * </pre>
     *
     * @param string $jsonString String containing data in JSON format.
     * @param bool   $asArray    When TRUE, returned objects will be converted into associative arrays.
     *
     * @return JsonHelper Object containing value and status.
     */
    public static function decode($jsonString, $asArray = false)
    {
        $status      = self::SUCCESS;
        $decodedJson = json_decode($jsonString, $asArray);

        if ($decodedJson === null) {
            if (json_last_error() !== JSON_ERROR_NONE) {
                $status = self::EMPTY_RESULT;
            } else {
                $status = self::FAILURE;
            }
        }

        return new self($decodedJson, $status);
    }

//======================================================================================================================
// GETTERS & SETTERS
//======================================================================================================================

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return \stdClass
     */
    public function getResult()
    {
        return $this->result;
    }
}
