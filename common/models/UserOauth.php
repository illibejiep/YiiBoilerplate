<?php

class UserOauth extends BaseUserOauth
{
    /** @return UserOauth */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}