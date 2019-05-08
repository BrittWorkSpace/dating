<?php
class Premium extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;

    /**
     * Gets the indoorinterests of this premium member.
     * @return array _inDoorInterests The interests stored in the premium member
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * Set the value of indoorinterests for a premium member
     * @param array _inDoorInterests indoor interests of a premium member of a website
     * @return void
     */
    public function setInDoorInterests($_inDoorInterests)
    {
        $this->_inDoorInterests = $_inDoorInterests;
    }

    /**
     * Get the outdoor interests of a premium member
     * @return array $_outDoorInterests outdoor interests of a premium member of a website
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * Set the value of outdoor interests of a premium member
     * @param array $_outDoorInterests
     * @return void
     */
    public function setOutDoorInterests($_outDoorInterests)
    {
        $this->_outDoorInterests = $_outDoorInterests;
    }
}