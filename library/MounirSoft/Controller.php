<?php

namespace MounirSoft;

abstract class Controller {
	
	protected $_view;
	
	
	public function getView() {
		return $this->_view;
	}
	
	final public function setView($view) {
		$this->_view = $view;
	}
	
}