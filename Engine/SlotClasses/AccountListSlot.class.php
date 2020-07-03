<?php
namespace phramework;
use phramework;

/**
*
* AccountListSlot
*
* @author Fhiz
* @version 1.0
*
*/
class AccountListSlot extends NavigationSlot
{

	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(array $data)
	{
		parent::__construct($data);
	}
	
	/*
	*
	* getLink
	*
	* @return string
	*
	*/
	public function getLink()
	{
		return $this->core->notifyMediator("RouterManager", "getRouteLink", $this->data['linkTarget'], false) . "&c=" . $this->data['uniqueId'];
	}
	
	/*
	*
	* getIcon
	*
	* @return string
	*
	*/
	public function getIcon()
	{
		return Tools::buildPublicPath(self::CONST_CDN_UPLOAD, $this->data['iconName'], array(self::CONST_PUBLIC, self::CONST_MEDIA, self::CONST_AVATARS));
	}
	
	
}