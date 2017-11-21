<?php


namespace Zrcms\Content\Model;


class ChangeLogEvent
{
    protected $dateTime;
    protected $userId;
    protected $userName;
    protected $actionId;
    protected $actionName;
    protected $resourceId;
    protected $resourceName;
    protected $resourceTypeName;
    protected $metaData = [];

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param mixed $dateTime
     */
    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * @param mixed $actionId
     */
    public function setActionId($actionId)
    {
        $this->actionId = $actionId;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @param mixed $actionName
     */
    public function setActionName($actionName)
    {
        $this->actionName = $actionName;
    }

    /**
     * @return mixed
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @param mixed $resourceId
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;
    }

    /**
     * @return mixed
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @param mixed $resourceName
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
    }

    /**
     * @return mixed
     */
    public function getResourceTypeName()
    {
        return $this->resourceTypeName;
    }

    /**
     * @param mixed $resourceTypeName
     */
    public function setResourceTypeName($resourceTypeName)
    {
        $this->resourceTypeName = $resourceTypeName;
    }

    /**
     * @return mixed
     */
    public function getMetaData(): array
    {
        return $this->metaData;
    }

    /**
     * @param mixed $metaData
     */
    public function setMetaData(array $metaData)
    {
        $this->metaData = $metaData;
    }

}
