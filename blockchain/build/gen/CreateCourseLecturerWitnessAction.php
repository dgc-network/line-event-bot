<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: payload.proto

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>CreateCourseLecturerWitnessAction</code>
 */
class CreateCourseLecturerWitnessAction extends \Google\Protobuf\Internal\Message
{
    /**
     *c_l_w_id int NOT NULL AUTO_INCREMENT,
     *course_id int NOT NULL,
     *lecturer_witness_id int NOT NULL,
     *expired_date int NOT NULL,
     *is_witness boolean NOT NULL,
     *
     * Generated from protobuf field <code>int32 c_l_w_id = 1;</code>
     */
    protected $c_l_w_id = 0;
    /**
     * Generated from protobuf field <code>int32 course_id = 2;</code>
     */
    protected $course_id = 0;
    /**
     * Generated from protobuf field <code>int32 lecturer_witness_id = 3;</code>
     */
    protected $lecturer_witness_id = 0;
    /**
     * Generated from protobuf field <code>int32 expired_date = 4;</code>
     */
    protected $expired_date = 0;
    /**
     * Generated from protobuf field <code>bool is_witness_id = 5;</code>
     */
    protected $is_witness_id = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $c_l_w_id
     *          c_l_w_id int NOT NULL AUTO_INCREMENT,
     *          course_id int NOT NULL,
     *          lecturer_witness_id int NOT NULL,
     *          expired_date int NOT NULL,
     *          is_witness boolean NOT NULL,
     *     @type int $course_id
     *     @type int $lecturer_witness_id
     *     @type int $expired_date
     *     @type bool $is_witness_id
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Payload::initOnce();
        parent::__construct($data);
    }

    /**
     *c_l_w_id int NOT NULL AUTO_INCREMENT,
     *course_id int NOT NULL,
     *lecturer_witness_id int NOT NULL,
     *expired_date int NOT NULL,
     *is_witness boolean NOT NULL,
     *
     * Generated from protobuf field <code>int32 c_l_w_id = 1;</code>
     * @return int
     */
    public function getCLWId()
    {
        return $this->c_l_w_id;
    }

    /**
     *c_l_w_id int NOT NULL AUTO_INCREMENT,
     *course_id int NOT NULL,
     *lecturer_witness_id int NOT NULL,
     *expired_date int NOT NULL,
     *is_witness boolean NOT NULL,
     *
     * Generated from protobuf field <code>int32 c_l_w_id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setCLWId($var)
    {
        GPBUtil::checkInt32($var);
        $this->c_l_w_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 course_id = 2;</code>
     * @return int
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Generated from protobuf field <code>int32 course_id = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setCourseId($var)
    {
        GPBUtil::checkInt32($var);
        $this->course_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 lecturer_witness_id = 3;</code>
     * @return int
     */
    public function getLecturerWitnessId()
    {
        return $this->lecturer_witness_id;
    }

    /**
     * Generated from protobuf field <code>int32 lecturer_witness_id = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setLecturerWitnessId($var)
    {
        GPBUtil::checkInt32($var);
        $this->lecturer_witness_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 expired_date = 4;</code>
     * @return int
     */
    public function getExpiredDate()
    {
        return $this->expired_date;
    }

    /**
     * Generated from protobuf field <code>int32 expired_date = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setExpiredDate($var)
    {
        GPBUtil::checkInt32($var);
        $this->expired_date = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bool is_witness_id = 5;</code>
     * @return bool
     */
    public function getIsWitnessId()
    {
        return $this->is_witness_id;
    }

    /**
     * Generated from protobuf field <code>bool is_witness_id = 5;</code>
     * @param bool $var
     * @return $this
     */
    public function setIsWitnessId($var)
    {
        GPBUtil::checkBool($var);
        $this->is_witness_id = $var;

        return $this;
    }

}

