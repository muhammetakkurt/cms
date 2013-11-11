<?php

class AdminFileManagerController extends BaseController {

	public function __construct()
    {
    	/*
		 *  Filter.php 'deki fileManager filtresini çalıştır. 
		 *  Kullacının fileManager izini yoksa giriş vermez.
		 */
        $this->beforeFilter('fileManager');
	
	}
	public function getIndex()
	{
		return View::make('admin.fileManager.fileManager');
	}

}