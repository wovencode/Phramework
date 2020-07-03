<?php
namespace phramework;
use phramework;

/**
*
* MediatorInterface
*
* 
*
* @author Fhiz
*
*/
interface MediatorInterface
{
	
	public function notify(string $receiverName, string $eventName, ...$params);

}