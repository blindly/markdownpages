<?php
/**
 * Interface for Presenter
 */

interface iPresenter {
	
	public function __construct($webRequest);
	public function dispatchAction($webRequest);
	
}

?>